<?php 
    require 'Libraries/html2pdf/vendor/autoload.php';
    use Spipu\Html2Pdf\Html2Pdf;

    require 'Libraries/NumbreToLetter/numberToLetter.php';

    class Employees extends Controllers
    {
        public function __construct()
        {
            parent::__construct();
            session_start();

            // session_regenerate_id(true);

            if (empty($_SESSION['login'])) {
                header('Location: ' . base_url() . '/login');
                die();
            }

            getPermisos(MEMPLOYEES);
        }
    
		public function view()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_tag'] = NOMBRE_EMPRESA;
			$data['page_title'] = "Empleado <small>".NOMBRE_EMPRESA."</small>";
			$data['page_name'] = "employees";
			$data['page_functions_js'] = "person/fnts_employee.js";
			$this->views->getView($this,"employees",$data);
		}

        public function upsertEmployee()
        {
            $arrResponse = ['status' => false, 'msg' => 'No se pudo procesar la solicitud.'];

            try {
                if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                    throw new Exception('Método no permitido.');
                }

                $data = $this->validateEmployeeForm($_POST);

                $isNew = ($data['idEmployee'] === 0);

                if ($isNew && empty($_SESSION['permisosMod']['w'])) {
                    throw new Exception('No tiene permisos para registrar empleados.');
                }

                if (!$isNew && empty($_SESSION['permisosMod']['u'])) {
                    throw new Exception('No tiene permisos para actualizar empleados.');
                }

                $this->db->begin();

                if ($isNew) {
                    $employeeId = $this->model->insertEmployee(
                        $data['idUser'],
                        $data['name'],
                        $data['lastName'],
                        $data['identification'],
                        $data['passport'],
                        $data['empType'],
                        $data['ocupationId']
                    );

                    if (!$employeeId || intval($employeeId) <= 0) {
                        throw new Exception('No fue posible registrar el empleado.');
                    }
                } else {
                    $updated = $this->model->updateEmployee(
                        $data['idEmployee'],
                        $data['name'],
                        $data['lastName'],
                        $data['identification'],
                        $data['passport'],
                        $data['empType'],
                        $data['ocupationId']
                    );
                    if ($updated === 'identificacionExist') {
                        throw new Exception('La identificación ya existe.');
                    }
                    if ($updated === 'passportExist') {
                        throw new Exception('El pasaporte ya existe.');
                    }
                    if (!$updated) {
                        throw new Exception('No fue posible actualizar el empleado.');
                    }

                    $employeeId = $data['idEmployee'];
                }

                $savedWorkdays = $this->model->replaceEmployeeWorkdays($employeeId, $data['workdays']);

                if (!$savedWorkdays) {
                    throw new Exception('No fue posible guardar los días de trabajo.');
                }

                $this->db->commit();

                $arrResponse = [
                    'status' => true,
                    'msg' => $isNew
                        ? 'Datos guardados correctamente.'
                        : 'Datos actualizados correctamente.'
                ];

            } catch (Exception $e) {
                if ($this->db->inTransaction()) {
                    $this->db->rollback();
                }

                $arrResponse = [
                    'status' => false,
                    'msg' => $e->getMessage()
                ];
            }

            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            die();
        }

        private function validateEmployeeForm(array $post): array
        {
            $idEmployee = isset($post['idEmployee']) ? intval($post['idEmployee']) : 0;
            $idUser = isset($_SESSION['idUser']) ? intval($_SESSION['idUser']) : 0;

            $identification = (!empty($post['txtIdentification']) && trim($post['txtIdentification']) !== '')
            ? preg_replace('/[^0-9]/', '', strClean($post['txtIdentification']))
            : null;

            $passport = isset($post['txtPassport']) && trim($post['txtPassport']) !== ''
            ? strtoupper(trim(strClean($post['txtPassport'])))
            : null;

            $name = isset($post['txtName'])
                ? strtoupper(trim(strClean($post['txtName'])))
                : '';

            $lastName = isset($post['txtLastName'])
                ? strtoupper(trim(strClean($post['txtLastName'])))
                : '';

            $empType = isset($post['intEmpType']) ? intval($post['intEmpType']) : 0;

            $ocupation = isset($post['intOcupation']) ? intval($post['intOcupation']) : 0;

            if ($name === '' || $lastName === '') {
                throw new Exception('El nombre y el apellido son obligatorios.');
            }

            if ($empType <= 0) {
                throw new Exception('Debe seleccionar un tipo de empleado válido.');
            }

            $workdays = $this->parseWorkdays($post);

            return [
                'idEmployee'     => $idEmployee,
                'idUser'         => $idUser,
                'identification' => $identification,
                'passport'       => $passport,
                'name'           => $name,
                'lastName'       => $lastName,
                'empType'        => $empType,
                'ocupationId'    => $ocupation,
                'workdays'       => $workdays
            ];
        }

        private function parseWorkdays(array $post): array
        {
            $arrDays  = isset($post['workDays']) && is_array($post['workDays']) ? $post['workDays'] : [];
            $arrStart = isset($post['startTime']) && is_array($post['startTime']) ? $post['startTime'] : [];
            $arrEnd   = isset($post['endTime']) && is_array($post['endTime']) ? $post['endTime'] : [];

            if (empty($arrDays)) {
                throw new Exception('Debe seleccionar al menos un día de trabajo.');
            }

            $workdays = [];

            foreach ($arrDays as $dayId) {
                $dayId = intval($dayId);

                if ($dayId <= 0) {
                    throw new Exception('Se recibió un día inválido.');
                }

                $startRaw = isset($arrStart[$dayId]) ? trim($arrStart[$dayId]) : '';
                $endRaw   = isset($arrEnd[$dayId]) ? trim($arrEnd[$dayId]) : '';

                if ($startRaw === '' || $endRaw === '') {
                    throw new Exception('Debe completar hora de inicio y hora de fin para cada día seleccionado.');
                }

                $startTime = $this->normalizeTime($startRaw);
                $endTime   = $this->normalizeTime($endRaw);

                if ($startTime >= $endTime) {
                    throw new Exception('La hora de fin debe ser mayor que la hora de inicio.');
                }

                $workdays[] = [
                    'day_id'     => $dayId,
                    'start_time' => $startTime,
                    'end_time'   => $endTime
                ];
            }

            return $workdays;
        }

        private function normalizeTime(string $time): string
        {
            $timestamp = strtotime($time);

            if ($timestamp === false) {
                throw new Exception("Formato de hora inválido: {$time}");
            }

            return date('H:i:s', $timestamp);
        }

		public function getEmployees(){
            if($_SESSION['permisosMod']['r']){
                $idUsuario = intval($_SESSION['idUser']);
                $arrData = $this->model->selectEmployees($idUsuario);

                for ($i=0; $i < count($arrData); $i++) {
                    // status como texto simple
                    $arrData[$i]['status'] = $arrData[$i]['status'] == 1 ? 'Activo' : 'Inactivo';

                    // opciones como flags
                    $arrData[$i]['canView']   = $_SESSION['permisosMod']['r'] ? true : false;
                    $arrData[$i]['canEdit']   = $_SESSION['permisosMod']['u'] ? true : false;
                    $arrData[$i]['canDelete'] = $_SESSION['permisosMod']['d'] ? true : false;
                }

                header('Content-Type: application/json');
                echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            }
            die();
        }


		public function getEmployee($employeeId)
        {
            if (!$_SESSION['permisosMod']['r']) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'No tiene permisos para ver esta información.'
                ], JSON_UNESCAPED_UNICODE);
                die();
            }

            $idEmployee = intval($employeeId);

            if ($idEmployee <= 0) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'ID de empleado inválido.'
                ], JSON_UNESCAPED_UNICODE);
                die();
            }

            $arrEmployee = $this->model->selectEmployee($idEmployee);

            if (empty($arrEmployee)) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'Datos no encontrados.'
                ], JSON_UNESCAPED_UNICODE);
                die();
            }

            $arrWorkdays = $this->model->selectEmployeeWorkdays($idEmployee);

            $arrResponse = [
                'status' => true,
                'data' => [
                    'employee' => $arrEmployee,
                    'workdays' => $arrWorkdays
                ]
            ];

            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            die();
        }

		public function delEmployee()
		{
			if($_POST){
				if($_SESSION['permisosMod']['d']){
					$intIdEmployee = intval($_POST['idEmployee']);
					$requestDelete = $this->model->deleteEmployee($intIdEmployee);
					if($requestDelete)
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el rejistro');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el registro.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}
	}

?>
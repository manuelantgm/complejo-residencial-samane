<?php 
	require 'Libraries/html2pdf/vendor/autoload.php';
	use Spipu\Html2Pdf\Html2Pdf;
	require 'Libraries/NumbreToLetter/numberToLetter.php';
	class Vehicles extends Controllers{
		private $db;
		public function __construct()
		{
			parent::__construct();
			session_start();
			//session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
				die();
			}
			getPermisos(MEMPLOYEES);
			// Instancia de conexión
			$this->db = new Conexion();
		}

		public function view()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_tag'] = NOMBRE_EMPRESA;
			$data['page_title'] = "Vehiculos <small>".NOMBRE_EMPRESA."</small>";
			$data['page_name'] = "vehicles";
			$data['page_functions_js'] = "vehicle/fnts_vehicle.js";
			$this->views->getView($this,"vehicles",$data);
		}

        public function upsertVehicle()
        {
            $arrResponse = ['status' => false, 'msg' => 'No se pudo procesar la solicitud.'];

            try {
                if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                    throw new Exception('Método no permitido.');
                }

                $data = $this->validateVisitForm($_POST);

                $isNew = ($data['idVehicle'] === 0);

                if ($isNew && empty($_SESSION['permisosMod']['w'])) {
                    throw new Exception('No tiene permisos para registrar vehiculo.');
                }

                if (!$isNew && empty($_SESSION['permisosMod']['u'])) {
                    throw new Exception('No tiene permisos para actualizar vehiculo.');
                }

                $this->db->begin();

                if ($isNew) {
                    $vehicleId = $this->model->insertVehicle(
                        $data['idUser'],
                        $data['mark'],
                        $data['model'],
                        $data['color'],
                        $data['year'],
                        $data['plate']
                    );

                    if (!$vehicleId || intval($vehicleId) <= 0) {
                        throw new Exception('No fue posible registrar el vehiculo.');
                    }
                } else {
                    $updated = $this->model->updateVehicle(
                        $data['idVehicle'],
                        $data['mark'],
                        $data['model'],
                        $data['color'],
                        $data['year'],
                        $data['plate']
                    );
                    if ($updated === 'plateExist') {
                        throw new Exception('La placa ya existe.');
                    }
                    
                    if (!$updated) {
                        throw new Exception('No fue posible actualizar el vehiculo.');
                    }

                    $vehicleId = $data['idVehicle'];
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

        private function validateVisitForm(array $post): array
        {
            $idVehicle = isset($post['idVehicle']) ? intval($post['idVehicle']) : 0;
            $idUser = isset($_SESSION['idUser']) ? intval($_SESSION['idUser']) : 0;

            $mark = isset($post['txtMark'])
                ? strtoupper(trim(strClean($post['txtMark'])))
                : '';

            $model = isset($post['txtModel'])
                ? strtoupper(trim(strClean($post['txtModel'])))
                : '';

            $color = isset($post['txtColor'])
                ? strtoupper(trim(strClean($post['txtColor'])))
                : '';

            $year = isset($post['txtYear'])
                ? strtoupper(trim(strClean($post['txtYear'])))
                : '';

            $plate = isset($post['txtPlate'])
                ? strtoupper(trim(strClean($post['txtPlate'])))
                : '';

            if ($mark === '') {
                throw new Exception('La marca es obligatoria.');
            }

            if ($model === '') {
                throw new Exception('El modelo es obligatoria.');
            }

            if ($color === '') {
                throw new Exception('La marca es obligatoria.');
            }

            if ($year === '') {
                throw new Exception('El año es obligatorio.');
            }

            if ($plate === '') {
                throw new Exception('La placa es obligatoria.');
            }

            return [
                'idVehicle' => $idVehicle,
                'idUser'    => $idUser,
                'mark'      => $mark,
                'model'     => $model,
                'color'     => $color,
                'year'      => $year,
                'plate'     => $plate
            ];
        }

		public function getVehicles(){
            if($_SESSION['permisosMod']['r']){
                $idUsuario = intval($_SESSION['idUser']);
                $arrData = $this->model->selectVehicles($idUsuario);

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

		public function getVehicle($vehicleId)
        {
            $idVehicle = intval($vehicleId);

            if ($idVehicle <= 0) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'ID del vehiculo inválido.'
                ], JSON_UNESCAPED_UNICODE);
                die();
            }

            $arrVehicle = $this->model->selectVehicle($idVehicle);

            if (empty($arrVehicle)) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'Datos no encontrados.'
                ], JSON_UNESCAPED_UNICODE);
                die();
            }

            $arrResponse = [
                'status' => true,
                'data' => ['vehicle' => $arrVehicle]
            ];

            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            die();
        }

		public function delVehicle()
        {
            header('Content-Type: application/json; charset=utf-8');

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                echo json_encode([
                    'status' => false,
                    'msg' => 'Método no permitido.'
                ], JSON_UNESCAPED_UNICODE);
                die();
            }

            if (empty($_SESSION['permisosMod']['d'])) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'No tienes permisos para eliminar.'
                ], JSON_UNESCAPED_UNICODE);
                die();
            }

            if (empty($_POST['idVehicle'])) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'ID de visita no recibido.'
                ], JSON_UNESCAPED_UNICODE);
                die();
            }

            $intIdVehicle = intval($_POST['idVehicle']);
            $requestDelete = $this->model->deleteVehicle($intIdVehicle);

            if ($requestDelete) {
                $arrResponse = [
                    'status' => true,
                    'msg' => 'Se ha eliminado el registro.'
                ];
            } else {
                $arrResponse = [
                    'status' => false,
                    'msg' => 'Error al eliminar el registro.'
                ];
            }

            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            die();
        }
	}

?>
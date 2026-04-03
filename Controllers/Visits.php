<?php 
	require 'Libraries/html2pdf/vendor/autoload.php';
	use Spipu\Html2Pdf\Html2Pdf;
	require 'Libraries/NumbreToLetter/numberToLetter.php';
	class Visits extends Controllers{
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
			$data['page_title'] = "Visita <small>".NOMBRE_EMPRESA."</small>";
			$data['page_name'] = "visits";
			$data['page_functions_js'] = "person/fnts_visit.js";
			$this->views->getView($this,"visits",$data);
		}

        public function upsertVisit()
        {
            $arrResponse = ['status' => false, 'msg' => 'No se pudo procesar la solicitud.'];

            try {
                if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                    throw new Exception('Método no permitido.');
                }

                $data = $this->validateVisitForm($_POST);

                $isNew = ($data['idVisit'] === 0);

                if ($isNew && empty($_SESSION['permisosMod']['w'])) {
                    throw new Exception('No tiene permisos para registrar visitas.');
                }

                if (!$isNew && empty($_SESSION['permisosMod']['u'])) {
                    throw new Exception('No tiene permisos para actualizar visitas.');
                }

                $this->db->begin();

                if ($isNew) {
                    $visitId = $this->model->insertVisit(
                        $data['idUser'],
                        $data['name'],
                        $data['lastName'],
                        $data['identification'],
                        $data['passport']
                    );

                    if (!$visitId || intval($visitId) <= 0) {
                        throw new Exception('No fue posible registrar la visita.');
                    }
                } else {
                    $updated = $this->model->updateVisit(
                        $data['idVisit'],
                        $data['name'],
                        $data['lastName'],
                        $data['identification'],
                        $data['passport']
                    );
                    if ($updated === 'identificacionExist') {
                        throw new Exception('La identificación ya existe.');
                    }
                    if ($updated === 'passportExist') {
                        throw new Exception('El pasaporte ya existe.');
                    }
                    if (!$updated) {
                        throw new Exception('No fue posible actualizar la visita.');
                    }

                    $visitId = $data['idVisit'];
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
            $idVisit = isset($post['idVisit']) ? intval($post['idVisit']) : 0;
            $idUser = isset($_SESSION['idUser']) ? intval($_SESSION['idUser']) : 0;

            $identification = isset($post['txtIdentification'])
                ? preg_replace('/[^0-9]/', '', strClean($post['txtIdentification']))
                : '';

            $passport = isset($post['txtPassport'])
                ? strtoupper(trim(strClean($post['txtPassport'])))
                : '';

            $name = isset($post['txtName'])
                ? strtoupper(trim(strClean($post['txtName'])))
                : '';

            $lastName = isset($post['txtLastName'])
                ? strtoupper(trim(strClean($post['txtLastName'])))
                : '';

            if ($name === '' || $lastName === '') {
                throw new Exception('El nombre y el apellido son obligatorios.');
            }

            if ($identification === '' && $passport === '') {
                throw new Exception('Debe indicar almenos un tipo de identificacion.');
            }

            return [
                'idVisit'        => $idVisit,
                'idUser'         => $idUser,
                'identification' => $identification,
                'passport'       => $passport,
                'name'           => $name,
                'lastName'       => $lastName
            ];
        }

		public function getVisits(){
            if($_SESSION['permisosMod']['r']){
                $idUsuario = intval($_SESSION['idUser']);
                $arrData = $this->model->selectVisits($idUsuario);

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

		public function getVisit($visitId)
        {
            if (!$_SESSION['permisosMod']['r']) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'No tiene permisos para ver esta información.'
                ], JSON_UNESCAPED_UNICODE);
                die();
            }

            $idVisit = intval($visitId);

            if ($idVisit <= 0) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'ID de la visita inválido.'
                ], JSON_UNESCAPED_UNICODE);
                die();
            }

            $arrVisit = $this->model->selectVisit($idVisit);

            if (empty($arrVisit)) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'Datos no encontrados.'
                ], JSON_UNESCAPED_UNICODE);
                die();
            }

            $arrResponse = [
                'status' => true,
                'data' => [
                    'visit' => $arrVisit
                ]
            ];

            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            die();
        }

		public function delVisit()
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

            if (empty($_POST['idVisit'])) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'ID de visita no recibido.'
                ], JSON_UNESCAPED_UNICODE);
                die();
            }

            $intIdVisit = intval($_POST['idVisit']);
            $requestDelete = $this->model->deleteVisit($intIdVisit);

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
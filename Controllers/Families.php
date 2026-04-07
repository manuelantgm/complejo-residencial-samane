<?php 
	require 'Libraries/html2pdf/vendor/autoload.php';
	use Spipu\Html2Pdf\Html2Pdf;
	require 'Libraries/NumbreToLetter/numberToLetter.php';
	class Families extends Controllers{
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
			getPermisos(MFAMILIES);
			// Instancia de conexión
			$this->db = new Conexion();
		}

		public function familias()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_tag'] = NOMBRE_EMPRESA;
			$data['page_title'] = "Familia <small>".NOMBRE_EMPRESA."</small>";
			$data['page_name'] = "families";
			$data['page_functions_js'] = "person/fnts_family.js";
			$this->views->getView($this,"families",$data);
		}

		public function upsertFamily()
        {
            $arrResponse = ['status' => false, 'msg' => 'No se pudo procesar la solicitud.'];

            try {
                if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                    throw new Exception('Método no permitido.');
                }

                $data = $this->validateFamilyForm($_POST);

                $isNew = ($data['idFamily'] === 0);

                if ($isNew && empty($_SESSION['permisosMod']['w'])) {
                    throw new Exception('No tiene permisos para registrar familias.');
                }

                if (!$isNew && empty($_SESSION['permisosMod']['u'])) {
                    throw new Exception('No tiene permisos para actualizar familias.');
                }

                $this->db->begin();

                if ($isNew) {
                    $familyId = $this->model->insertFamily(
                        $data['idUser'],
						$data['intlegalage'],
                        $data['names'],
                        $data['lastNames'],
                        $data['identification'],
                        $data['passport'],
                        $data['streetid'],
                        $data['homenumber'],
						$data['phone'],
						$data['email'],
						$data['password'],
						$data['relationship']
                    );
					if ($familyId === 'identificacionExist') {
						throw new Exception('La identificación ya existe.');
					}

					if ($familyId === 'passportExist') {
						throw new Exception('El pasaporte ya existe.');
					}

					if ($familyId === 'emailExist') {
						throw new Exception('El email ya existe.');
					}

					if (!$familyId || intval($familyId) <= 0) {
						throw new Exception('No fue posible registrar el familiar.');
					}
                } else {
                    $updated = $this->model->updateFamily(
                        $data['idFamily'],
						$data['intlegalage'],
                        $data['names'],
                        $data['lastNames'],
                        $data['identification'],
                        $data['passport'],
                        $data['streetid'],
                        $data['homenumber'],
						$data['phone'],
						$data['email'],
						$data['password'],
						$data['relationship']
                    );

                    if ($updated === 'identificacionExist') {
                        throw new Exception('La identificación ya existe.');
                    }
                    if ($updated === 'passportExist') {
                        throw new Exception('El pasaporte ya existe.');
                    }
                    if (!$updated) {
                        throw new Exception('No fue posible actualizar el familiar.');
                    }
					if ($updated === 'emailExist') {
                        throw new Exception('El email ya existe.');
                    }
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

        private function validateFamilyForm(array $post): array
		{
			$idFamily = isset($post['idFamily']) ? intval($post['idFamily']) : 0;
			$idUser = isset($_SESSION['idUser']) ? intval($_SESSION['idUser']) : 0;
			$isNew = ($idFamily === 0);

			$intlegalage = isset($post['listAge'])
				? intval(preg_replace('/[^0-9]/', '', strClean($post['listAge'])))
				: 0;

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

			$phone = preg_replace('/[^0-9]/', '', strClean($post['intPhone'] ?? ''));

			$streetid = isset($post['listStreetId']) ? intval($post['listStreetId']) : 0;
			$homenumber = isset($post['intNumber']) ? intval($post['intNumber']) : 0;

			$relationship = isset($post['txtRelationship'])
				? strtoupper(trim(strClean($post['txtRelationship'])))
				: '';

			$email = strtolower(strClean($post['txtEmail'] ?? ''));
			if ($email === '') {
				$email = generateRandomEmail();
			}

			$rawPassword = $post['txtPassword'] ?? '';
			$generatedPassword = false;

			if ($isNew) {
				if ($rawPassword === '') {
					$rawPassword = passGenerator();
					$generatedPassword = true;
				}

				if (strlen($rawPassword) < 6) {
					throw new Exception('La contraseña debe tener al menos 6 caracteres.');
				}

				$password = password_hash($rawPassword, PASSWORD_DEFAULT);
			} else {
				if ($rawPassword !== '' && strlen($rawPassword) < 6) {
					throw new Exception('La contraseña debe tener al menos 6 caracteres.');
				}

				$password = $rawPassword !== ''
					? password_hash($rawPassword, PASSWORD_DEFAULT)
					: '';
			}

			if ($intlegalage <= 0) {
				throw new Exception('Debe indicar si su pariente es mayor o menor de edad.');
			}

			if ($name === '' || $lastName === '') {
				throw new Exception('El nombre y el apellido son obligatorios.');
			}

			if ($identification === '' && $passport === '') {
				throw new Exception('Debe indicar al menos una identificación o pasaporte.');
			}

			return [
				'idFamily'          => $idFamily,
				'idUser'            => $idUser,
				'intlegalage'       => $intlegalage,
				'names'             => $name,
				'lastNames'         => $lastName,
				'identification'    => $identification,
				'passport'          => $passport,
				'streetid'          => $streetid,
				'homenumber'        => $homenumber,
				'phone'             => $phone,
				'email'             => $email,
				'password'          => $password,
				'rawPassword'       => $generatedPassword ? $rawPassword : null,
				'relationship'      => $relationship
			];
		}

		public function getFamilies(){
            if($_SESSION['permisosMod']['r']){
                $idUsuario = intval($_SESSION['idUser']);
                $arrData = $this->model->selectFamilies($idUsuario);

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

		public function getFamily($personid){
			if($_SESSION['permisosMod']['r']){
				$idPerson = intval($personid);
				if($idPerson > 0)
				{
					$arrData = $this->model->selectFamily($idPerson);
					if(empty($arrData))
					{
						$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
					}else{
						$arrResponse = array('status' => true, 'data' => $arrData);
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function delFamily()
		{
			if($_POST){
				if($_SESSION['permisosMod']['d']){
					$intIdFamily = intval($_POST['idFamily']);
					$requestDelete = $this->model->deleteFamily($intIdFamily);
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
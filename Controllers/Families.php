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

		/*public function setFamily(){
			if($_POST){
				if(empty($_POST['txtName']) || empty($_POST['txtLastName']))
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{ 
					
					try {
						$this->db->begin(); // inicia transacción

						$idFamily = intval($_POST['idFamily']);
						$idUser = intval($_SESSION['idUser']);
						$intLegalAge = intval($_POST['listAge']); // 1 = mayor de edad, 2 = Menor de edad
						$strIdentification = preg_replace('/[^0-9]/', '',strClean($_POST['txtIdentification']));
						$strPassport = strtoupper(strClean($_POST['txtPassport']));
						$strName = strtoupper(strClean($_POST['txtName']));
						$strLastname = strtoupper(strClean($_POST['txtLastName']));
						$strRelationship = strtoupper(strClean($_POST['txtRelationship']));
						$intPhone = preg_replace('/[^0-9]/', '',strClean($_POST['intPhone']));
						$intStreetId = intval($_POST['listStreetId']);
						$intHomeNumber = intval($_POST['intNumber']);

						$strEmail = strtolower(strClean($_POST['txtEmail']));
						if(empty($strEmail)){
							$strEmail = generateRandomEmail();
						}
					
						$request_family = "";
						if($idFamily == 0)
						{
							$option = 1;
							$strPassword = empty($_POST['txtPassword']) ? passGenerator() : $_POST['txtPassword'];
							$strPasswordEncript = hash("SHA256",$strPassword);
							if($_SESSION['permisosMod']['w']){
								$request_family = $this->model->insertFamily($idUser,
																			 $intLegalAge,
																			 $strName, 
																			 $strLastname,
																			 $strIdentification,
																			 $strPassport,
																			 $intStreetId,
																			 $intHomeNumber,
																			 $intPhone, 
																			 $strType,
																			 $strEmail,
																			 $strPasswordEncript
																			);
							}
						}else{
							$option = 2;
							$strPassword = empty($_POST['txtPassword']) ? "" : hash("SHA256",$_POST['txtPassword']);
							if($_SESSION['permisosMod']['u']){
								$request_family = $this->model->updateFamily($idFamily,
																			 $intLegalAge,
																		     $strName, 
																		     $strLastname,
																		     $strIdentification,
																			 $strPassport,
																		     $intStreetId,
																		     $intHomeNumber,
																		     $intPhone, 
																		     $strEmail,
																		     $strPassword,
																			 $strRelationship);
							}
						}

						if($request_family > 0 )
						{
							$this->db->commit(); // confirma
						    $arrResponse = array('status' => true, 'msg' => $option == 1 
						        ? 'Datos guardados correctamente.' 
						        : 'Datos Actualizados correctamente.');
						}else if($request_family == 'emailExist'){
							$this->db->rollback(); // revierte
							$arrResponse = array('status' => false, 'msg' => '¡Atención! el email ya existe, ingrese otro.');		
						}else{
							$this->db->rollback();
							$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
						}
					} catch (Exception $e) {
						$this->db->rollback(); // revierte si hubo error
						echo $request_family;
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.'.$e);
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}*/

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
                    $employeeId = $this->model->insertFamily(
                        $data['idUser'],
                        $data['name'],
                        $data['lastName'],
                        $data['identification'],
                        $data['passport'],
                        $data['empType'],
                        $data['ocupationId']
                    );

                    if (!$employeeId || intval($employeeId) <= 0) {
                        throw new Exception('No fue posible registrar el familiar.');
                    }
                } else {
                    $updated = $this->model->updateFamily(
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

        private function validateFamilyForm(array $post): array
        {
            $idFamily = isset($post['idFamily']) ? intval($post['idFamily']) : 0;
            $idUser = isset($_SESSION['idUser']) ? intval($_SESSION['idUser']) : 0;

			$intlegalage = isset($post['listAge'])
                ? preg_replace('/[^0-9]/', '', strClean($post['listAge']))
                : '';

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
			
			$email = strtolower(strClean($post['txtEmail'] ?? '')) ?: generateRandomEmail();

            if ($intlegalage <= 0) {
                throw new Exception('Debe indicar si su pariente es mayor o menor de edad.');
            }

			if ($name === '' || $lastName === '') {
                throw new Exception('El nombre y el apellido son obligatorios.');
            }

			if ($identification === '' || $passport === '') {
                throw new Exception('Debes indicar al menos una identificación.');
            }

            $workdays = $this->parseWorkdays($post);

            return [
                'idFamily'       => $idFamily,
                'idUser'         => $idUser,
				'intlegalage'	 => $intlegalage,
				'names'          => $name,
                'lastNames'      => $lastName,
                'identification' => $identification,
                'passport'       => $passport,
                'streetid'       => $streetid,
                'homenumber'     => $homenumber,
                'phone'       	 => $phone,
				'email'		   	 =>$email,
				'password' 		 => $password,
				'relationship'   => $relationship
            ];
        }

		/*public function getFamilies(){
			if($_SESSION['permisosMod']['r']){
				$idUsuario = intval($_SESSION['idUser']);
				$arrData = $this->model->selectFamilies($idUsuario);
				for ($i=0; $i < count($arrData); $i++) {
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';

					if($arrData[$i]['status'] == 1)
					{
						$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
					}else{
						$arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
					}


					if ($_SESSION['permisosMod']['r']) {
						$btnView = '<button class="btn" onClick="fntViewFamily('.$arrData[$i]['id_person'].')" title="Ver familiar"><i class="far fa-eye"></i> Mas detalles</button>';
					}
					if ($_SESSION['permisosMod']['u']) {
						$btnEdit = '<button class="btn" onClick="fntEditInfo(this,'.$arrData[$i]['id_person'].')" title="Editar cliente"><i class="fa-solid fa-pen-to-square"></i> Editar</button>';
					}
					if ($_SESSION['permisosMod']['d']) {
						$btnDelete = '<button class="btn" onClick="fntDelInfo('.$arrData[$i]['id_person'].')" title="Eliminar cliente"><i class="far fa-trash-alt"></i> Eliminar</button>';
					}

					// Menú de opciones
					$arrData[$i]['options'] = '
					<div class="btn-group pull-right">
						<button type="button" class="btn btn-sm dropdown-toggle bg-info" data-toggle="dropdown" aria-expanded="false">
							<i class="fa-solid fa-gear"></i>
						</button>
						<ul class="dropdown-menu">
							<li>'.$btnView.'</li>
							<li>'.$btnEdit.'</li>
							<li>'.$btnDelete.'</li>
						</ul>
					</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}*/
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
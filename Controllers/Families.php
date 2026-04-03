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

		public function setFamily(){
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
						$intIdentification =  preg_replace('/[^0-9]/', '',strClean($_POST['txtIdentification']));
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
						$strType = "familia";
					
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
																			 $intIdentification,
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
																		     $intIdentification,
																		     $intStreetId,
																		     $intHomeNumber,
																		     $intPhone, 
																		     $strEmail,
																		     $strPassword);
							}
						}

						if($request_family > 0 )
						{
							$person_id = $request_family;
							if($option == 1){
								$request_relationship = $this->model->insertRelationship($person_id,$strRelationship);
							}else{
								$request_relationship = $this->model->updateRelationship($person_id,$strRelationship);
							}

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
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getFamilies(){
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
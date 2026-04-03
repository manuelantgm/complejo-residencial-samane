<?php 

	class Configuracion extends Controllers{
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
			getPermisos(MCONFIGURACION);
		}

		public function Configuracion()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_tag'] = "CONFIGURACIOS | ".NOMBRE_EMPRESA;
			$data['page_name'] = "configuracion";
			$data['page_title'] = "Configuracion <small>".SIGLAS."</small>";
			$data['page_functions_js'] = "fnts_configuracion.js";
			$data['config'] = $this->model->selectConfiguration();
			$this->views->getView($this,"main-config",$data);
		}

		public function setConfig(){
			if($_POST){
				if (empty($_POST['txtNomEmp'])) {
					$arrResponse = array("status" => false, 'title' => 'DATOS INCOMPLETOS', 'icon' => 'success', "msg" => 'Datos actualizados correctamente.');
				}else{
					$strNomEmpresa = ucwords(strClean($_POST['txtNomEmp']));
					$strDirEmpresa = strClean($_POST['txtDireccion']);
					$strTelEmpresa = strClean($_POST['txtTel']);
					$strDescEmpresa = strClean($_POST['txtDescripcion']);
					$strEmailEmpresa = strClean($_POST['txtEmail']);
					$strRncEmpresa = strClean($_POST['txtRnc']);
					$strBanco = strClean($_POST['txtBanco']);
					$intTipoCuenta = intval($_POST['tipoDeCuenta']);
					$strNumCuenta = strClean($_POST['txtNumCuenta']);

					if($_SESSION['permisosMod']['u']){
						$request_update = $this->model->updateConfig($strNomEmpresa,
																	 $strDirEmpresa,
																	 $strTelEmpresa,
																	 $strDescEmpresa,
																	 $strEmailEmpresa,
																	 $strRncEmpresa,
																	 $strBanco,
																	 $intTipoCuenta,
																	 $strNumCuenta
																	);
					}else{
						$arrResponse = array("status" => false, 'title' => 'PERMISO DENEGADO', 'icon' => 'success', "msg" => 'No tienes permisos para realizar esta accion.');
					}
					if($request_update > 0 )
					{
						$arrResponse = array('status' => true, 'title' => 'BIEN HECHO', 'icon' => 'success', 'msg' => 'Datos actualizados correctamente.');
					}else{
						$arrResponse = array("status" => false, 'title' => 'ERROR', 'icon' => 'error', "msg" => 'No es posible guardar los cambios.');
					}

				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
	}
 ?>
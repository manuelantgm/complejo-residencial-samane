<?php 

	class Streets extends Controllers{
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
		}

		public function getSelectStreet()
		{
			$idUsuario = $_SESSION['idUser'];
			$htmlOptions = '<option value="0">Seleccione una calle</option>';
			$arrData = $this->model->selectStreets($idUsuario);
			if(count($arrData) > 0 ){
				for ($i=0; $i < count($arrData); $i++) { 
					if($arrData[$i]['status'] == 1 ){
						$htmlOptions .= '<option value="'.$arrData[$i]['id_street'].'">'.$arrData[$i]['street'].'</option>';
					}
				}
			}
			echo $htmlOptions;
			die();		
		}

		public function getCalle($idcalle)
		{
			$idcalle = intval($idcalle);
			if($idcalle > 0)
			{
				$arrData = $this->model->selectCuota($idcalle);
				if(empty($arrData))
				{
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				}else{
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();		
		}

		public function getStreetsByStage()
		{
			if($_POST){
				$stage_id = intval($_POST['stage_id']);

				$arrData = [];

				if($stage_id > 0){
					$arrData = $this->model->selectStreetsByStage($stage_id);
				}

				header('Content-Type: application/json; charset=utf-8');
				echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
				die();
			}
		}
	}
 ?>
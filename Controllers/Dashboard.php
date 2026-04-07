<?php 

	class Dashboard extends Controllers{
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
			getPermisos(MDASHBOARD);
		}

		public function dashboard()
		{
			$data['page_id'] = 1;
			$data['page_tag'] = NOMBRE_EMPRESA;
			$data['page_title'] = "Dashboard - ".NOMBRE_EMPRESA;
			$data['page_name'] = "dashboard";
			$data['page_functions_js'] = "fnts_dashboard.js";
			$idUsuario = $_SESSION['idUser'];
			$data['usuarios'] = $this->model->cantUsuarios();
			$data['persons'] = $this->model->cantPersons($idUsuario);
			$data['families'] = $this->model->cantFamilies($idUsuario);
			$data['employees'] = $this->model->cantEmployees($idUsuario);
			$data['visits'] = $this->model->cantVisits($idUsuario);
			$data['vehicles'] = $this->model->cantVehicles($idUsuario);
			$anio = date('Y');
			$mes = date('m');
			if( $_SESSION['userData']['idrol'] == RPROPIETARIOS ){
				$this->views->getView($this,"dashboard",$data);
			}else{
				$this->views->getView($this,"dashboard",$data);
			}
		}
	}
 ?>
<?php 
	class DashboardModel extends Mysql
	{
		public $strAnio;
		public $strMes;
		public function __construct()
		{
			parent::__construct();
		}
		public function cantUsuarios(){
			$sql = "SELECT COUNT(*) as total FROM persons WHERE status != 0";
			$request = $this->select($sql);
			$total = $request['total']; 
			return $total;
		}
		public function cantPersons($idUsuario){
			$sql = "SELECT 
						(SELECT COUNT(*) FROM families WHERE status != 0 AND user_id = ?) +
						(SELECT COUNT(*) FROM employees WHERE status != 0 AND user_id = ?) +
						(SELECT COUNT(*) FROM visits WHERE status != 0 AND user_id = ?) +
						(SELECT COUNT(*) FROM usuarios WHERE status != 0 AND idusuario = ?)
					AS total";

			$request = $this->select($sql, [
				$idUsuario,
				$idUsuario,
				$idUsuario,
				$idUsuario
			]);
			return $request['total'];
		}
		public function cantFamilies($idUsuario){
		    $sql = "SELECT COUNT(*) as total 
		            FROM persons 
		            WHERE status != 0  
		              AND user_id = ?
					  AND type = ?";
		    $request = $this->select($sql, [$idUsuario, "familia"]);
		    return $request['total'];
		}
		public function cantEmployees($idUsuario){
		    $sql = "SELECT COUNT(*) as total 
		            FROM employees 
		            WHERE status != 0  
		              AND user_id = ?";
		    $request = $this->select($sql, [$idUsuario]);
		    return $request['total'];
		}
		public function cantVisits($idUsuario){
		    $sql = "SELECT COUNT(*) as total 
		            FROM visits 
		            WHERE status != 0  
		              AND user_id = ?";
		    $request = $this->select($sql, [$idUsuario]);
		    return $request['total'];
		}
		public function cantVehicles($idUsuario){
		    $sql = "SELECT COUNT(*) as total 
		            FROM vehicles 
		            WHERE status != 0  
		              AND user_id = ?";
		    $request = $this->select($sql, [$idUsuario]);
		    return $request['total'];
		}
	}
?>
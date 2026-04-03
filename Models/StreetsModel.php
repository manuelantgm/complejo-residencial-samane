<?php 

	class StreetsModel extends Mysql
	{
		public $intIdCalle;
		public $intStatus;

		public function __construct()
		{
			parent::__construct();
		}

		public function selectStreets(int $idUsuario)
		{
			//EXTRAE CALLES
			$sql = "SELECT s.id_street, 
						   s.street,
						   s.status
                FROM streets s
                INNER JOIN usuarios u ON s.stage_id = u.stage_id
                WHERE s.status = 1 AND u.idusuario = ?";
			$request = $this->select_all($sql, [$idUsuario]);
        	return $request;
		}
	}
 ?>
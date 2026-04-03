<?php 

	class OcupationsModel extends Mysql
	{
		public $intIdCalle;
		public $intStatus;

		public function __construct()
		{
			parent::__construct();
		}

		public function selectOcupations()
		{
			//EXTRAE OCUPACIONES
			$sql = "SELECT id_ocupation, 
						   ocupation,
                           status
                FROM ocupations 
                WHERE status = 1";
			$request = $this->select_all($sql);
        	return $request;
		}
	}
 ?>
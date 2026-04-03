<?php 

	class DaysModel extends Mysql
	{
		public $intIdCalle;
		public $intStatus;

		public function __construct()
		{
			parent::__construct();
		}

		public function selectDays()
		{
			//EXTRAE DIAS
			$sql = "SELECT id_day, 
						   day,
                           status
                FROM days 
                WHERE status = 1";
			$request = $this->select_all($sql);
        	return $request;
		}
	}
<?php 
	class Days extends Controllers{
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
		}

		public function getSelectDays()
        {
            $arrData = $this->model->selectDays();
            $arrResponse = [];

            if(count($arrData) > 0 ){
                for ($i=0; $i < count($arrData); $i++) { 
                    if($arrData[$i]['status'] == 1 ){
                        $arrResponse[] = [
                            "id_day" => $arrData[$i]['id_day'],
                            "day"    => $arrData[$i]['day']
                        ];
                    }
                }
            }

            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            die();
        }

	}
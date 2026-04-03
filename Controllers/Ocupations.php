<?php 
	class Ocupations extends Controllers{
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

		public function getSelectOcupations()
        {
            $arrData = $this->model->selectOcupations();
            $arrResponse = [];

            if(count($arrData) > 0 ){
                for ($i=0; $i < count($arrData); $i++) { 
                    if($arrData[$i]['status'] == 1 ){
                        $arrResponse[] = [
                            "id_ocupation" => $arrData[$i]['id_ocupation'],
                            "ocupation"    => $arrData[$i]['ocupation']
                        ];
                    }
                }
            }

            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            die();
        }

	}
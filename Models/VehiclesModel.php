<?php 
    class VehiclesModel extends Mysql
    {
        private $intIdUser;
        private $intVehicleId;

        private $strMark;
        private $strModel;
        private $strColor;
        private $strYear;
        private $strPlate;

        public function __construct()
        {
            parent::__construct();
        }	

        public function insertVehicle(int $userId,
                                      string $mark,
                                      string $model,
                                      string $color,
                                      string $year,
                                      string $plate
                                    ) {
            $this->intIdUser = $userId;
            $this->strMark   = $mark;
            $this->strModel  = $model;
            $this->strColor  = $color;
            $this->strYear   = $year;
            $this->strPlate  = $plate;

            $return = 0;

            // Validar identificación duplicada solo si fue enviada
            if (!empty($this->strPlate)) {
                $sql = "SELECT id_vehicle 
                        FROM vehicles 
                        WHERE plate = ? 
                        AND status != 0
                        LIMIT 1";

                $requestPlate = $this->select($sql, [$this->strPlate]);

                if (!empty($requestPlate)) {
                    return "plateExist";
                }
            }

            $queryInsert = "INSERT INTO vehicles(user_id,
                                                mark,
                                                model,
                                                color,
                                                year,
                                                plate) 
                                        VALUES(?,?,?,?,?,?)";

            $arrData = [$this->intIdUser,
                        $this->strMark,
                        $this->strModel,
                        $this->strColor,
                        $this->strYear,
                        $this->strPlate];

            $requestInsert = $this->insert($queryInsert, $arrData);

            if (!empty($requestInsert)) {
                $return = $requestInsert;
            } else {
                $return = false;
            }
            return $return;
        }

        public function selectVehicles(int $iduser)
        {
            $sql = "SELECT id_vehicle,
                        mark,
                        model,
                        color,
                        year,
                        plate,
                        status
                    FROM vehicles
                    WHERE user_id = ? AND status != 0 ORDER BY id_vehicle DESC"; 
            $request = $this->select_all($sql, [$iduser]);
            return $request;
        }

        public function selectVehicle(int $idvehicle)
        {
            $this->intVehicleId = $idvehicle;

            $sql = "SELECT 
                        id_vehicle,
                        mark,
                        model,
                        color,
                        year,
                        plate,
                        status
                    FROM vehicles 
                    WHERE id_vehicle = ?
                    AND status != 0
                    LIMIT 1";
            $request = $this->select($sql, [$this->intVehicleId]);
            return $request;
        }

        public function updateVehicle(int $idvehicle,
                                    string $mark,
                                    string $model,
                                    string $color,
                                    string $year,
                                    string $plate) {
            $this->intVehicleId = $idvehicle;
            $this->strMark   = $mark;
            $this->strModel  = $model;
            $this->strColor  = $color;
            $this->strYear   = $year;
            $this->strPlate  = $plate;

            if ($this->intVehicleId <= 0) {
                return false;
            }

            // Validar placa duplicada
            if (!empty($plate)) {
                $sql = "SELECT id_vehicle
                        FROM vehicles
                        WHERE plate = ?
                        AND id_vehicle != ?
                        AND status != 0
                        LIMIT 1";

                $exists = $this->select($sql, [$this->strPlate, $this->intVehicleId]);

                if (!empty($exists)) {
                    return "plateExist";
                }
            }

            $sqlUpdate = "UPDATE vehicles
                        SET mark = ?,
                            model = ?,
                            color = ?,
                            year = ?,
                            plate = ?
                        WHERE id_vehicle = ?";

            $arrData = [$this->strMark,
                        $this->strModel,
                        $this->strColor,
                        $this->strYear,
                        $this->strPlate,
                        $this->intVehicleId];

            $updated = $this->update($sqlUpdate, $arrData);

            return $updated ? true : false;
        }

        public function deleteVehicle(int $idvehicle)
        {
            $this->intVehicleId = $idvehicle;
            $sql = "UPDATE vehicles SET status = ? WHERE id_vehicle = $this->intVehicleId ";
            $arrData = array(0);
            $request = $this->update($sql,$arrData);
            return $request;
        }
    }
?>
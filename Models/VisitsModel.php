<?php 
class VisitsModel extends Mysql
{
	private $intIdUser;
	private $strName;
	private $strLastName;
	private $intIdentification;
    private $strPassport;

	private $intVisitId;
	private $strRelationship;

	public function __construct()
	{
		parent::__construct();
	}	

	public function insertVisit(int $userId,
                                   string $name,
                                   string $lastName,
                                   string $identification,
                                   string $passport
                                ) {
        $this->intIdUser         = $userId;
        $this->strName           = $name;
        $this->strLastName       = $lastName;
        $this->strIdentification = $identification;
        $this->strPassport       = $passport;

        $return = 0;

        // Validar identificación duplicada solo si fue enviada
        if (!empty($this->strIdentification)) {
            $sql = "SELECT id_visit 
                    FROM visits 
                    WHERE identification = ? 
                    AND status != 0
                    LIMIT 1";

            $requestIdentification = $this->select($sql, [$this->strIdentification]);

            if (!empty($requestIdentification)) {
                return "identificacionExist";
            }
        }

        $queryInsert = "INSERT INTO visits(user_id,
                                              names,
                                              last_names,
                                              identification,
                                              passport) 
                                    VALUES(?,?,?,?,?)";

        $arrData = [$this->intIdUser,
                    $this->strName,
                    $this->strLastName,
                    $this->strIdentification,
                    $this->strPassport];

        $requestInsert = $this->insert($queryInsert, $arrData);

        if (!empty($requestInsert)) {
            $return = $requestInsert;
        } else {
            $return = false;
        }
        return $return;
    }

	public function selectVisits(int $iduser)
	{
		$sql = "SELECT id_visit,
					   names,
					   last_names,
					   identification,
                       passport,
					   status
				FROM visits
				WHERE user_id = ? AND status != 0 ORDER BY id_visit DESC"; 
		$request = $this->select_all($sql, [$iduser]);
		return $request;
	}

	public function selectVisit(int $idVisit)
	{
		$this->intVisitId = $idVisit;

		$sql = "SELECT 
					id_visit,
					names,
					last_names,
					identification,
					passport
					status
				FROM visits 
				WHERE id_visit = ?
				AND status != 0
				LIMIT 1";
		$request = $this->select($sql, [$this->intVisitId]);
		return $request;
	}

	public function updateVisit(int $idVisit,
								string $name,
								string $lastName,
								string $identification,
								string $passport) {
		if ($idVisit <= 0) {
			return false;
		}

		// Validar identificación duplicada
		if (!empty($identification)) {
			$sql = "SELECT id_visit
					FROM visits
					WHERE identification = ?
					AND id_visit != ?
					AND status != 0
					LIMIT 1";

			$exists = $this->select($sql, [$identification, $idVisit]);

			if (!empty($exists)) {
				return "identificacionExist";
			}
		}

		// Validar passport duplicado
		if (!empty($passport)) {
			$sql = "SELECT id_visit
					FROM visits
					WHERE passport = ?
					AND id_visit != ?
					AND status != 0
					LIMIT 1";

			$exists = $this->select($sql, [$passport, $idVisit]);

			if (!empty($exists)) {
				return "passportExist";
			}
		}

		$sqlUpdate = "UPDATE visits
					  SET names = ?,
						last_names = ?,
						identification = ?,
						passport = ?
					  WHERE id_visit = ?";

		$arrData = [$name,
			        $lastName,
			        $identification,
			        $passport,
                    $idVisit
		];

		$updated = $this->update($sqlUpdate, $arrData);

		return $updated ? true : false;
	}

	public function deleteVisit(int $idvisit)
	{
		$this->intVisitId = $idvisit;
		$sql = "UPDATE visits SET status = ? WHERE id_visit = $this->intVisitId ";
		$arrData = array(0);
		$request = $this->update($sql,$arrData);
		return $request;
	}
}

 ?>
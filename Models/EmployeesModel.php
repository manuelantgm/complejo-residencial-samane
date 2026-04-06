<?php 
class EmployeesModel extends Mysql
{
	private $intIdUser;
	private $strName;
	private $strLastName;
	private $intIdentification;
    private $strPassport;
	private $intTypeEmp;
	private $intOcupation;

	private $intEmployeeId;
	private $strRelationship;

	public function __construct()
	{
		parent::__construct();
	}	

	public function insertEmployee(int $userId,
                                   string $name,
                                   string $lastName,
                                   string $identification,
                                   string $passport,
                                   int $empType,
                                   int $ocupationId
                                ) {
        $this->intIdUser         = $userId;
        $this->strName           = $name;
        $this->strLastName       = $lastName;
        $this->strIdentification = $identification;
        $this->strPassport       = $passport;
        $this->intTypeEmp        = $empType;
        $this->intOcupation      = $ocupationId;

        $return = 0;

        // Validar identificación duplicada solo si fue enviada
        if (!empty($this->strIdentification)) {
            $sql = "SELECT id_employee 
                    FROM employees 
                    WHERE identification = ? 
                    AND status != 0
                    LIMIT 1";

            $requestIdentification = $this->select($sql, [$this->strIdentification]);

            if (!empty($requestIdentification)) {
                return "identificacionExist";
            }
        }

        $queryInsert = "INSERT INTO employees(user_id,
                                              names,
                                              last_names,
                                              identification,
                                              passport,
                                              employee_type,
                                              ocupation_id) 
                                    VALUES(?,?,?,?,?,?,?)";

        $arrData = [$this->intIdUser,
                    $this->strName,
                    $this->strLastName,
                    $this->strIdentification,
                    $this->strPassport,
                    $this->intTypeEmp,
                    $this->intOcupation];

        $requestInsert = $this->insert($queryInsert, $arrData);

        if (!empty($requestInsert)) {
            $return = $requestInsert;
        } else {
            $return = false;
        }
        return $return;
    }

	public function replaceEmployeeWorkdays(int $employeeId, array $workdays): bool
    {
        if ($employeeId <= 0) {
            return false;
        }

        if (empty($workdays)) {
            return false;
        }

        // 1. Eliminar horarios anteriores
        $sqlDelete = "DELETE FROM employee_workdays WHERE employee_id = ?";
        $requestDelete = $this->delete($sqlDelete, [$employeeId]);

        if ($requestDelete === false) {
            return false;
        }

        // 2. Insertar nuevos horarios
        $sqlInsert = "INSERT INTO employee_workdays (
                        employee_id,
                        day_id,
                        start_time,
                        end_time
                    ) VALUES (?, ?, ?, ?)";

        foreach ($workdays as $item) {
            if (
                !isset($item['day_id']) ||
                !isset($item['start_time']) ||
                !isset($item['end_time'])
            ) {
                return false;
            }

            $arrData = [
                $employeeId,
                intval($item['day_id']),
                $item['start_time'],
                $item['end_time']
            ];

            $requestInsert = $this->insert($sqlInsert, $arrData);

            if (empty($requestInsert)) {
                return false;
            }
        }

        return true;
    }

	public function selectEmployees(int $iduser)
	{
		$sql = "SELECT e.id_employee,
					   e.names,
					   e.last_names,
					   e.identification,
					   e.passport,
                       e.ocupation_id,
                       o.ocupation,
					   e.status
				FROM employees e
                INNER JOIN ocupations o
                ON o.id_ocupation = e.ocupation_id
				WHERE e.user_id = ? AND e.status != 0 ORDER BY e.id_employee DESC"; 
		$request = $this->select_all($sql, [$iduser]);
		return $request;
	}

	public function selectEmployee(int $idEmployee)
	{
		$this->intEmployeeId = $idEmployee;

		$sql = "SELECT 
					e.id_employee,
					e.names,
					e.last_names,
					e.identification,
					e.passport,
					e.employee_type,
					e.ocupation_id,
					DATE_FORMAT(e.created_at, '%d-%m-%Y') AS created_at,
					e.status
				FROM employees e
				WHERE e.id_employee = ?
				AND e.status != 0
				LIMIT 1";
		$request = $this->select($sql, [$this->intEmployeeId]);
		return $request;
	}
	public function selectEmployeeWorkdays(int $idEmployee)
	{
		$sql = "SELECT 
					ewd.day_id,
					d.day AS day_name,
					ewd.start_time,
					ewd.end_time
				FROM employee_workdays ewd
				INNER JOIN days d
					ON ewd.day_id = d.id_day
				WHERE ewd.employee_id = ?
				ORDER BY ewd.day_id ASC";

		return $this->select_all($sql, [$idEmployee]);
	}

	public function updateEmployee(int $idEmployee,
								   string $name,
								   string $lastName,
								   string $identification,
								   string $passport,
								   int $empType,
								   int $ocupationId
	) {
		if ($idEmployee <= 0) {
			return false;
		}

		// Validar identificación duplicada
		if (!empty($identification)) {
			$sql = "SELECT id_employee
					FROM employees
					WHERE identification = ?
					AND id_employee != ?
					AND status != 0
					LIMIT 1";

			$exists = $this->select($sql, [$identification, $idEmployee]);

			if (!empty($exists)) {
				return "identificacionExist";
			}
		}

		// Validar passport duplicado
		if (!empty($passport)) {
			$sql = "SELECT id_employee
					FROM employees
					WHERE passport = ?
					AND id_employee != ?
					AND status != 0
					LIMIT 1";

			$exists = $this->select($sql, [$passport, $idEmployee]);

			if (!empty($exists)) {
				return "passportExist";
			}
		}

		$sqlUpdate = "UPDATE employees
					  SET names = ?,
						last_names = ?,
						identification = ?,
						passport = ?,
						employee_type = ?,
						ocupation_id = ?
					  WHERE id_employee = ?";

		$arrData = [$name,
			        $lastName,
			        $identification,
			        $passport,
			        $empType,
			        $ocupationId,
			        $idEmployee
		];

		$updated = $this->update($sqlUpdate, $arrData);

		return $updated ? true : false;
	}

	public function updateRelationship (int $personid, string $relationship){
		$this->intIdFamily = $personid;
		$this->strRelationship = $relationship;
		$sql = "UPDATE families SET relationship = ? WHERE person_id = $this->intIdFamily ";
		$arrData = array($this->strRelationship);
		$request = $this->update($sql,$arrData);
		return $request;
	}

	public function deleteEmployee(int $employeeid)
	{
		$this->intEmployeeId = $employeeid;
		$sql = "UPDATE employees SET status = ? WHERE id_employee = ? ";
		$arrData = array(0, $this->intEmployeeId);
		$request = $this->update($sql,$arrData);
		return $request;
	}
}

 ?>
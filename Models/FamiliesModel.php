<?php 
class FamiliesModel extends Mysql
{
	private $intIdUser;
	private $intLegalAge;
	private $strName;
	private $strLastName;
	private $strIdentification;
	private $strPassport;
	private $strAwmDocument;
	private $intIdStreet;
	private $intHomeNumber;
	private $intPhone;
	private $strEmail;
	private $strPassword;

	private $intFamilyId;
	private $strRelationship;

	private $intIdFamily;

	public function __construct()
	{
		parent::__construct();
	}	

	public function insertFamily(
		int $userid,
		int $legalage,
		string $name,
		string $lastname,
		string $identification,
		string $passport,
		int $streetid,
		int $homenumber,
		string $phone,
		string $email,
		string $password,
		string $relationship
	) {
		$this->intIdUser = $userid;
		$this->intLegalAge = $legalage;
		$this->strName = $name;
		$this->strLastName = $lastname;
		$this->strIdentification = $identification;
		$this->strPassport = $passport;
		$this->intIdStreet = $streetid;
		$this->intHomeNumber = $homenumber;
		$this->intPhone = $phone;
		$this->strEmail = $email;
		$this->strPassword = $password;
		$this->strRelationship = $relationship;

		if (!empty($this->strEmail)) {
			$sql = "SELECT id_family 
					FROM families 
					WHERE email = ? 
					LIMIT 1";
			$requestEmail = $this->select($sql, [$this->strEmail]);

			if (!empty($requestEmail)) {
				return "emailExist";
			}
		}

		if (!empty($this->strIdentification)) {
			$sql = "SELECT id_family
					FROM families
					WHERE identification = ?
					AND status != 0
					LIMIT 1";

			$exists = $this->select($sql, [$this->strIdentification]);

			if (!empty($exists)) {
				return "identificacionExist";
			}
		}

		if (!empty($this->strPassport)) {
			$sql = "SELECT id_family
					FROM families
					WHERE passport = ?
					AND status != 0
					LIMIT 1";

			$exists = $this->select($sql, [$this->strPassport]);

			if (!empty($exists)) {
				return "passportExist";
			}
		}

		$sqlInsert = "INSERT INTO families(
							user_id,
							legal_age,
							names,
							last_names,
							identification,
							passport,
							street_id,
							home_number,
							phone,
							email,
							password,
							relationship
						) 
					VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";

		$arrData = [
			$this->intIdUser,
			$this->intLegalAge,
			$this->strName,
			$this->strLastName,
			$this->strIdentification,
			$this->strPassport,
			$this->intIdStreet,
			$this->intHomeNumber,
			$this->intPhone,
			$this->strEmail,
			$this->strPassword,
			$this->strRelationship
		];

		$requestInsert = $this->insert($sqlInsert, $arrData);

		if (empty($requestInsert)) {
			return false;
		}

		return $requestInsert;
	}

	public function selectFamilies(int $iduser)
	{
		$sql = "SELECT id_family,
					   names,
					   last_names,
					   status
				FROM families
				WHERE user_id = ? AND status != 0 ORDER BY id_family DESC"; 
		$request = $this->select_all($sql, [$iduser]);
		return $request;
	}

	public function selectFamily(int $idfamily){
		$this->intFamilyId = $idfamily;
		$sql = "SELECT id_family,
					   legal_age,
					   names,
					   last_names,
					   IFNULL(identification, '') AS identification,
					   IFNULL(passport, '') AS passport,
					   street_id,
					   home_number,
					   IFNULL(phone, '') AS phone,
					   IFNULL(email, '') AS email,
					   relationship,
					   DATE_FORMAT(created_at, '%d-%m-%Y') AS created_at,
					   status
				FROM families
				WHERE id_family = ? AND status != ?";
		$request = $this->select($sql,[$this->intFamilyId,0]);
		return $request;
	}
	public function updateFamily(
		int $idperson,
		int $legalage,
		string $name,
		string $lastname,
		?string $identification,
		?string $passport,
		int $streetid,
		int $homenumber,
		int $phone,
		string $email,
		string $password,
		string $relationship
	) {
		$this->intIdFamily       = $idperson;
		$this->intLegalAge       = $legalage;
		$this->strName           = trim($name);
		$this->strLastName       = trim($lastname);
		$this->strCedula = (isset($identification) && trim($identification) !== '') ? trim($identification) : null;
		$this->strPassport       = (isset($passport) && trim($passport) !== '') ? trim($passport) : null;
		$this->intIdStreet       = $streetid;
		$this->intHomeNumber     = $homenumber;
		$this->intPhone          = $phone;
		$this->strEmail          = trim($email);
		$this->strPassword       = trim($password);
		$this->strRelationship   = trim($relationship);

		try {
			/*
			* ==========================================
			* VALIDAR EMAIL DUPLICADO EN CRS
			* ==========================================
			*/
			if ($this->strEmail !== '') {
				$sql = "SELECT id_family
						FROM families
						WHERE email = ?
						AND id_family != ?
						LIMIT 1";

				$requestEmail = $this->select($sql, [$this->strEmail, $this->intIdFamily], 'crs');

				if (!empty($requestEmail)) {
					return "emailExist";
				}
			}

			/*
			* ==========================================
			* VALIDAR IDENTIFICACIÓN DUPLICADA EN CRS
			* ==========================================
			*/
			if ($this->strIdentification !== null) {
				$sql = "SELECT id_family
						FROM families
						WHERE identification = ?
						AND id_family != ?
						AND status != 0
						LIMIT 1";

				$exists = $this->select($sql, [$this->strIdentification, $this->intIdFamily], 'crs');

				if (!empty($exists)) {
					return "identificacionExist";
				}
			}

			/*
			* ==========================================
			* VALIDAR PASAPORTE DUPLICADO EN CRS
			* ==========================================
			*/
			if ($this->strPassport !== null) {
				$sql = "SELECT id_family
						FROM families
						WHERE passport = ?
						AND id_family != ?
						AND status != 0
						LIMIT 1";

				$exists = $this->select($sql, [$this->strPassport, $this->intIdFamily], 'crs');

				if (!empty($exists)) {
					return "passportExist";
				}
			}

			/*
			* ==========================================
			* BUSCAR IDENTIFICACIÓN ANTERIOR EN CRS
			* Para actualizar en AWM usando la identificación vieja
			* ==========================================
			*/
			$sqlOld = "SELECT identification
					FROM families
					WHERE id_family = ?
					LIMIT 1";

			$oldFamily = $this->select($sqlOld, [$this->intIdFamily], 'crs');

			if (empty($oldFamily)) {
				return false;
			}

			$oldIdentification = !empty($oldFamily['identification']) ? trim($oldFamily['identification']) : null;

			/*
			* ==========================================
			* INICIAR TRANSACCIONES
			* ==========================================
			*/
			$this->begin('crs');
			$this->begin('awm');

			/*
			* ==========================================
			* UPDATE EN CRS - families
			* ==========================================
			*/
			if ($this->strPassword !== "") {
				$sqlCrs = "UPDATE families SET
							legal_age = ?,
							names = ?,
							last_names = ?,
							identification = ?,
							passport = ?,
							street_id = ?,
							home_number = ?,
							phone = ?,
							email = ?,
							password = ?,
							relationship = ?
						WHERE id_family = ?";

				$arrDataCrs = [
					$this->intLegalAge,
					$this->strName,
					$this->strLastName,
					$this->strIdentification,
					$this->strPassport,
					$this->intIdStreet,
					$this->intHomeNumber,
					$this->intPhone,
					$this->strEmail,
					$this->strPassword,
					$this->strRelationship,
					$this->intIdFamily
				];
			} else {
				$sqlCrs = "UPDATE families SET
							legal_age = ?,
							names = ?,
							last_names = ?,
							identification = ?,
							passport = ?,
							street_id = ?,
							home_number = ?,
							phone = ?,
							email = ?,
							relationship = ?
						WHERE id_family = ?";

				$arrDataCrs = [
					$this->intLegalAge,
					$this->strName,
					$this->strLastName,
					$this->strIdentification,
					$this->strPassport,
					$this->intIdStreet,
					$this->intHomeNumber,
					$this->intPhone,
					$this->strEmail,
					$this->strRelationship,
					$this->intIdFamily
				];
			}

			$requestCrs = $this->update($sqlCrs, $arrDataCrs, 'crs');

			if (!$requestCrs) {
				throw new Exception('No fue posible actualizar en CRS.');
			}

			/*
			* ==========================================
			* UPDATE EN AWM - usuarios_frecuentes
			* Solo nombre, apellido e identificación
			* Buscando por la identificación anterior
			* ==========================================
			*/
			if ($oldIdentification !== null) {
				$sqlAwm = "UPDATE usuarios_frecuentes SET
							CEDULA = ?
							NOMBRES = ?,
							APELLIDOS = ?,
						WHERE CEDULA = ?";

				$arrDataAwm = [
					$this->strAwmDocument,
					$this->strName,
					$this->strLastName
				];

				$requestAwm = $this->update($sqlAwm, $arrDataAwm, 'awm');

				if ($requestAwm === false) {
					throw new Exception('No fue posible actualizar en AWM.');
				}
			}

			$this->commitDb('crs');
			$this->commitDb('awm');

			return true;

		} catch (Exception $e) {
			if ($this->inTransactionDb('crs')) {
				$this->rollBackDb('crs');
			}

			if ($this->inTransactionDb('awm')) {
				$this->rollBackDb('awm');
			}

			error_log('Error updateFamily: ' . $e->getMessage());
			return false;
		}
	}

	public function deleteFamily(int $intidfamily)
	{
		$this->intIdFamily = $intidfamily;
		$sql = "UPDATE families SET status = ? WHERE id_family = $this->intIdFamily ";
		$arrData = array(0);
		$request = $this->update($sql,$arrData);
		return $request;
	}
}
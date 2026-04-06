<?php 
class FamiliesModel extends Mysql
{
	private $intIdUser;
	private $intLegalAge;
	private $strName;
	private $strLastName;
	private $strIdentification;
	private $strPassport;
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

	public function insertFamily(int $userid,
								 int $legalage,
								 string $name, 
								 string $lastname,
								 string $identification,
								 string $passport,
								 int $streetid,
								 int $homenumber, 
								 int $phone,
								 string $email, 
								 string $password,
								 string $relationship){
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
		

		$return = 0;
		if(!empty($this->strEmail)){
			$sql = "SELECT * FROM families WHERE 
				email = '{$this->strEmail}' ";
			$request_email = $this->select_all($sql);
			if (!empty($request_email)) {
				$return = "emailExist";
				return $return;
			}
		}

		if(empty($request_email)){
			$query_insert  = "INSERT INTO families(user_id,
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
												  relationship) 
							  VALUES(?,?,?,?,?,?,?,?,?,?,?)";
        	$arrData = array($this->intIdUser,
        					 $this->intLegalAge,
        					 $this->strName,
        					 $this->strLastName,
        					 $this->strdentification,
							 $this->strPassport,
        					 $this->intIdStreet,
        					 $this->intHomeNumber,
        					 $this->intPhone,
        					 $this->strEmail,
        					 $this->strPassword,
							 $this->strRelationship
        					);
        	$request_insert = $this->insert($query_insert,$arrData);
        	if(!empty($request_insert)){
        		$return = $request_insert;
        	}else{
        		$return = "exist";
        	}
        	return $return;	
		}
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
					   identification,
					   passport,
					   street_id,
					   home_number,
					   phone,
					   email,
					   relationship,
					   status
				FROM families
				WHERE id_family = ? AND status != ?";
		$request = $this->select($sql,[$this->intFamilyId,0]);
		return $request;
	}

	public function updateFamily(int $idperson,
								 int $legalage,
								 string $name, 
								 string $lastname,
								 string $identification,
								 string $passport,
								 int $streetid,
								 int $homenumber, 
								 int $phone,
								 string $email, 
								 string $password,
								 string $relationship) {
		$this->intIdFamily = $idperson;
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

		$sql = "SELECT * FROM families WHERE (email = '{$this->strEmail}' AND id_family != $this->intIdFamily)
										   AND id_family != $this->intIdFamily ";
		$request = $this->select_all($sql);

		if(empty($request)){
			if($this->strPassword  != "")
			{
				$sql = "UPDATE families SET legal_age = ?,
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

				WHERE id_family = $this->intIdFamily ";
				$arrData = array($this->intLegalAge,
								$this->strName,
								$this->strLastName,
								$this->strIdentification,
								$this->strPassport,
								$this->intIdStreet,
								$this->intHomeNumber,
								$this->intPhone,
								$this->strEmail,
								$this->strPassword,
								$this->strRelationship);
			}else{
				$sql = "UPDATE families SET legal_age = ?,
								    names = ?,
									last_names = ?,
									identification = ?,
									passport = ?,
									street_id = ?,
									home_number = ?,
									phone = ?,
									email = ?,
									relationship = ?

				WHERE id_family = $this->intIdFamily ";
				$arrData = array($this->intLegalAge,
								$this->strName,
								$this->strLastName,
								$this->strIdentification,
								$this->strPassport,
								$this->intIdStreet,
								$this->intHomeNumber,
								$this->intPhone,
								$this->strEmail,
								$this->strRelationship);
			}
			$request = $this->update($sql,$arrData);
		}else{
			$request = "exist";
		}
		return $request;
	}

	public function deleteFamily(int $intidfamily)
	{
		$this->intIdFamily = $intidfamily;
		$sql = "UPDATE persons SET status = ? WHERE id_person = $this->intIdFamily ";
		$arrData = array(0);
		$request = $this->update($sql,$arrData);
		return $request;
	}
}

 ?>
<?php 
class FamiliesModel extends Mysql
{
	private $intIdUser;
	private $intLegalAge;
	private $strName;
	private $strLastName;
	private $intIdentification;
	private $intIdStreet;
	private $intHomeNumber;
	private $intPhone;
	private $strType;
	private $strEmail;
	private $strPassword;

	private $intPersonId;
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
								 int $identification,
								 int $streetid,
								 int $homenumber, 
								 int $phone,
								 string $type,
								 string $email, 
								 string $password){
		$this->intIdUser = $userid;
		$this->intLegalAge = $legalage;
		$this->strName = $name;
		$this->strLastName = $lastname;
		$this->intIdentification = $identification;
		$this->intIdStreet = $streetid;
		$this->intHomeNumber = $homenumber;
		$this->intPhone = $phone;
		$this->strType = $type;
		$this->strEmail = $email;
		$this->strPassword = $password;
		

		$return = 0;
		if(!empty($this->strEmail)){
			$sql = "SELECT * FROM persons WHERE 
				email = '{$this->strEmail}' ";
			$request_email = $this->select_all($sql);
			if (!empty($request_email)) {
				$return = "emailExist";
				return $return;
			}
		}

		if(empty($request_email)){
			$query_insert  = "INSERT INTO persons(user_id,
												  legal_age,
												  name,
												  last_name,
												  identification,
												  street_id,
												  home_number,
												  phone,
												  type,
												  email,
												  password) 
							  VALUES(?,?,?,?,?,?,?,?,?,?,?)";
        	$arrData = array($this->intIdUser,
        					 $this->intLegalAge,
        					 $this->strName,
        					 $this->strLastName,
        					 $this->intIdentification,
        					 $this->intIdStreet,
        					 $this->intHomeNumber,
        					 $this->intPhone,
        					 $this->strType,
        					 $this->strEmail,
        					 $this->strPassword
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

	public function insertRelationship(int $personid, string $relationship){
		$this->intPersonId = $personid;
		$this->strRelationship = $relationship;
		$query_insert = "INSERT INTO families(person_id,relationship) 
						 VALUES(?,?)";
		$arrData = array($this->intPersonId,
						 $this->strRelationship
						);
		$request_insert = $this->insert($query_insert,$arrData);
		return $request_insert;
	}

	public function selectFamilies(int $iduser)
	{
		$sql = "SELECT id_person,
					   name,
					   last_name,
					   identification,
					   phone,
					   type,
					   status
				FROM persons p
				WHERE user_id = ? AND status != 0 ORDER BY id_person DESC"; 
		$request = $this->select_all($sql, [$iduser]);
		return $request;
	}

	public function selectFamily(int $idperson){
		$this->intPersonId = $idperson;
		$sql = "SELECT p.id_person,
					   p.legal_age,
					   p.name,
					   p.last_name,
					   f.relationship,
					   p.identification,
					   p.street_id,
					   p.home_number,
					   p.phone,
					   p.email,
					   p.status
				FROM persons p
				INNER JOIN families f
				ON p.id_person = f.person_id
				WHERE p.id_person = $this->intPersonId AND status != 0";
		$request = $this->select($sql);
		return $request;
	}

	public function updateFamily(int $idperson,
								 int $legalage,
								 string $name, 
								 string $lastname,
								 int $identification,
								 int $streetid,
								 int $homenumber, 
								 int $phone,
								 string $email, 
								 string $password) {
		$this->intIdFamily = $idperson;
		$this->intLegalAge = $legalage;
		$this->strName = $name;
		$this->strLastName = $lastname;
		$this->intIdentification = $identification;
		$this->intIdStreet = $streetid;
		$this->intHomeNumber = $homenumber;
		$this->intPhone = $phone;
		$this->strEmail = $email;
		$this->strPassword = $password;

		$sql = "SELECT * FROM persons WHERE (email = '{$this->strEmail}' AND id_person != $this->intIdFamily)
										   AND id_person != $this->intIdFamily ";
		$request = $this->select_all($sql);

		if(empty($request)){
			if($this->strPassword  != "")
			{
				$sql = "UPDATE persons SET legal_age = ?,
											name = ?,
											last_name = ?,
											identification = ?,
											street_id = ?,
											home_number = ?,
											phone = ?,
											email = ?,
											password = ?

				WHERE id_person = $this->intIdFamily ";
				$arrData = array($this->intLegalAge,
								$this->strName,
								$this->strLastName,
								$this->intIdentification,
								$this->intIdStreet,
								$this->intHomeNumber,
								$this->intPhone,
								$this->strEmail,
								$this->strPassword);
			}else{
				$sql = "UPDATE persons SET legal_age = ?,
								    name = ?,
									last_name = ?,
									identification = ?,
									street_id = ?,
									home_number = ?,
									phone = ?,
									email = ?

				WHERE id_person = $this->intIdFamily ";
				$arrData = array($this->intLegalAge,
								$this->strName,
								$this->strLastName,
								$this->intIdentification,
								$this->intIdStreet,
								$this->intHomeNumber,
								$this->intPhone,
								$this->strEmail);
			}
			$request = $this->update($sql,$arrData);
		}else{
			$request = "exist";
		}
		return $request;
	}

	public function updateRelationship (int $personid, string $relationship){
		$this->intIdFamily = $personid;
		$this->strRelationship = $relationship;
		$sql = "UPDATE families SET relationship = ? WHERE person_id = $this->intIdFamily ";
		$arrData = array($this->strRelationship);
		$request = $this->update($sql,$arrData);
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
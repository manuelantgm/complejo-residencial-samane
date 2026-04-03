<?php 

	class UsuariosModel extends Mysql
	{
		private $intIdUsuario;
		private $strIdentificacion;
		private $strNombre;
		private $strLastname;
		private $strDireccion;
		private $strApellido;
		private $intTelefono;
		private $strEmail;
		private $strPassword;
		private $strToken;
		private $intTipoId;
		private $intStatus;
		private $strNit;
		private $strNomFiscal;
		private $strDirFiscal;

		public function __construct()
		{
			parent::__construct();
		}	

		public function insertUsuario(string $nombre, string $telefono, string $email, string $password, int $tipoid, int $status){
			$this->strNombre = $nombre;
			$this->intTelefono = $telefono;
			$this->strEmail = $email;
			$this->strPassword = $password;
			$this->intTipoId = $tipoid;
			$this->intStatus = $status;
			$return = 0;

			$sql = "SELECT * FROM usuarios WHERE 
					email_user = '{$this->strEmail}' ";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$query_insert  = "INSERT INTO usuarios(nombres,
													  telefono,
													  email_user,
													  password,
													  calleid,
													  rolid,
													  status) 
								  VALUES(?,?,?,?,?,?,?)";
	        	$arrData = array($this->strNombre,
        						$this->intTelefono,
        						$this->strEmail,
        						$this->strPassword,
        						$this->intStatus,
        						$this->intTipoId,
        						$this->intStatus);
	        	$request_insert = $this->insert($query_insert,$arrData);
	        	$return = $request_insert;
			}else{
				$return = "exist";
			}
	        return $return;
		}

		public function selectUsuarios()
		{
			$whereAdmin = "";
			if($_SESSION['idUser'] != 1 ){
				$whereAdmin = " and p.idusuario != 1 ";
			}
			$sql = "SELECT u.idusuario,
						   u.nombres,
						   u.apellidos,
						   u.telefono,
						   u.email_user,
						   u.status,
						   r.idrol,
						   r.nombrerol 
					FROM usuarios u 
					INNER JOIN rol r
					ON u.rolid = r.idrol
					WHERE u.status != 0 ".$whereAdmin;
					$request = $this->select_all($sql);
					return $request;
		}
		public function selectUsuario(int $idusuario){
			$this->intIdUsuario = $idusuario;
			$sql = "SELECT u.idusuario,u.identificacion,u.nombres,u.apellidos,u.telefono,u.email_user,u.direccion,r.idrol,r.nombrerol,u.status, DATE_FORMAT(u.datecreated, '%d-%m-%Y') as fechaRegistro 
					FROM usuarios u
					INNER JOIN rol r
					ON u.rolid = r.idrol
					WHERE u.idusuario = $this->intIdUsuario";
			$request = $this->select($sql);
			return $request;
		}

		public function updateUsuario(int $idUsuario, string $identification, string $nombre, string $apellidos, string $telefono, string $email, string $password, int $tipoid, int $status){

			$this->intIdUsuario = $idUsuario;
			$this->strIdentificacion = $identification;
			$this->strNombre = $nombre;
			$this->strLastname = $apellidos;
			$this->intTelefono = $telefono;
			$this->strEmail = $email;
			$this->strPassword = $password;
			$this->intTipoId = $tipoid;
			$this->intStatus = $status;

			$sql = "SELECT * FROM usuarios WHERE (email_user = '{$this->strEmail}' AND idusuario != $this->intIdUsuario)
										   AND idusuario != $this->intIdUsuario ";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				if($this->strPassword  != "")
				{
					$sql = "UPDATE usuarios SET identificacion=?, nombres=?, apellidos=?, telefono=?, email_user=?, password=?, rolid=?, status=? 
							WHERE idusuario = $this->intIdUsuario ";
					$arrData = array($this->strIdentificacion,
									$this->strNombre,
									$this->strLastname,
	        						$this->intTelefono,
	        						$this->strEmail,
	        						$this->strPassword,
	        						$this->intTipoId,
	        						$this->intStatus);
				}else{
					$sql = "UPDATE usuarios SET identificacion=?, nombres=?, apellidos=?, telefono=?, email_user=?, rolid=?, status=? 
							WHERE idusuario = $this->intIdUsuario ";
					$arrData = array($this->strIdentificacion,
									$this->strNombre,
									$this->strLastname,
	        						$this->intTelefono,
	        						$this->strEmail,
	        						$this->intTipoId,
	        						$this->intStatus);
				}
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
			return $request;
		
		}
		public function deleteUsuario(int $intIdpersona)
		{
			$this->intIdUsuario = $intIdpersona;
			$sql = "UPDATE usuarios SET status = ? WHERE idusuario = $this->intIdUsuario ";
			$arrData = array(0);
			$request = $this->update($sql,$arrData);
			return $request;
		}

		public function updatePerfil(int $idUsuario, string $nombre,string $lastname, string $telefono, string $email, string $password){
			$this->intIdUsuario = $idUsuario;
			$this->strNombre = $nombre;
			$this->strLastname = $lastname;
			$this->intTelefono = $telefono;
			$this->strEmail = $email;
			$this->strPassword = $password;

			if($this->strPassword != "")
			{
				$sql = "UPDATE usuarios SET nombres=?, apellidos = ?, telefono=?, email_user=?, password=?, direccionfiscal=?
						WHERE idusuario = ? ";
				$arrData = array($this->strNombre,
								$this->strLastname,
								$this->intTelefono,
								$this->strEmail,
								$this->strPassword,
								$this->intIdUsuario);
			}else{
				$sql = "UPDATE usuarios SET nombres=?, apellidos = ?, telefono=?, email_user=?
						WHERE idusuario = ? ";
				$arrData = array($this->strNombre,
								$this->strLastname,
								$this->intTelefono,
								$this->strEmail,
								$this->intIdUsuario);
			}
			$request = $this->update($sql,$arrData);
		    return $request;
		}

		public function updateImage(int $idUsuario,string $image){
			$this->intIdUsuario = $idUsuario;
			$this->strImagen = $image;
			$sql = "UPDATE usuarios SET image=? 
						WHERE idusuario = $this->intIdUsuario ";
			$arrData = array($this->strImagen);
			$request = $this->update($sql,$arrData);
		    return $request;
		}

	}
 ?>
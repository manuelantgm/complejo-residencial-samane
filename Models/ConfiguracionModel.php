<?php 
	class ConfiguracionModel extends Mysql
	{
		private $strNomEmpresa;
		private $strDirEmpresa;
		private $strTelEmpresa;
		private $strDescEmpresa;
		private $strEmailEmpresa;
		private $strRncEmpresa;
		private $strBanco;
		private $strTipoCuenta;
		private $strNumCuenta;
		
		public function __construct()
		{
			parent::__construct();
		}

		public function selectConfiguration(){
			$sql = "SELECT * FROM configuracion WHERE status =1";
			$request = $this->select($sql);
			return $request;
		}

		public function updateConfig(string $nom_empresa, string $dir_empresa, string $tel_empresa, string $desc_empresa, string $email_empresa, string $rnc_empresa, string $banco, int $tipodecuenta, string $numerodecuenta){
			$this->strNomEmpresa = $nom_empresa;
			$this->strDirEmpresa = $dir_empresa;
			$this->strTelEmpresa = $tel_empresa;
			$this->strDescEmpresa = $desc_empresa;
			$this->strEmailEmpresa = $email_empresa;
			$this->strRncEmpresa = $rnc_empresa;
			$this->strBanco = $banco;
			$this->strTipoCuenta = $tipodecuenta;
			$this->strNumCuenta = $numerodecuenta;
			
			$sql = "UPDATE configuracion SET nombre_comercial = ?, 
											 direccion = ?, 
											 telefono = ?,
											 descripcion = ?,
											 email = ?,
											 rnc =?,
											 banco =?,
											 tipo_cuenta =?,
											 numero_cuenta =?
										WHERE status = 1";
				$arrData = array($this->strNomEmpresa,
	    						 $this->strDirEmpresa,
	    						 $this->strTelEmpresa,
	    						 $this->strDescEmpresa,
	    						 $this->strEmailEmpresa,
	    						 $this->strRncEmpresa,
	    						 $this->strBanco,
								 $this->strTipoCuenta,
								 $this->strNumCuenta);
				$requestUpd = $this->update($sql,$arrData);
			if(empty($requestUpd))
			{
				$requestUpd = "exist";
			}else{
				return $requestUpd;
			}
		    return $requestUpd;		
		}
	}
?>	
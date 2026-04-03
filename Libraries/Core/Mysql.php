<?php 
	class Mysql extends Conexion
	{
		private $arrValues;	
		private $conexion;
		private $strquery;	

		function __construct()
		{
			$this->conexion = new Conexion();
			$this->conexion = $this->conexion->conect();
		}

		//Insertar un registro
		public function insert(string $query, array $arrValues)
		{
			$this->strquery = $query;
			$this->arrValues = $arrValues;
        	$insert = $this->conexion->prepare($this->strquery);
        	$resInsert = $insert->execute($this->arrValues);
        	if($resInsert)
	        {
	        	$lastInsert = $this->conexion->lastInsertId();
	        }else{
	        	$lastInsert = 0;
	        }
	        return $lastInsert; 
		}
		//Busca un registro
		public function select(string $query, array $params = [])
		{
		    $this->strquery = $query;
		    $stmt = $this->conexion->prepare($this->strquery);
		    $stmt->execute($params);
		    $data = $stmt->fetch(PDO::FETCH_ASSOC);
		    return $data;
		}
		//Devuelve todos los registros
		public function select_all(string $query, array $params = [])
		{
		    $this->strquery = $query;
		    $stmt = $this->conexion->prepare($this->strquery);
		    $stmt->execute($params);
		    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    return $data;
		}
		//Actualiza registros
		public function update(string $query, array $arrValues)
		{
			$this->strquery = $query;
			$this->arrValues = $arrValues;
			$update = $this->conexion->prepare($this->strquery);
			$resExecute = $update->execute($this->arrValues);
	        return $resExecute;
		}
		//Eliminar un registros
		public function delete(string $query, array $params = [])
		{
			$this->strquery = $query;
			$stmt = $this->conexion->prepare($this->strquery);
			$del = $stmt->execute($params);
			return $del;
		}
	}
 ?>
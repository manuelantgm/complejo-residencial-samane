<?php

class Mysql extends Conexion
{
    private $arrValues;
    private $strquery;

    public function __construct()
    {
        parent::__construct();
    }

    public function insert(string $query, array $arrValues, string $connection = 'crs')
    {
        $this->strquery = $query;
        $this->arrValues = $arrValues;

        $db = $this->getDb($connection);
        $insert = $db->prepare($this->strquery);
        $resInsert = $insert->execute($this->arrValues);

        return $resInsert ? $db->lastInsertId() : 0;
    }

    public function select(string $query, array $params = [], string $connection = 'crs')
    {
        $this->strquery = $query;

        $db = $this->getDb($connection);
        $stmt = $db->prepare($this->strquery);
        $stmt->execute($params);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function select_all(string $query, array $params = [], string $connection = 'crs')
    {
        $this->strquery = $query;

        $db = $this->getDb($connection);
        $stmt = $db->prepare($this->strquery);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update(string $query, array $arrValues, string $connection = 'crs')
    {
        $this->strquery = $query;
        $this->arrValues = $arrValues;

        $db = $this->getDb($connection);
        $update = $db->prepare($this->strquery);

        return $update->execute($this->arrValues);
    }

    public function delete(string $query, array $params = [], string $connection = 'crs')
    {
        $this->strquery = $query;

        $db = $this->getDb($connection);
        $stmt = $db->prepare($this->strquery);

        return $stmt->execute($params);
    }
}
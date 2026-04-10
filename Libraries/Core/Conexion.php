<?php

class Conexion
{
    private static array $connections = [];

    protected ?PDO $crs = null;
    protected ?PDO $awm = null;

    public function __construct()
    {
        // Solo conecta la principal al iniciar
        $this->crs = self::getConnection('crs');
    }

    public static function getConnection(string $name = 'crs'): PDO
    {
        if (isset(self::$connections[$name])) {
            return self::$connections[$name];
        }

        if (!defined('DB_CONFIG') || !isset(DB_CONFIG[$name])) {
            throw new Exception("La configuración de la base de datos '{$name}' no existe.");
        }

        $config = DB_CONFIG[$name];

        try {
            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";

            $pdo = new PDO(
                $dsn,
                $config['user'],
                $config['password'],
                [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false
                ]
            );

            self::$connections[$name] = $pdo;
            return self::$connections[$name];

        } catch (PDOException $e) {
            throw new Exception("Error de conexión a '{$name}': " . $e->getMessage());
        }
    }

    protected function getDb(string $connection = 'crs'): PDO
    {
        if ($connection === 'awm') {
            if ($this->awm === null) {
                $this->awm = self::getConnection('awm');
            }
            return $this->awm;
        }

        if ($this->crs === null) {
            $this->crs = self::getConnection('crs');
        }

        return $this->crs;
    }

    public static function beginTransaction(string $connection = 'crs'): bool
    {
        return self::getConnection($connection)->beginTransaction();
    }

    public static function commit(string $connection = 'crs'): bool
    {
        $conn = self::getConnection($connection);
        return $conn->inTransaction() ? $conn->commit() : false;
    }

    public static function rollBack(string $connection = 'crs'): bool
    {
        $conn = self::getConnection($connection);
        return $conn->inTransaction() ? $conn->rollBack() : false;
    }

    public static function inTransaction(string $connection = 'crs'): bool
    {
        return self::getConnection($connection)->inTransaction();
    }

    protected function begin(string $connection = 'crs'): bool
    {
        return self::beginTransaction($connection);
    }

    protected function commitDb(string $connection = 'crs'): bool
    {
        return self::commit($connection);
    }

    protected function rollBackDb(string $connection = 'crs'): bool
    {
        return self::rollBack($connection);
    }

    protected function inTransactionDb(string $connection = 'crs'): bool
    {
        return self::inTransaction($connection);
    }
}
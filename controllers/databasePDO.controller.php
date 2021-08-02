<?php
require_once "../config/config.php";

class PDODBController
{

    private $conn;
    private string $dbhost = dbhost;
    private string $dbuser = dbuser;
    private string $dbpass = dbpass;
    private string $dbname = dbname;
    private string $charset = dbcharset;

    public function __construct()
    {
        try {
            $options = [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'];
            $this->conn = new PDO("mysql:host=$this->dbhost;dbname=$this->dbname", $this->dbuser, $this->dbpass, $options);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function __destruct()
    {
        $this->conn == null;
    }

    public function query($sql)
    {
        $data = null;
        if (empty($sql)) {
            return false;
        }
        if (!$this->conn) {
            return false;
        }

        $results = $this->conn->exec($sql);

        if (!$results) {
            return false;
        }
        if (!(preg_match("/select/i", $sql) || preg_match("/show/i", $sql))) {
            return true;
        } else {
            if (!$results) {
                return $data;
            } else {
                // while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
                //     $data[] = $row;
                // }
                // mysqli_free_result($results);
                // return $data;
                return $data;
            }
        }
    }

    public function lastID()
    {
        return $this->conn->lastInsertId();
    }

    public function beginTran()
    {
        return $this->conn->beginTransaction();
    }

    public function commit()
    {
        return $this->conn->commit();
    }

    public function rollback()
    {
        return $this->conn->rollback();
    }
}

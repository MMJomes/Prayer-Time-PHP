<?php
require_once 'database.php';

class Subscriber
{
    private $conn;
    public function __construct()
    {
        $database = new Database();
        $db = $database->dbConnection();
        $this->conn = $db;
    }
    public function runQuery($sql)
    {
        $stmt = $this->conn->prepare($sql);
        return $stmt;
    }
    public function insert($name)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO subscribers (name) VALUES (:name)");
            $stmt->bindparam(":name", $name);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function update($name, $id)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE subscribers SET name=:name WHERE id=:id");
            $stmt->bindparam(":name", $name);
            $stmt->bindparam(":id", $id);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function delete($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM subscribers WHERE id=:id");
            $stmt->bindparam(":id", $id);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function redirect($url)
    {
        header("Location: $url");
    }
}
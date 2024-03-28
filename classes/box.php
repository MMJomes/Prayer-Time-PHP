<?php
require_once 'database.php';

class Box
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
    public function insert($name, $prayerzone, $subscriber_id)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO boxs (name, prayerzone, subscriber_id) VALUES (:name, :prayerzone, :subscriber_id)");
            $stmt->bindparam(":name", $name);
            $stmt->bindparam(":prayerzone", $prayerzone);
            $stmt->bindparam(":subscriber_id", $subscriber_id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function update($name, $prayerzone, $subscriber_id, $id)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE boxs SET name=:name, prayerzone=:prayerzone, subscriber_id=:subscriber_id WHERE id=:id");
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":prayerzone", $prayerzone);
            $stmt->bindParam(":subscriber_id", $subscriber_id);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function delete($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM boxs WHERE id=:id");
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
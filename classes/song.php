<?php
require_once 'database.php';

class Song
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
    public function insert($name, $subscriber_id,  $box_id,$prayerzone,$prayertimedate,$prayertimeseq,$prayertime)
    {

        try {
            $stmt = $this->conn->prepare("INSERT INTO songs (name,subscriber_id,box_id,prayerzone,prayertimedate,prayertimeseq,prayertime) VALUES (:name, :subscriber_id,:box_id,:prayerzone,:prayertimedate,:prayertimeseq,:prayertime)");
            $stmt->bindparam(":name", $name);
            $stmt->bindparam(":subscriber_id", $subscriber_id);
            $stmt->bindparam(":box_id", $box_id);
            $stmt->bindparam(":prayerzone", $prayerzone);
            $stmt->bindparam(":prayertimedate", $prayertimedate);
            $stmt->bindparam(":prayertimeseq", $prayertimeseq);
            $stmt->bindparam(":prayertime", $prayertime);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function update($name, $subscriber_id,  $box_id,$prayerzone,$prayertimedate,$prayertimeseq,$prayertime, $id)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE songs SET name=:name,subscriber_id=:subscriber_id,box_id=:box_id,prayerzone=:prayerzone,prayertimedate=:prayertimedate,prayertimeseq=:prayertimeseq,prayertime=:prayertime WHERE id=:id");
            echo $name;
            echo $subscriber_id;
            echo $box_id;
            echo $prayerzone;
            echo $prayertimedate;
            echo $prayertimeseq;
            echo $prayertime;   
            echo $id;
    
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":subscriber_id", $subscriber_id);
            $stmt->bindParam(":box_id", $box_id);
            $stmt->bindParam(":prayerzone", $prayerzone);
            $stmt->bindParam(":prayertimedate", $prayertimedate);
            $stmt->bindParam(":prayertimeseq", $prayertimeseq);
            $stmt->bindParam(":prayertime", $prayertime);
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
            $stmt = $this->conn->prepare("DELETE FROM songs WHERE id=:id");
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
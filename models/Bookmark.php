<?php

class Bookmark
{
    private $id;
    private $title;
    private $url;
    private $dateAdded;
    private $dbConnection;
    private $dbTable = 'bookmarks';

    public function __construct($dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    // setters and getters
    public function getId(){
        return $this->id;
    }
    public function getTitle(){
        return $this->title;
    }
    public function getUrl(){
        return $this->url;
    }
    public function getDateAdded(){
        return $this->dateAdded;
    }

    public function setId($id){
        $this->id = $id;
    }
    public function setTitle($title){
        $this->title = $title;
    }
    public function setUrl($url){
        $this->url = $url;
    }
    public function setDateAdded($dateAdded){
        $this->dateAdded = $dateAdded;
    }

    // CRUD operatoins on the model
    public function create(){
        $query = "INSERT INTO ".$this->dbTable." (title, url, date_added) VALUES(:bkTitle, :bkUrl, now());";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(":bkTitle", $this->title);
        $stmt->bindParam(":bkUrl", $this->url);
        if($stmt->execute()){
            return true;
        }
        printf("Error: %s", $stmt->error);
        return false;
    }

    public function readOne(){
        $query = "SELECT * FROM ".$this->dbTable." WHERE id=:id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(":id", $this->id);
        if($stmt->execute() && $stmt->rowCount()==1){
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            $this->id = $result->id;
            $this->title = $result->title;
            $this->url = $result->url;
            $this->dateAdded = $result->date_added;
            return true;
        }
        return false;
    }

    public function readAll() {
        $query = "SELECT * FROM ".$this->dbTable;
        $stmt = $this->dbConnection->prepare($query);
        if($stmt->execute() && $stmt->rowCount() > 1){
            return true;
        }
        return false;
    }

    public function update(){
        $query = "UPDATE ".$this->dbTable." SET title=:title, url=:url WHERE id=:id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":url", $this->url);
        $stmt->bindParam(":id", $this->id);
        if($stmt->execute() && $stmt->rowCount() == 1){
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM ".$this->dbTable." WHERE id=:id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(":id", $this->id);
        if($stmt->execute() && $stmt->rowCount() == 1){
            return true;
        }
        return false;
    }
}
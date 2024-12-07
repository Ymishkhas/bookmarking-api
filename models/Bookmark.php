<?php

class Bookmark
{
    private $id;
    private $userId;
    private $title;
    private $url;
    private $clicksCount;
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
    public function getUserId(){
        return $this->userId;
    }
    public function getTitle(){
        return $this->title;
    }
    public function getUrl(){
        return $this->url;
    }
    public function getClicksCount(){
        return $this->clicksCount;
    }
    public function getDateAdded(){
        return $this->dateAdded;
    }

    public function setId($id){
        $this->id = $id;
    }
    public function setUserId($userId){
        $this->userId = $userId;
    }
    public function setTitle($title){
        $this->title = $title;
    }
    public function setUrl($url){
        $this->url = $url;
    }
    public function setClicksCount($clicksCount){
        $this->clicksCount = $clicksCount;
    }
    public function setDateAdded($dateAdded){
        $this->dateAdded = $dateAdded;
    }

    // CRUD operatoins on the model
    public function create(){
        $query = "INSERT INTO ".$this->dbTable." (user_id, title, url, clicks_count, date_added) VALUES(:user_id, :bkTitle, :bkUrl, 0, now());";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(":user_id", $this->userId);
        $stmt->bindParam(":bkTitle", $this->title);
        $stmt->bindParam(":bkUrl", $this->url);
        if($stmt->execute()){
            return true;
        }
        printf("Error: %s", $stmt->error);
        return false;
    }

    public function readOne(){
        $query = "SELECT * FROM ".$this->dbTable." WHERE id=:id AND user_id=:user_id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":user_id", $this->userId);
        if($stmt->execute() && $stmt->rowCount()==1){
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            $this->id = $result->id;
            $this->userId = $result->user_id;
            $this->title = $result->title;
            $this->url = $result->url;
            $this->clicksCount = $result->clicks_count;
            $this->dateAdded = $result->date_added;
            return true;
        }
        return false;
    }

    public function readAll() {
        $query = "SELECT * FROM ".$this->dbTable." WHERE user_id=:user_id ORDER BY title ASC";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(":user_id", $this->userId);
        if($stmt->execute() && $stmt->rowCount() > 0){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }

    public function readMostClicked(){
        $query = "SELECT * FROM ".$this->dbTable." WHERE user_id=:user_id ORDER BY clicks_count DESC, title ASC LIMIT 10";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(":user_id", $this->userId);
        if($stmt->execute() && $stmt->rowCount() > 0){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }

    public function update(){
        $query = "UPDATE ".$this->dbTable." SET title=:title, url=:url WHERE id=:id AND user_id=:user_id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":url", $this->url);
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":user_id", $this->userId);
        if($stmt->execute() && $stmt->rowCount() == 1){
            return true;
        }
        return false;
    }

    public function updateClicksCount(){
        $query = "UPDATE ".$this->dbTable." SET clicks_count=clicks_count + 1 WHERE id=:id AND user_id=:user_id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":user_id", $this->userId);
        if($stmt->execute() && $stmt->rowCount() == 1){
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM ".$this->dbTable." WHERE id=:id AND user_id=:user_id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":user_id", $this->userId);
        if($stmt->execute() && $stmt->rowCount() == 1){
            return true;
        }
        return false;
    }
}
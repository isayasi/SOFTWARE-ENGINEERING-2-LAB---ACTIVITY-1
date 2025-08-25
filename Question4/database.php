<?php

class Database {
    protected $pdo;
    
    public function __construct() {
        try {
            $this->pdo = new PDO('mysql:host=localhost;dbname=school_db', 'root', '');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
    
    public function create($table, $data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute($data);
    }
    
    public function read($table, $conditions = array()) {
        $sql = "SELECT * FROM $table";
        
        if (!empty($conditions)) {
            $sql .= " WHERE ";
            $whereConditions = array();
            foreach ($conditions as $column => $value) {
                $whereConditions[] = "$column = :$column";
            }
            $sql .= implode(' AND ', $whereConditions);
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($conditions);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function update($table, $data, $conditions) {
        $setClause = array();
        foreach ($data as $column => $value) {
            $setClause[] = "$column = :$column";
        }
        $setClause = implode(', ', $setClause);
        
        $whereClause = array();
        foreach ($conditions as $column => $value) {
            $whereClause[] = "$column = :where_$column";
        }
        $whereClause = implode(' AND ', $whereClause);
        
        $sql = "UPDATE $table SET $setClause WHERE $whereClause";
        $stmt = $this->pdo->prepare($sql);
        
        foreach ($data as $column => $value) {
            $stmt->bindValue(":$column", $value);
        }
        foreach ($conditions as $column => $value) {
            $stmt->bindValue(":where_$column", $value);
        }
        
        return $stmt->execute();
    }
    
    public function delete($table, $conditions) {
        $whereClause = array();
        foreach ($conditions as $column => $value) {
            $whereClause[] = "$column = :$column";
        }
        $whereClause = implode(' AND ', $whereClause);
        
        $sql = "DELETE FROM $table WHERE $whereClause";
        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute($conditions);
    }
}
?>
<?php
class Model {
    protected $db;
    
    public function __construct() {
        $this->db = Database::getConnection();
    }
    
    protected function execute($query, $params = []) {
        $stmt = $this->db->prepare($query);
        foreach ($params as $i => $param) {
            $stmt->bindValue($i + 1, $param, is_int($param) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        return $stmt->execute();
    }
    
    protected function fetch($query, $params = []) {
        $stmt = $this->db->prepare($query);
        foreach ($params as $i => $param) {
            $stmt->bindValue($i + 1, $param, is_int($param) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    protected function fetchAll($query, $params = []) {
        $stmt = $this->db->prepare($query);
        foreach ($params as $i => $param) {
            $stmt->bindValue($i + 1, $param, is_int($param) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    protected function lastInsertId() {
        return $this->db->lastInsertId();
    }
}
<?php
class Model {
    protected $db;
    
    public function __construct() {
        $this->db = Database::getConnection();
    }
    
    protected function execute($query, $params = []) {
        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }
    
    protected function fetch($query, $params = []) {
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetch();
    }
    
    protected function fetchAll($query, $params = []) {
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    protected function lastInsertId() {
        return $this->db->lastInsertId();
    }
}
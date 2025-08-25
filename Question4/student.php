<?php
require_once 'database.php';

class Student extends Database {
    private $table = 'students';
    
    public function addStudent($name, $email, $course) {
        $data = array(
            'name' => $name,
            'email' => $email,
            'course' => $course
        );
        
        return $this->create($this->table, $data);
    }
    
    public function getStudents($conditions = array()) {
        return $this->read($this->table, $conditions);
    }
    
    public function updateStudent($id, $name, $email, $course) {
        $data = array(
            'name' => $name,
            'email' => $email,
            'course' => $course
        );
        
        $conditions = array('id' => $id);
        
        return $this->update($this->table, $data, $conditions);
    }
    
    public function deleteStudent($id) {
        $conditions = array('id' => $id);
        return $this->delete($this->table, $conditions);
    }
}
?>
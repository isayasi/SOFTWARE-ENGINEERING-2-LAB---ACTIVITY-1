<?php
require_once 'database.php';

class Attendance extends Database {
    private $table = 'attendance';
    
    public function addAttendance($student_id, $date, $status) {
        $data = array(
            'student_id' => $student_id,
            'date' => $date,
            'status' => $status
        );
        
        return $this->create($this->table, $data);
    }
    
    public function getAttendance($conditions = array()) {
        return $this->read($this->table, $conditions);
    }
    
    public function updateAttendance($id, $student_id, $date, $status) {
        $data = array(
            'student_id' => $student_id,
            'date' => $date,
            'status' => $status
        );
        
        $conditions = array('id' => $id);
        
        return $this->update($this->table, $data, $conditions);
    }
    
    public function deleteAttendance($id) {
        $conditions = array('id' => $id);
        return $this->delete($this->table, $conditions);
    }
}
?>
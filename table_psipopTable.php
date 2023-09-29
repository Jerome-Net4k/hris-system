<?php

class psipop{

    private $division;
    private $year;

    function set_year($yr){
        $this->year = $yr;
    }
    function set_division($div){
        $this->division = $div;
    }   

    function get_all(){
        include 'connection.php';
        $query = "SELECT * FROM `psipop_table` WHERE `division` = ? AND `year` = ? ORDER BY `salary_grade` DESC";
        $stmt = $con->prepare($query);
        $stmt->bind_param('ss',$this->division,$this->year);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    function get_grandTotal(){
        include 'connection.php';
        $query = "SELECT COUNT(`id`) AS totalPos, SUM(`authorize`) AS totalAuth, SUM(`actual`) AS totalAct FROM `psipop_table` WHERE `division` = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s',$this->division);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    function get_filledTotal(){
        include 'connection.php';
        $query = "SELECT COUNT(`id`) AS totalPos, SUM(`authorize`) AS totalAuth, SUM(`actual`) AS totalAct FROM `psipop_table` WHERE `name` != '' AND `division` = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s',$this->division);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    function get_unfilledTotal(){
        include 'connection.php';
        $query = "SELECT COUNT(`id`) AS totalPos, SUM(`authorize`) AS totalAuth, SUM(`actual`) AS totalAct FROM `psipop_table` WHERE `name` = '' AND `division` = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s',$this->division);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    function get_data($id){
        include 'connection.php';
        $query = "SELECT * FROM `psipop_table` WHERE `empNo` = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s',$id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
}

?>
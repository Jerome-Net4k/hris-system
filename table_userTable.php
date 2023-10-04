<?php
class userTable{

    /**
     * Retrieves a user from the database based on their username and password.
     *
     * @param string $uname The username of the user.
     * @param string $pass The password of the user.
     * @throws Some_Exception_Class Description of the exception, if any.
     * @return mixed The result of the database query.
     */
    function get_user($uname,$pass){
        include 'connection.php';
        $query = "SELECT * FROM `user_table` WHERE `user_name` = ? AND `password` = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('ss',$uname,$pass);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
}

?>
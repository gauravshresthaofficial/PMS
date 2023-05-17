<?php


// --------------CHECK FOR LOGIN--------------
function check_login($name, $pw){
    require "connection.php";
    
    if($conn)
    {
        $error = "";
        $stmt = $conn->prepare("SELECT * FROM admin WHERE USERNAME = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $arr = $stmt->get_result()->fetch_assoc();        
        // no result return false
        if(!$arr) return "Username not Found!";

        //check username and password
        if($pw != $arr["password"] )
        {
            $error = "Username and Password do not match!";
        }
        return $error;
        $stmt->close();
    }
    else
    {
        return "Connection error";
    }
}



?>
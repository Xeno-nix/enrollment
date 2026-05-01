<?php 
    $servername = "localhost";
    $username = "root";
    $dbname = "enrollment";
    $password = "567796";

    try {
        $con = new mysqli($servername,$username,$password,$dbname);
       //echo '<script>alert("Connected Succesfully")</script>';
    } catch (Exception $e) {
        //echo '<script>alert("Connected Succesfully'. $e -> getMessage(). '")</script>';
    }

?>
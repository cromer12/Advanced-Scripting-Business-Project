<?php 
    // Author:      Dylan Porter
    // Date:        11/19/2017
    // Purpose:     Update the password of the user in the database
    

    //TODO: redirect to the correct page
    //TODO: error checking for entering the same password


    // open connection to database
    require_once('connect.php');

    if (isset($_POST['password']) && isset($_POST['repassword']))
    {
        // grab and santize user input
        $password = $_POST['password'];
        $password = trim($password);
        $password = mysqli_real_escape_string($conn, $password);
        
        $repassword = $_POST['repassword'];
        $repassword = trim($repassword);
        $repassword = mysqli_real_escape_string($conn, $repassword);
        
        $user = $_POST['user'];
        $user = trim($user);
        $user = mysqli_real_escape_string($conn, $user);
        
        
        // update the password of the user
        $sql = "UPDATE logins
                    SET password_hash=PASSWORD('" . $password . "')
                    WHERE md5(username)='" . $user . "'";
        
        $result = $conn->query($sql);
        
        //header(Location: CORRECTPAGE);
    }
?>
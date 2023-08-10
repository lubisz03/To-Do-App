<?php
   include('./db/dbconfig.php');
   include('./db/dbconnection.php');

    session_start();

    $db = (new DB($db_config))->getConnection();

    if ( !isset($_POST['username'], $_POST['password']) ) {
        exit('Please fill both the username and password fields!');
    }

    if ($stmt = $db->prepare('INSERT INTO accounts (username, password) VALUES(?, ?)')) {
        $stmt->bind_param('ss', $_POST['username'], password_hash($_POST["password"], PASSWORD_DEFAULT));

        if ($stmt->execute()) {
            header('Location: index.html');
        } else {
            echo 'Sign-up failed! Try using different username';
        }
    
    } else {
        echo 'Sign-up failed! Try using different username';
    }

    $stmt->close();
 ?>
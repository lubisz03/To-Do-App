<?php
    include('./db/dbconfig.php');
    include('./db/dbconnection.php');

    session_start();

    $db = (new DB($db_config))->getConnection();

    if ( !isset($_POST['username'], $_POST['password']) ) {
        exit('Please fill both the username and password fields!');
    }

    if ($stmt = $db->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
     
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $password);
            $stmt->fetch();
            if (password_verify($_POST['password'], $password)) {
                session_regenerate_id();
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['name'] = $_POST['username'];
                $_SESSION['id'] = $id;
                header('Location: home.php');
            } else { 
                echo 'Incorrect username and/or password!';
            }
        } else {
            echo 'Incorrect username and/or password!';
        }
    
        $stmt->close();
    }
 ?>
<?php 
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'to-do';

     $id = $_REQUEST['taskId'];
 
     $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
     if ( mysqli_connect_errno() ) {
         exit('Failed to connect to MySQL: ' . mysqli_connect_error());
     }

 
     if ($stmt = $con->prepare('DELETE FROM tasks WHERE id = ?')) {
         $stmt->bind_param('i', $id);
 
         if ($stmt->execute()) {
             header('Location: home.php');
         } else {
             echo 'Action failed! Please try again';
         }
     
         $stmt->close();
     }
 
     header('Location: home.php');
?>
<?php 
    include('./db/dbconfig.php');
    include('./db/dbconnection.php');

    $db = (new DB($db_config))->getConnection();

    $id = $_REQUEST['taskId'];
 
     if ($stmt = $db->prepare('DELETE FROM tasks WHERE id = ?')) {
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
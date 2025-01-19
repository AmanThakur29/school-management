<?php
include('../conn.php');
if(isset($_GET['user_id'])){
    $user_id = $_GET['user_id'];
    $sql= "DELETE FROM user WHERE id = $user_id";
    $result = mysqli_query($conn , $sql);
    
    if($result){
        echo "deleted successfull";
      }
  }

?>
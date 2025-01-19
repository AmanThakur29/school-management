<?php
include('../conn.php');
print_r($_GET);
if (isset($_GET['class_id']) && !empty($_GET['class_id'])) {
    $class_id = $_GET['class_id'];
    $sql = "DELETE  FROM class WHERE id = '$class_id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "deleted succesfully";
        header('Location: all-class.php');
    }
} else {
    header('Location: all-class.php');
}

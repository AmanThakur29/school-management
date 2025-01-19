<?php
include('../conn.php');
include('../constant.php');
if (isset($_SESSION['user_id']) && empty($_SESSION['user_id'])) {
    header('Location:../sign-in.php');
} else {
    $user_id = $_SESSION['user_id'];
}

$sql = "SELECT * FROM user WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);
}


// print_r($data);
if (!empty($data)) {
    if (isset($data['role']) && $data['role'] != 'student') {
        header('Location: ../sign-in.php');
    }
}
?>





<?php
include('../template-parts/header.php');

?>






<?php
include('../template-parts/footer.php');
?>
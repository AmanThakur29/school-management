<?php
include('../constant.php');
include('../conn.php');
if (!isset($_SESSION['user_id']) || (isset($_SESSION['user_id']) && empty($_SESSION['user_id']))) {
    header('Location:../sign-in.php');
} else {
    $user_id = $_SESSION['user_id'];
}
$sql = "SELECT * FROM user WHERE id ='$user_id'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);
}
if (!empty($data)) {
    if (isset($data['role']) && $data['role'] != 'admin') {
        header('Location:sign-in.php');
    }
}

$users = [];
$sql = "SELECT user.*, class_students.class_id FROM user LEFT JOIN class_students ON class_students.student_id = user.id WHERE user.role = 'student'";
$result = mysqli_query($conn, $sql);


if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        if (!empty($row['class_id'])) {
            $sql = "SELECT * FROM class WHERE id='" . $row['class_id'] . "'";
            $classResult = mysqli_query($conn, $sql);
            if (mysqli_num_rows($classResult) > 0) {
                $data = mysqli_fetch_assoc($classResult);
                $row['class_name'] = $data['class'];
            }
        } else {
            $row['class_name'] = '';
        }
       
        $users[] = $row;
    }
}


?>

<?php
include('../template-parts/header.php');
?>
<div class="container p-5">
    <h1>All users</h1>
    <table class="table table-striped">
        <tr>
            <th>name</th>
            <th>email</th>
            <th>password</th>
            <th>contact</th>
            <th>Role</th>
            <th>Class Name</th>
            <th>action</th>

        </tr>
        <?php
        foreach ($users as $user) { ?>

            <tr>
                <td><?php echo $user['name'] ?></td>
                <td><?php echo $user['email'] ?></td>
                <td><?php echo $user['password'] ?></td>
                <td><?php echo $user['contact'] ?></td>
                <td><?php echo $user['role'] ?></td>
                <td><?php echo !empty($user['class_name']) ?$user['class_name']:'N/A'; ?></td>
                <td>
                    <a href="edit.php?user_id=<?php echo $user['id']; ?>" class="btb btn-sm btn-outline->primary">Edit</a>

                    <a href="delete.php?user_id=<?php echo $user['id']; ?>" class="btb btn-sm btn-outline-primary">Delete</a>
                 </td>


            </tr>
        <?php
        }
        ?>
    </table>
</div>
<?php
include('../template-parts/footer.php');
?>
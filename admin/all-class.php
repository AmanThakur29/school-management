<?php
include('../constant.php');
include('../conn.php');

if (!isset($_SESSION['user_id']) || (isset($_SESSION['user_id']) && empty($_SESSION['user_id']))) {
    header('Location:../sign-in.php');
} else {
    $user_id = $_SESSION['user_id'];
}


$sql = "SELECT * FROM user WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);
}
if (!empty($data)) {
    if (isset($data['role']) && $data['role'] != 'admin') {
        header('Location:sign-in.php');
    }
}


// $sql = "SELECT id, class , class_code , class_description from class";
$sql = "SELECT * FROM class";
$result = mysqli_query($conn, $sql);
$data = mysqli_num_rows($result);
if ($data > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $classes[] = $row;
    }
}
// print_r($sql);
?>



<?php
include('../template-parts/header.php');
?>

<div class="container p-5">
    <h1>All class</h1>
    <table class="table table-striped">
        <tr>
            <th>class</th>
            <th>class code</th>
            <th>class description</th>
            <th>Action</th>


        </tr>
        <?php
        foreach ($classes as $class) { ?>

            <tr>
                <td><?php echo $class['class'] ?></td>
                <td><?php echo $class['class_code'] ?></td>
                <td><?php echo $class['class_description'] ?></td>
                <td class="align-middle">
                    <a href="edit-class.php?class_id=<?php echo $class['id']; ?>" class="btn btn-outline-primary btn-sm text-xs" data-toggle="tooltip" data-original-title="Edit user">
                        Edit
                    </a>
                    <a href="view.php?class_id=<?php echo $class['id']; ?>" class="btn btn-sm btn-outline-secondary">view</a>
                    <a href="delete-class.php?class_id=<?php echo $class['id']; ?>" class="btn btn-outline-danger btn-sm text-xs" data-toggle="tooltip" data-original-title="delete user">
                        Delete
                    </a>
            </tr>
        <?php
        }
        ?>
    </table>
</div>
<?php
include('../template-parts/footer.php');
?>
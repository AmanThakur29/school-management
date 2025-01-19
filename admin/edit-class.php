<?php
include('../constant.php');
include('../conn.php');

if (!isset($_SESSION['user_id']) || (isset($_SESSION['user_id']) && empty($_SESSION['user_id']))) {
    header('Location: ../sign-in.php');
} else {
    $user_id = $_SESSION['user_id'];
}
$sql = "SELECT * FROM class WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $user_data = mysqli_fetch_assoc($result);
}

if (!empty($user_data)) {
    if (isset($user_data['role']) && $user_data['role'] != 'admin') {
        header('Location:../sign-in.php');
    }
}

$class_id = isset($_GET['class_id']) && !empty($_GET['class_id']) ? $_GET['class_id'] : '';

if (empty($class_id)) {
    header('Location: all-class.php');
}

$classErr = '';
$classcodeErr = '';
$classdesErr = '';
$success = '';
$class_data = array();

if (isset($_POST['update'])) {
    $date = date('Y-m-d H:i:s');
    
    if (isset($_POST['class']) && empty($_POST['class'])) {
        $classErr = 'class is required';
    } else {
        $class = $_POST['class'];
    }

    if (isset($_POST['class_code']) && empty($_POST['class_code'])) {
        $classcodeErr = 'class_code is required';
    } else {
        $class_code = $_POST['class_code'];
    }
    if (isset($_POST['class_des']) && empty($_POST['class_des'])) {
        $classdesErr = 'class_des is required';
    } else {
        $class_description = $_POST['class_description'];
    }
    if (empty($classErr) && empty($classcodeErr) && empty($classdesErr)) {
        $sql = "UPDATE class SET class = '$class', class_code = '$class_code', class_description = '$class_description', updated_at='$date'  WHERE id = '$class_id'";
       
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $success = 'Class updated successfully';
        } else {
            echo mysqli_error($conn);
        }
    }
}

$sql = "SELECT * FROM class WHERE id=$class_id";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){
    $class_data = mysqli_fetch_assoc($result);
}

?>






<?php
include('../template-parts/header.php');
?>
<div class="form-container">
    <?php echo $success; ?>
    <form action="" method="POST">

        <!-- Name -->
        <div class="form-group">
            <label for="class">Class</label>
            <input type="text" id="class" name="class" placeholder="Enter your class" value="<?php echo !empty($class) ? $class : $class_data['class'] ?>">
            <span class="text-danger"><?php echo $classErr ?></span>
        </div>
        <div class="form-group">
            <label for="class_code">Class code</label>
            <input type="text" id="class_code" name="class_code" placeholder="Enter your class code" value="<?php echo !empty($class_code) ? $class_code : $class_data['class_code']  ?>">
            <span class="text-danger"><?php echo $classcodeErr ?></span>
        </div>
        <div class="form-group">
            <label for="class_description">Class Description</label>
            <textarea name="class_description" id="class_description" class="form-control w-100" placeholder="Enter your class description"><?php echo !empty($class_description) ? $class_description : $class_data['class_description'] ?></textarea>
            <span class="text-danger"><?php echo $classdesErr ?></span>


        </div>



        <!-- Submit Button -->
        <div class="form-group">
            <button type="submit " name="update">Update-class</button>
        </div>
    </form>
</div>










<?php
include('../template-parts/footer.php');
?>
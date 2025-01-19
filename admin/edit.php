<?php
include('../constant.php');
include('../conn.php');

print_r($_SESSION);

if (!isset($_SESSION['user_id']) || (isset($_SESSION['user_id']) && empty($_SESSION['user_id']))) {
    header('Location: ../sign-in.php');
} else {
    $current_user = $_SESSION['user_id'];
}

$sql = "SELECT * FROM user WHERE id = '$current_user'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $current_user_data = mysqli_fetch_assoc($result);
}

if (!empty($current_user_data)) {
    if (isset($current_user_data['role']) && $current_user_data['role'] != 'admin') {
        header('Location: ../sign-in.php');
    }
}



$user_id = isset($_GET['user_id']) && !empty($_GET['user_id']) ? $_GET['user_id'] : '';

$nameErr = '';
$emailErr = '';
$passErr = '';
$conErr = '';
$roleErr = '';
$classErr = '';
$success = '';
if (isset($_POST['update'])) {
    if (isset($_POST['name']) && empty($_POST['name'])) {
        $nameErr = 'name is required';
    } else {
        $name = $_POST['name'];
    }
    if (isset($_POST['email']) && empty($_POST['email'])) {
        $emailErr = 'email is required';
    } else {
        $email = $_POST['email'];
        $sql = "SELECT * FROM user WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
    }
    if (isset($_POST['password']) && empty($_POST['password'])) {
        $passErr = 'password is requried';
    } else {
        $password = $_POST['password'];
    }

    if (isset($_POST['contact']) && empty($_POST['contact'])) {
        $conErr = 'contact is required';
    } else {
        $contact = $_POST['contact'];
    }
    if (isset($_POST['class']) && empty($_POST['class'])) {
        $classErr = 'Class is required';
    } else {
        $class_id = $_POST['class'];
    }

    if (empty($nameEr) && empty($emailErr) && empty($passErr) && empty($conErr) && empty($roleErr) && empty($classErr)) {
        $sql = "UPDATE user SET name = '$name', email = '$email', password = '$password',contact = '$contact' WHERE id = '$user_id'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $sql = "SELECT role FROM user WHERE id = '$user_id'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $user_role = mysqli_fetch_assoc($result);

                if ($user_role['role'] == 'student') {
                    $checkSql = "SELECT * FROM class_students WHERE student_id = $user_id";
                    $checkRes = mysqli_query($conn, $checkSql);

                    if (mysqli_num_rows($checkRes) > 0) {
                        $updateSql = "UPDATE class_students SET class_id = $class_id WHERE student_id = $user_id";
                        $updateRes = mysqli_query($conn, $updateSql);
                        if ($updateRes) {
                            $success = 'Profile updated successfully.';
                        } else {
                            echo mysqli_error($conn);
                        }
                    } else {
                        $insertSql = "INSERT INTO class_students (class_id, student_id) VALUES($class_id, $user_id)";
                        $insertRes = mysqli_query($conn, $insertSql);
                        if ($insertRes) {
                            $success = 'Profile updated successfully.';
                        } else {
                            echo mysqli_error($conn);
                        }
                    }
                }
                
                if($user_role['role'] == 'teacher'){
                    $sql="SELECT * FROM class_teacher WHERE teacher_id = $user_id";
                    $res=mysqli_query($conn , $sql);
                
                if(mysqli_num_rows($res) > 0){
                    $upsql = "UPDATE class_teacher SET class_id = $class_id WHERE teacher_id = $user_id";
                    $res = mysqli_query($conn, $upsql);
                    if ($res) {
                        $success = 'Profile updated successfully.';
                    } else {
                        echo mysqli_error($conn);
                    }
                
                }else {
                    $insertSql = "INSERT INTO class_teacher (class_id, teacher_id) VALUES($class_id, $user_id)";
                    $insertRes = mysqli_query($conn, $insertSql);
                    if ($insertRes) {
                        $success = 'Profile updated successfully.';
                    } else {
                        echo mysqli_error($conn);
                    }
                }
                
                }
            }
        } else {
            echo mysqli_error($conn);
        }
    }

}

if (!empty($user_id)) {
    $sql = "SELECT * FROM user WHERE id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    print_r($user_id);
    if (mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);
    }
}
$classes_data = [];
$sql = "SELECT id, class FROM class";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $classes_data[] = $row;
    }
}

?>
<?php
include('../template-parts/header.php');

?>
<div class="form-container">
    <form action="" method="POST">
        <!-- Name -->
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="Enter your name" value="<?php echo !empty($name) ? $name : $user_data['name']; ?>">
            <span class="text-danger"><?php echo $nameErr ?></span>
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" value="<?php echo !empty($email) ? $email : $user_data['email']; ?>">
            <span class="text-danger"><?php echo $emailErr ?></span>
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" value="<?php echo !empty($password) ? $password : $user_data['password'] ?>">
            <span class="text-danger"><?php echo $passErr ?></span>
        </div>



        <!-- Contact -->
        <div class="form-group">
            <label for="contact">Contact Number</label>
            <input type="tel" id="contact" name="contact" placeholder="Enter your contact number" value="<?php echo !empty($contact) ? $contact : $user_data['contact'] ?>">
            <span class="text-danger"><?php echo $conErr ?></span>
        </div>


        <!-- Class -->
        <div class="form-group">
            <label for="class">Class </label>
            <select id="class" name="class">" >
                <option value="">Select Class</option>
                <?php
                if (!empty($classes_data)) {
                    foreach ($classes_data as $class_data) {
                ?>
                        <option value="<?php echo $class_data['id']; ?>" <?php //echo $class_data['id'] == '';  ?> ><?php echo $class_data['class']; ?></option>

                <?php
                    }
                }
                ?>
            </select>
            <span class="text-danger"><?php echo $classErr ?></span>
        </div>

        <!-- Submit Button -->
        <div class="form-group">
            <button type="submit " name="update">update</button>
        </div>
    </form>
</div>










<?php
include('../template-parts/footer.php');
?>
<?php
include('constant.php');
include('conn.php');
$emailErr = "";
$passErr = "";

if (isset($_POST['insert'])) {
    if (isset($_POST['email']) && empty($_POST['email'])) {
        $emailErr = 'email is required';
    } else {
        $email = $_POST['email'];
    }
    if (isset($_POST['password']) && empty($_POST['password'])) {
        $passErr = 'password is required';
    } else {
        $password = $_POST['password'];
    }
    if (empty($emailErr) && empty($passErr)) {

        $sql = "SELECT * FROM user WHERE email = '$email' and password = '$password'";
        $result = mysqli_query($conn, $sql);
        // print_r($sql);
        // die;
        if (mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            $_SESSION['user_id'] = $user_data['id'];
            if (isset($user_data['role']) && $user_data['role'] == 'admin') {
                header('location: admin/admin.php');
            } else if (isset($user_data['role']) && $user_data['role'] == 'student') {
                header('location: student/student.php');
            }else {
                header('location: teacher/teacher.php');

            }
            echo "succes";
        } else {
            echo "not succes";
        }
    }
}


$user_id = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

$sql = "SELECT * FROM user WHERE id = '$user_id'";
$result = mysqli_query($conn , $sql);
if(mysqli_num_rows($result) > 0){
    $data = mysqli_fetch_assoc($result);
}

if(!empty($data)){
    if(isset($data['role'])&& $data['role'] == 'admin'){
        header('Location:admin/admin.php');
    }
}
?>

<?php
include('template-parts/header.php');
?>


</head>

<body>
    <!-- <form class="login-form" method="POST">
        <h2>Login</h2>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
        </div>
        <div class="form-group">
            <button type="submit" name="insert">sign-in</button>
        </div>
        <div class="form-footer">
            <p>Don't have an account? <a href="sign-up.php">Sign Up</a></p>
        </div>
    </form> -->
    <div class="form-container">
        <h2>School Management System</h2>
        <form action="" method="POST">
            <h2>Login</h2>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>

            <!-- Submit Button -->
            <div class="form-group">
                <button type="submit " name="insert">Login</button>
            </div>
        </form>
        <div class="form-footer">
            <p>Don't have an account? <a href="sign-up.php">Sign Up</a></p>
        </div>
    </div>
</body>

</html>
















<?php
include('template-parts/footer.php');
?>
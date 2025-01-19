<?php
include('../constant.php');
include('../conn.php');
if (!isset($_SESSION['user_id']) || (isset($_SESSION['user_id']) && empty($_SESSION['user_id']))){
    header('Location:sign-up.php');
}else{
    $user_id = $_SESSION['user_id'];
}

 $sql = "SELECT * FROM user WHERE id = '$user_id'";
 $result = mysqli_query($conn,$sql);
 if(mysqli_num_rows($result) > 0){
    $data = mysqli_fetch_assoc($result);

}if(empty($data)){
    if(isset($_data['role'])&& $data['role'] != 'admin'){
        header('Location:sign-in.php');
    }
}
$nameErr = '';
$emailErr = '';
$passErr = '';
$conErr = '';
$roleErr = '';

if(isset($_POST['insert'])){
if(isset($_POST['name'])&& empty($_POST['name'])){
    $nameErr = 'name is required';
}else{
    $name = $_POST['name'];
}
if(isset($_POST['email'])&& empty($_POST['email'])){
    $emailErr = 'email is required';
}else{
    $email = $_POST['email'];
    $sql = "SELECT * FROM user WHERE email = '$email'";
    $result = mysqli_query($conn , $sql);
}
if(isset($_POST['password'])&&empty($_POST['password'])){
    $passErr = 'password is requried';
}else{
    $password = $_POST['password'];
}
if(isset($_POST['contact'])&&empty($_POST['contact'])){
    $conErr = 'contact is required';
}else{
    $contact = $_POST['contact'];
}
if(isset($_POST['role'])&&empty($_POST['role'])){
    $roleErr = 'role is requried';
}else{
    $role = $_POST['role'];
}
if(empty($nameErr) && empty($emailErr) &&empty($passErr) &&empty($conErr)&& empty($roleErr)){
    $sqli = "INSERT INTO user (name,   email, password,contact , role) VALUES ('$name',   '$email' , '$password' , '$contact', '$role')";
    if(mysqli_query($conn,$sqli)){
        echo 'sucsses';
    }
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
                <input type="text" id="name" name="name" placeholder="Enter your name" >
                <span class="text-danger"><?php echo $nameErr ?></span>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" >
                <span class="text-danger"><?php echo $emailErr ?></span>
            </div>

    <!-- Password -->
    <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password"  >
                    <span class="text-danger"><?php echo $passErr ?></span> 
                </div>

            

            <!-- Contact -->
            <div class="form-group">
                <label for="contact">Contact Number</label>
                <input type="tel" id="contact" name="contact" placeholder="Enter your contact number" >
                <span class="text-danger"><?php echo $conErr ?></span>
            </div>

            

                <!-- Role -->
                <div class="form-group">
                    <label for="role">Role</label >
                    <select id="role" name="role" >" >
                        <option value="">Select Role</option>
                        <option value="student">Student</option>
                        <option value="teacher">Teacher</option>
                        <!-- <option value="admin">Admin</option> -->
                    </select>
                    <span class="text-danger"><?php echo $roleErr ?></span> 
                </div>

            <!-- Submit Button -->
            <div class="form-group">
                <button type="submit " name="insert">add-user</button>
            </div>
        </form>
    </div>










    <?php
    include('../template-parts/footer.php');
    ?>
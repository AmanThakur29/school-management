<?php
include('../constant.php');
include('../conn.php');

if(!isset($_SESSION['user_id']) || (isset($_SESSION['user_id']) && empty($_SESSION['user_id'])) ){
    header('Location:../sign-in.php');
}else{
    $current_user = $_SESSION['user_id'];
}

$sql= "SELECT * FROM user WHERE id = ' $current_user'";
$result=mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $current_user_data = mysqli_fetch_assoc($result);
}

if (!empty($current_user_data)) {
    if (isset($current_user_data['role']) && $current_user_data['role'] != 'admin') {
        header('Location: ../sign-in.php');
    }
}

?>








<?php
$nameErr = '';
$emailErr = '';
$passErr = '';
$conErr = '';

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
    if(isset($_POST['password'])&&empty($_POST['password'])){
        $passErr = 'password is requried';
    }else{
        $password = $_POST['password'];
    }
   
    if (isset($_POST['contact']) && empty($_POST['contact'])) {
        $conErr = 'contact is required';
    } else {
        $contact = $_POST['contact'];
    }
    if (empty($nameEr) && empty($emailErr) && empty($passErr) && empty($conErr) ) {
        $sql = "UPDATE user SET name = '$name', email = '$email', password = '$password',contact = '$contact' WHERE id = '$current_user'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $success = 'Profile updated successfully';
            
        } else {
            echo mysqli_error($conn);
        }
    }
}


?>

<?php
include('../template-parts/header.php');

?>
<div class="form-container">
<?php echo $success;  ?>
    <form action="" method="POST">
        <!-- Name -->
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="Enter your name" value="<?php echo !empty($name) ? $name : $current_user_data['name']; ?>">
            <span class="text-danger"><?php echo $nameErr ?></span>
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" value="<?php echo !empty($email) ? $email : $current_user_data['email']; ?>">
            <span class="text-danger"><?php echo $emailErr ?></span>
        </div>

  <!-- Password -->
  <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" value="<?php echo !empty($password) ? $password : $current_user_data['password'] ?>" >
                <span class="text-danger"><?php echo $passErr ?></span> 
            </div>

         

        <!-- Contact -->
        <div class="form-group">
            <label for="contact">Contact Number</label>
            <input type="tel" id="contact" name="contact" placeholder="Enter your contact number" value="<?php echo !empty($contact) ? $contact : $current_user_data['contact'] ?>">
            <span class="text-danger"><?php echo $conErr ?></span>
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
<?php
include('../constant.php');
include('../conn.php');

if(!isset($_SESSION['user_id'])  || (isset($_SESSION['user_id']) && empty($_SESSION['user_id']))){
    header('Location:../sign-in.php');
}else{
    $user_id = $_SESSION['user_id'];
}
$sql= "SELECT * FROM user WHERE id = '$user_id' ";
$result= mysqli_query($conn , $sql);
if(mysqli_num_rows($result) > 0 ){
    $data = mysqli_fetch_assoc($result);
}
if(!empty($data)){
    if(isset($data['role']) && $data['role'] != 'admin'){
        header('Location:../sign-in.php');
    }
}
// print_r($data);

$classErr='';
$classcodeErr='';
$classdesErr='';
if(isset($_POST['insert'])){
    if(isset($_POST['class']) && empty($_POST['class'])){
        $classErr = 'class is required';
    }else{
        $class = $_POST['class'];
    }

    if(isset($_POST['class_code']) && empty($_POST['class_code'])){
        $classcodeErr = 'class_code is required';
    }else{
        $class_code = $_POST['class_code'];
    }
    if(isset($_POST['class_des']) && empty($_POST['class_des'])){
        $classdesErr = 'class_des is required';
    }else{
        $class_description = $_POST['class_description'];
    }
if(empty($classErr)&& empty($classcodeEr) && empty($classdesErr)){
    $sqli = "INSERT INTO class (class , class_code , class_description) VALUES ('$class' , '$class_code' , '$class_description' )";
    if(mysqli_query($conn,$sqli)){
        echo 'sucsses';
    }else {
        echo mysqli_error($conn);
    }
    // print_r($sqli);
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
            <label for="class">Class</label>
            <input type="text" id="class" name="class" placeholder="Enter your class" >
        <span class="text-danger"><?php echo $classErr ?></span>
        </div>
        <div class="form-group">
            <label for="class_code">Class code</label>
            <input type="text" id="class_code" name="class_code" placeholder="Enter your class code" >
            <span class="text-danger"><?php echo $classcodeErr ?></span>
        </div>
        <div class="form-group">
            <label for="class_description">Class Description</label>
            <textarea name="class_description" id="class_description" class="form-control w-100" placeholder="Enter your class description"></textarea>
            <span class="text-danger"><?php echo $classdesErr ?></span>
        
        
        </div>


       
        <!-- Submit Button -->
        <div class="form-group">
            <button type="submit " name="insert">Add-class</button>
        </div>
    </form>
</div>










<?php
include('../template-parts/footer.php');
?>
<?php
include('../constant.php');
include('../conn.php');

if(!isset($_SESSION['user_id']) || isset($_SESSION['user_id']) && empty($_SESSION['user_id'])){
  
}else{
    $user_id = $_SESSION['user_id'];
}
$sql= "SELECT * FROM user WHERE id = '$user_id'";
$result= mysqli_query($conn,$sql);
if(mysqli_num_rows($result) > 0 ){
    $data = mysqli_fetch_assoc($result);
}
if(!empty($data)){
    if(isset($data['role']) && $data['role'] != 'student'){
        header('Location:../sign-in.php');
    }
}
$sql="SELECT * FROM class_students LEFT JOIN class ON class_students.class_id = class.id WHERE class_students.student_id = '$user_id'";
$result= mysqli_query($conn,$sql);
if(mysqli_num_rows($result) > 0 ){
    $Data = mysqli_fetch_assoc($result);
}
// print_r($Data);
$sqli= "SELECT * FROM class_teacher LEFT JOIN user on class_teacher.teacher_id = user.id where class_teacher.class_id= '". $Data['class_id'] ."'";
$teacherdata=[];
$result1=mysqli_query($conn , $sqli);
if (mysqli_num_rows($result1) > 0) {
    while ($row = mysqli_fetch_assoc($result1)) {
        $teacherdata[] = $row;
    }
}
// print_r($sqli);
?>
<?php
include('../template-parts/header.php');
?>


<div class="container">

<h2>     Class ------ <?php echo (isset($Data['class']) && !empty($Data['class'])) ? $Data['class'] : ''; ?></h2>
<h2>Class Code ------ <?php echo (isset($Data['class_code']) && !empty($Data['class_code'])) ? $Data['class_code'] : ''; ?></h2>



</div>

<div class="container p-5">
   
    <table class="table table-striped">
<tr>
<th>name</th>
<th>email</th>
<th>contact</th>
<th>role</th>

</tr>
<?php
if(!empty($teacherdata)){
foreach($teacherdata as $teacher){
?>

<tr>
<td><?php  echo $teacher['name'] ?></td>
<td><?php  echo $teacher['email'] ?></td>
<td><?php  echo $teacher['contact'] ?></td>
<td><?php  echo $teacher['role'] ?></td>

</tr>

<?php } 
}else{


?>
   <tr>
                    <td colspan="5">
                        <p-</p>
                    </td>
                </tr>
<?php
}
?>

    </table> </div>
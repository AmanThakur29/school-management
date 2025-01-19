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
    if(isset($data['role']) && $data['role'] != 'teacher'){
        header('Location:../sign-in.php');
    }
}
$sql="SELECT class.*,class_teacher.class_id,class_teacher.teacher_id      FROM class_teacher LEFT JOIN class on class_teacher.class_id = class.id WHERE class_teacher.teacher_id = '$user_id' ";
$result=mysqli_query($conn,$sql);
if (mysqli_num_rows($result) > 0) {
    $Data = mysqli_fetch_assoc($result);
}
print_r($Data);
$teacherdata = [];
$sqli = "SELECT * FROM class_students LEFT JOIN user on class_students.student_id = user.id WHERE class_id ='" . $Data['class_id'] . "'";
$result = mysqli_query($conn, $sqli);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $teacherdata[] = $row;
    }
}
?>
<?php
include('../template-parts/header.php');
?>


<div class="container">
<h2><?php echo (isset($Data['class']) && !empty($Data['class'])) ? $Data['class'] : ''; ?></h2>
<h2><?php echo (isset($Data['class_code']) && !empty($Data['class_code'])) ? $Data['class_code'] : ''; ?></h2>
<h2><?php echo (isset($Data['class_description']) && !empty($Data['class_description'])) ? $Data['class_description'] : ''; ?></h2>

</div>
<div class="container p-5">
    <h1>students</h1>
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
                        <p>No students found in this class.</p>
                    </td>
                </tr>
<?php
}
?>

    </table> </div>
<?php
include('../constant.php');
include('../conn.php');

$classData = $classStudents = [];
$class_id = isset($_GET['class_id']) && !empty($_GET['class_id']) ? $_GET['class_id'] : '';

if (!empty($class_id)) {
    $classStudentSql = "SELECT * FROM class_students WHERE class_id = $class_id";
    $results = mysqli_query($conn, $classStudentSql);
    if (mysqli_num_rows($results) > 0) {
        while ($row = mysqli_fetch_assoc($results)) {
            $classStudents = $row;
        }
    }
} else {
    header('Location: all-class.php');
}

$sql = "
SELECT * 
FROM class 
LEFT JOIN class_teacher ON class.id = class_teacher.class_id 
LEFT JOIN user ON class_teacher.teacher_id = user.id 
WHERE class.id = $class_id
";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $classData = mysqli_fetch_assoc($result);
}


$studentdata = [];
$sql = "SELECT * FROM class INNER JOIN class_students ON class_students.class_id = class.id INNER JOIN user on class_students.student_id = user.id WHERE class.id = $class_id";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $studentdata[] = $row;
    }
}
?>
<?php
include('../template-parts/header.php');
?>

<div class="container">
    <h2>Class: <?php echo (isset($classData['class']) && !empty($classData['class'])) ? $classData['class'] : ''; ?></h2>
    <h3>Class Code: <?php echo (isset($classData['class_code']) && !empty($classData['class_code'])) ? $classData['class_code'] : ''; ?></h3>
    <h4>Class Teacher: <?php echo (isset($classData['name']) && !empty($classData['name'])) ? $classData['name'] : ''; ?></h4>
</div>

<div class="container p-5">
    <h1>All users</h1>
    <table class="table table-striped">
        <tr>
            <th>Sr. No.</th>
            <th>class</th>
            <th>class code </th>
            <th>class description</th>
            <th>student id</th>
        </tr>
        <?php
        if (!empty($studentdata)) {
            foreach ($studentdata as $student) { ?>
                <tr>
                    <td><?php echo $student['id'] ?></td>
                    <td><?php echo $student['class'] ?></td>
                    <td><?php echo $student['class_code'] ?></td>
                    <td><?php echo $student['class_description'] ?></td>
                    <td><?php echo $student['student_id'] ?></td>
                <?php
            }
        } else {
                ?>
                <tr>
                    <td colspan="5">
                        <p>No students found in this class.</p>
                    </td>
                </tr>
            <?php
        }
            ?>
    </table>
</div>
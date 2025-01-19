<?php
$user_id = isset($_SESSION['user_id'])&& !empty($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
$sql = "SELECT * FROM user WHERE id = '$user_id'";
$result = mysqli_query($conn , $sql);
if(mysqli_num_rows($result) > 0){
  $data = mysqli_fetch_assoc($result);
}

// print_r($data);
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bootstrap Navbar Example</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo SITE_URI; ?>assets/css/style.css">
</head>
<body>
  <!-- Header with Navbar -->
  <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">MyWebsite</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>
            <?php   if(isset($data['role'])&& $data['role'] == 'admin') { ?>
            <li class="nav-item">
              <a class="nav-link" href="all-user.php">All users</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="add-user.php">Add user </a>
            </li>

           
            <li class="nav-item">
              <a class="nav-link" href="all-student.php">All student </a>
            </li>
           
            <li class="nav-item">
              <a class="nav-link" href="all-teacher.php">All teacher </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="add-class.php">Add Class</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="all-class.php">All Class</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="profile.php">Profile </a>
            </li>
            <?php } ?>
            <?php if(!isset($_SESSION['user_id'])) {  ?>
            <li class="nav-item">
              <a class="nav-link" href="sign-up.php">Sign up</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="sign-in.php">Sign in</a>
            </li>
            <?php  }?>
        
            <li class="nav-item">
              <a class="nav-link" href="../log-out.php">log out</a>
            </li>
            <?php   if(isset($data['role'])&& $data['role'] == 'teacher') { ?>
              <li class="nav-item">
              <a class="nav-link" href="../teacher/profile.php">Profile </a>
            </li>
              <li class="nav-item">
              <a class="nav-link" href="../teacher/class.php">class </a>
            </li>
            <?php } ?>
            <?php if(isset($data['role']) && $data['role'] == 'student') {?>
              <li class="nav-item">
              <a class="nav-link" href="../student/profile.php">Profile </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../student/class-teacher.php">class teacher </a>
            </li>
              <?php }?>
          </ul>
        </div>
      </div>
    </nav>
  </header>

 

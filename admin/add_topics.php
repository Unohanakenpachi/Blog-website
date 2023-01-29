<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

$userQuery = $conn->prepare("SELECT * FROM `admin` WHERE id = $admin_id");
$userQuery->execute();
$user = $userQuery->fetch(PDO::FETCH_ASSOC);
$postStatus = $user['role'] == "admin" ? "active" : "deactive";


if(isset($_POST['publish'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $code = $_POST['code'];
   $code = filter_var($code, FILTER_SANITIZE_STRING);
      $insert_tag = $conn->prepare("INSERT INTO `topics`(name, code) VALUES(?,?)");
      $insert_tag->execute([$name, $code]);
      $message[] = 'topics published!';
   
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>topics</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>


<?php include '../components/admin_header.php' ?>

<section class="post-editor">

   <h1 class="heading">add new topic</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <p>topic name <span>*</span></p>
      <input type="text" name="name" maxlength="100" required placeholder="add topic title" class="box">
      <p>topic code <span>*</span></p>
      <input type="text" name="code" maxlength="100" required placeholder="add topic code" class="box">
      <div class="flex-btn">
         <input type="submit" value="Create topic" name="publish" class="btn">
      </div>
   </form>

</section>


<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>
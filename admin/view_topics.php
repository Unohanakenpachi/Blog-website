<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['delete'])){

   $p_id = $_POST['topic_id'];
   $p_id = filter_var($p_id, FILTER_SANITIZE_STRING);

   $delete_topic = $conn->prepare("DELETE FROM `topics` WHERE id = ?");
   $delete_topic->execute([$p_id]);
   $message[] = 'topic deleted successfully!';

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>posts</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<section class="show-posts">

   <h1 class="heading">your topics</h1>

   <div class="box-container">

      <?php

         $admin_query = $conn->prepare("SELECT role from admin WHERE id = ?");
         $admin_query->execute([$admin_id]);
         $admin = $admin_query->fetch(PDO::FETCH_ASSOC);
         if($admin['role'] == "admin") {
            $select_posts = $conn->prepare("SELECT * FROM `topics`");
         } else {
            header('location:dashboard.php');
         }
         $select_posts->execute();
         if($select_posts->rowCount() > 0){
            while($fetch_posts = $select_posts->fetch(PDO::FETCH_ASSOC)){
               $post_id = $fetch_posts['id'];

      ?>
      <form method="post" class="box">
         <input type="hidden" name="post_id" value="<?= $post_id; ?>">
            <div class="title"><?= $fetch_posts['name']; ?></div>
         <div class="posts-content"><?= $fetch_posts['code']; ?></div>
         <div class="flex-btn">
            <!-- <a href="edit_topic.php?id=<?= $post_id; ?>" class="option-btn">edit</a> -->
            <button type="submit" name="delete" class="delete-btn" onclick="return confirm('delete this post?');">delete</button>
         </div>
      </form>
      <?php
            }
         }else{
            echo '<p class="empty">no topics added yet! <a href="add_topics.php" class="btn" style="margin-top:1.5rem;">add topic</a></p>';
         }
      ?>

   </div>


</section>









<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>
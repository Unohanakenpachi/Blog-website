<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/like_post.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>


<section class="posts-container">

   <h1 class="heading">latest posts</h1>


   <section class="posts">
        <div class="container posts__container">
        <?php
         $select_posts = $conn->prepare("SELECT * FROM `posts` WHERE status = ? ORDER BY date DESC LIMIT 6  ");
         $select_posts->execute(['active']);
         if($select_posts->rowCount() > 0){
            while($fetch_posts = $select_posts->fetch(PDO::FETCH_ASSOC)){
               
               $post_id = $fetch_posts['id'];

               $topic_id = $fetch_posts['topic_id'];
               $topic = $conn->prepare("SELECT * FROM `topics` WHERE id = ?");
               $topic->execute([$topic_id]);
               $topic = $topic->fetch();

               $count_post_comments = $conn->prepare("SELECT * FROM `comments` WHERE post_id = ?");
               $count_post_comments->execute([$post_id]);
               $total_post_comments = $count_post_comments->rowCount(); 

               $count_post_likes = $conn->prepare("SELECT * FROM `likes` WHERE post_id = ?");
               $count_post_likes->execute([$post_id]);
               $total_post_likes = $count_post_likes->rowCount();

               $confirm_likes = $conn->prepare("SELECT * FROM `likes` WHERE user_id = ? AND post_id = ?");
               $confirm_likes->execute([$user_id, $post_id]);
      ?>

            <article class="post">
                <div class="post__thumbnail">
                <?php
            if($fetch_posts['image'] != ''){  
         ?>
         <img src="uploaded_img/<?= $fetch_posts['image']; ?>" class="post-image" alt="">
         <?php
         } else{ ?>
            <img src="https://picsum.photos/seed/picsum/400/200">
         <?php }
         ?>
                </div>
                <div class="post__info">
                    <a href="category.php?category=<?= $topic ? $topic['id'] : 0; ?>" class="category__button"><?= $topic ? $topic['name'] : 'Uncategorized'; ?></a>
                    <h3 class="post__title">
                        <a href="view_post.php?post_id=<?= $post_id; ?>"><?= $fetch_posts['title']; ?></a>
                    </h3>
                    <p class="post__body">
                    <?= $fetch_posts['content']; ?>
                    </p>
                    <div class="post__author">
                        <div class="post__author-avatar">
                            <img src="https://picsum.photos/20/20">
                        </div>
                        <a href="author_posts.php?author=<?= $fetch_posts['name']; ?>" class="post__author-info">
                            <h5>By: <?= $fetch_posts['name']; ?></h5>
                            <small><?= date_format(date_create($fetch_posts['date']), "Y jS M G:i:s A"); ?></small>
         </a>
                    </div>
                </div>
            </article>
            <?php
         }
      }else{
         echo '<p class="empty">no posts added yet!</p>';
      }
      ?>
        </div>
   </section>



   <div class="more-btn" style="text-align: center; margin-top:1rem;">
      <a href="posts.php" class="inline-btn">view all posts</a>
   </div>

</section>



















<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
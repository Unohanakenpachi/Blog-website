<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <section class="flex">

      <a href="home.php" class="logo">Food Mario.</a>

      <form action="search.php" method="POST" class="search-form">
         <input type="text" name="search_box" class="box" maxlength="100" placeholder="search for blogs" required>
         <button type="submit" class="fas fa-search" name="search_btn"></button>
      </form>

      <div class="icons">
         <div id="menu-btn" class="fas fa-user"></div>
         <div id="search-btn" class="fas fa-search"></div>
      </div>

      <nav class="navbar">


         <a href="home.php"> <i class="fas fa-angle-right"></i> home</a>
         <a href="posts.php"> <i class="fas fa-angle-right"></i> posts</a>
         <a href="all_topics.php"> <i class="fas fa-angle-right"></i> topics</a>
         <a href="authors.php"> <i class="fas fa-angle-right"></i> authors</a>
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
               $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <a href="update.php"><i class="fas fa-angle-right"></i> update profile</a>
         <a href="components/user_logout.php" onclick="return confirm('logout from this website?');" ><i class="fas fa-angle-right"></i>logout</a>

         <?php
            } else { ?> 
         <a href="login.php"> <i class="fas fa-angle-right"></i> login</a>
         <a href="register.php"> <i class="fas fa-angle-right"></i> register</a>
         <?php } ?>
      </nav>


   </section>

</header>
<?php

include 'components/connect.php';

// memeriksa apakah ada cookie dengan nama 'user_id'. Jika ada, nilai 'user_id' 
// akan disimpan dalam variabel $user_id. Jika tidak ada cookie 'user_id', variabel $user_id 
// akan diisi dengan nilai string kosong ('').
if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Billiard Course</title>
   <link rel="icon" href="images/aaaaa.png">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<!-- import file user_header.php yang untuk  header pengguna. -->
<?php include 'components/user_header.php'; ?>

<!-- about awal  -->

<section class="about">

   <div class="row">

      <div class="image">
         <img src="images/billiard.jpg" alt="">
      </div>

      <div class="content">
         <h3>why choose us?</h3>
         <p>Karna kami memiliki tim instruktur yang terdiri dari para ahli yang berpengalaman dalam dunia billiard. 
            Mereka memiliki pengetahuan mendalam dan keterampilan yang diperlukan untuk membantu Anda menguasai teknik-teknik billiard dengan baik.
            Kurikulum kami mencakup berbagai topik mulai dari dasar-dasar billiard hingga strategi permainan yang lebih canggih. 
            Anda akan mempelajari segala hal yang perlu Anda ketahui untuk menjadi seorang pemain billiard yang handal.
         </p>
         
      </div>

   </div>

   <div class="box-container">

      <div class="box">
         <i class="fas fa-graduation-cap"></i>
         <div>
            <span>Kursus Online</span>
         </div>
      </div>

      <div class="box">
         <i class="fas fa-user-graduate"></i>
         <div>
            <span>Siswa</span>
         </div>
      </div>

      <div class="box">
         <i class="fas fa-chalkboard-user"></i>
         <div>
            <span>Guru Ahli</span>
         </div>
      </div>

      <div class="box">
         <i class="fas fa-briefcase"></i>
         <div>
            <span>Pemain Billiard Perfesional</span>
         </div>
      </div>

   </div>

</section>

<!-- about akhir -->

<!-- reviews awal  -->
<!-- menampilkan ulasan-ulasan dari pengguna.-->

<section class="reviews">

   <h1 class="heading">reviews</h1>

   <div class="box-container">

      <?php
         $select_feedback = $conn->prepare("SELECT * FROM `feedback` ORDER BY datetime DESC");
         $select_feedback->execute();
         if($select_feedback->rowCount() > 0){
            while($fetch_feedback = $select_feedback->fetch(PDO::FETCH_ASSOC)){
               $user_id = $fetch_feedback['user_id'];

               $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
               $select_user->execute([$user_id]);
               $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);
      ?>
      <div class="box">
         <p><?= $fetch_feedback['message']; ?></p>
         <div class="user">
            <img src="uploaded_files/<?= $fetch_user['image']; ?>" alt="">
            <div>
               <h3><?= $fetch_user['name']; ?></h3>
               <div class="stars">
                  <?php
                     $rating = $fetch_feedback['reting'];
                     for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $rating) {
                           echo '<i class="fas fa-star"></i>';
                        } elseif ($i == ceil($rating)) {
                           echo '<i class="fas fa-star-half-alt"></i>';
                        } else {
                           echo '<i class="far fa-star"></i>';
                        }
                     }
                  ?>
               </div>
            </div>
         </div>
      </div>


      <?php
         }
      } else {
         echo '<p class="empty">Belum ada ulasan yang ditambahkan!</p>';
      }
      ?>

   </div>

</section>

<!-- reviews akhir -->









<!-- mengimpor file footer.php -->
<?php include 'components/footer.php'; ?>

<!-- link file  -->
<script src="js/script.js"></script>
   
</body>
</html>
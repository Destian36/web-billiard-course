<?php

include '../components/connect.php';

if(isset($_COOKIE['tutor_id'])){
   $tutor_id = $_COOKIE['tutor_id'];
}else{
   $tutor_id = '';
   header('location:login_admin.php');
}

// Query untuk mendapatkan total user
$select_users = $conn->prepare("SELECT COUNT(*) AS total_users FROM `users`");
$select_users->execute();
$total_users = $select_users->fetch(PDO::FETCH_ASSOC)['total_users'];

// Query untuk mendapatkan total coach
$select_coaches = $conn->prepare("SELECT COUNT(*) AS total_coaches FROM `tutors`");
$select_coaches->execute();
$total_coaches = $select_coaches->fetch(PDO::FETCH_ASSOC)['total_coaches'];

// Query untuk menghitung total komentar
$select_total_comments = $conn->prepare("SELECT COUNT(*) AS total_comments FROM comments");
$select_total_comments->execute();
$total_comments = $select_total_comments->fetch(PDO::FETCH_ASSOC)['total_comments'];

$select_total_contact = $conn->prepare("SELECT COUNT(*) AS total_contact FROM contact");
$select_total_contact->execute();
$total_contact = $select_total_contact->fetch(PDO::FETCH_ASSOC)['total_contact'];

$select_content = $conn->prepare("SELECT COUNT(*) AS total_content FROM `content`");
$select_content->execute();
$total_content = $select_content->fetchColumn();

$select_playlist = $conn->prepare("SELECT COUNT(*) AS total_playlist FROM `playlist`");
$select_playlist->execute();
$total_playlist = $select_playlist->fetchColumn();

$select_message = $conn->prepare("SELECT COUNT(*) AS total_message FROM `message`");
$select_message->execute();
$total_message = $select_message->fetchColumn();

$select_feedback = $conn->prepare("SELECT COUNT(*) AS total_feedback FROM `feedback`");
$select_feedback->execute();
$total_feedback = $select_feedback->fetchColumn();

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Billiard Course</title>
   <link rel="icon" href="../images/aaaaa.png">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin1.style.css">

</head>
<body>

<?php include '../components/admin1_header .php'; ?>
   
<section class="dashboard">

   <h1 class="heading">dashboard</h1>

   <div class="box-container">

      <div class="box">
         <h3>welcome!</h3>
         <p><?= $fetch_profile['name']; ?></p>
         <a href="profile_admin.php" class="btn">view profile</a>
      </div>

      <div class="box">
         <h3><?= $total_users; ?></h3>
         <p>Total User</p>
         <a href="data_user.php" class="btn">View User</a>
      </div>

      <div class="box">
         <h3><?= $total_coaches; ?></h3>
         <p>Total Coach</p>
         <a href="data_pelatih.php" class="btn">View Coaches</a>
      </div>

      <div class="box">
         <h3><?= $total_comments; ?></h3>
         <p>total comments</p>
         <a href="data_comments.php" class="btn">view comments</a>
      </div>

      <div class="box">
         <h3><?= $total_contact; ?></h3>
         <p>total contact</p>
         <a href="data_content.php" class="btn">view contact</a>
      </div>

      <div class="box">
            <h3><?= $total_content; ?></h3>
            <p>Total Video</p>
            <a href="data_video.php" class="btn">view video</a>
      </div>

      <div class="box">
            <h3><?= $total_playlist; ?></h3>
            <p>Total Playlist</p>
            <a href="data_playlist.php" class="btn">view playlist</a>
      </div>

      <div class="box">
            <h3><?= $total_message; ?></h3>
            <p>Total Message</p>
            <a href="data_message.php" class="btn">view Message</a>
      </div>

      <div class="box">
            <h3><?= $total_feedback; ?></h3>
            <p>Total reviews</p>
            <a href="data_feedback.php" class="btn">view reviews</a>
      </div>

   </div>

</section>















<?php include '../components/footer.php'; ?>

<script src="../js/admin_script.js"></script>

</body>
</html>
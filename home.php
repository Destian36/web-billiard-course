<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
   $user_id = $_COOKIE['user_id'];
} else {
   $user_id = '';
}



$select_likes = $conn->prepare("SELECT * FROM `likes` WHERE user_id = ?");
$select_likes->execute([$user_id]);
$total_likes = $select_likes->rowCount();

$select_comments = $conn->prepare("SELECT * FROM `comments` WHERE user_id = ?");
$select_comments->execute([$user_id]);
$total_comments = $select_comments->rowCount();

$select_bookmark = $conn->prepare("SELECT * FROM `bookmark` WHERE user_id = ?");
$select_bookmark->execute([$user_id]);
$total_bookmarked = $select_bookmark->rowCount();

$select_playlists = $conn->prepare("SELECT title FROM `playlist` WHERE status = 'active'");
$select_playlists->execute();
$playlists = $select_playlists->fetchAll(PDO::FETCH_COLUMN);

$select_tutors = $conn->prepare("SELECT id, name, image, profession, email FROM tutors");
$select_tutors->execute();
$coaches = $select_tutors->fetchAll(PDO::FETCH_ASSOC);
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

   <style>

      .box.image-box {
         display: flex;
         align-items: center;
         justify-content: center;
         padding: 20px;
      }

      .box.image-box img {
         max-width: 75%;
         height: auto;
      }

      .coach {
         display: flex;
         align-items: center;
         justify-content: space-between;
         margin-bottom: 0%;
            
         padding: 10px;
      }

      .coach img {
         width: 50px;
         height: 50px;
         border-radius: 50%;
         object-fit: cover;
         margin-right: 20px;
      }

      .coach .info {
         flex: 1;
      }

      .coach a {
         text-decoration: none;
      }

      .coach h3 {
         color: var(--light-color);
         font-size: 1.7rem;
         margin-bottom: 5px;
      }

      .coach .profession {
         font-size: 1.6rem;
         color: var(--light-color)
      }

      .coach h3:hover {
         color: var(--white);
      }

      .coach .profession:hover {
         color: var(--white);
      }

      .coach .details {
         display: flex;
         align-items: center;
      }

      .coach .details img {
         width: 50px;
         height: 50px;
         border-radius: 50%;
         object-fit: cover;
         margin-right: 20px;
      }

      .coach .details .info {
         flex: 1;
      }

   </style>

</head>
<body>

<?php include 'components/user_header.php'; ?>

<!-- quick select section starts  -->

<section class="quick-select">
   <h1 class="heading">quick options</h1>

   <div class="box-container">
      <?php if ($user_id != '') : ?>
         <div class="box">
            <h3 class="title">likes and comments</h3>
            <p>total likes : <span><?= $total_likes; ?></span></p>
            <a href="likes.php" class="inline-btn">view likes</a>
            <p>total comments : <span><?= $total_comments; ?></span></p>
            <a href="comments.php" class="inline-btn">view comments</a>
            <p>saved playlist : <span><?= $total_bookmarked; ?></span></p>
            <a href="bookmark.php" class="inline-btn">view bookmark</a>
         </div>
         <?php else : ?>
         <div class="box image-box">
            <img src="images/logo.png" alt="Image">
         </div>
      <?php endif; ?>
      
      <div class="box">
         <h3 class="title">Top Categories</h3>
         <div class="flex">
            <?php
            if (!empty($playlists)) {
               foreach ($playlists as $playlist) {
                  echo '<a href="courses.php?playlist_id=' . $playlist . '"><i class=""></i><span>' . $playlist . '</span></a>';
               }
            } else {
               echo '<p>No playlists available.</p>';
            }
            ?>
         </div>
      </div>

      <div class="box">
         <h3 class="title">Coach Popular</h3>
         <div class="flex">
            <?php
            foreach ($coaches as $coach) {
               echo '<div class="coach">';
               echo '<a href="search_coach.php?tutor_id=' . $coach['id'] . '"><div class="details">';
               echo '<img src="uploaded_files/' . $coach['image'] . '" alt="Profile Photo">';
               echo '<div class="info">';
               echo '<h3>' . $coach['name'] . '</h3>';
               echo '<div class="profession">' . $coach['profession'] . '</div>';
               echo '</div>';
               echo '</div></a>';
               echo '</div>';
            }
            ?>
         </div>
      </div>
   </div>
</section>



<!-- quick select section ends -->

<!-- courses section starts  -->

<section class="courses">

   <h1 class="heading">latest courses</h1>

   <div class="box-container">

      <?php
         $select_courses = $conn->prepare("SELECT * FROM `playlist` WHERE status = ? ORDER BY date DESC LIMIT 6");
         $select_courses->execute(['active']);
         if($select_courses->rowCount() > 0){
            while($fetch_course = $select_courses->fetch(PDO::FETCH_ASSOC)){
               $course_id = $fetch_course['id'];

               $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ?");
               $select_tutor->execute([$fetch_course['tutor_id']]);
               $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
      ?>
      <div class="box">
         <div class="tutor">
            <img src="uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
            <div>
               <h3><?= $fetch_tutor['name']; ?></h3>
               <span><?= $fetch_course['date']; ?></span>
            </div>
         </div>
         <img src="uploaded_files/<?= $fetch_course['thumb']; ?>" class="thumb" alt="">
         <h3 class="title"><?= $fetch_course['title']; ?></h3>
         <a href="playlist.php?get_id=<?= $course_id; ?>" class="inline-btn">view playlist</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no courses added yet!</p>';
      }
      ?>

   </div>

   <div class="more-btn">
      <a href="courses.php" class="inline-option-btn">view more</a>
   </div>

</section>

<!-- courses section ends -->












<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->

<!-- custom js file link  -->
<script src="js/script.js"></script>
<script>
   var userLoggedIn = "<?php echo $user_id; ?>";

   if (userLoggedIn !== '') {
      var boxContainer = document.querySelector('.box-container');
      boxContainer.classList.add('logged-in');
   }

</script>
   
</body>
</html>
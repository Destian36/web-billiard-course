<?php

include '../components/connect.php';

if(isset($_COOKIE['tutor_id'])){
   $tutor_id = $_COOKIE['tutor_id'];
}else{
   $tutor_id = '';
   header('location:login_admin.php');
}

if(isset($_POST['delete_content'])){
   $delete_id = $_POST['content_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $verify_content = $conn->prepare("SELECT * FROM `content` WHERE id = ?");
   $verify_content->execute([$delete_id]);

   if($verify_content->rowCount() > 0){
      $delete_content = $conn->prepare("DELETE FROM `content` WHERE id = ?");
      $delete_content->execute([$delete_id]);
      $message[] = 'content deleted successfully!';
   }else{
      $message[] = 'content already deleted!';
   }
}

// Query untuk mendapatkan semua kontak pengguna
$select_content = $conn->prepare("SELECT * FROM `content`");
$select_content->execute();
$contents = $select_content->fetchAll(PDO::FETCH_ASSOC);
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


<style>
   table {
   width: 100%;
   border-collapse: collapse;
}

table th, table td {
   padding: 10px;
   font-size: 15px;
   text-align: left;
   border-bottom: 1px solid #ddd;
}

table td, img {
   width: 50px;
   height: 50px;
   border-radius: 50%;
   object-fit: cover;
}

table th {
   background-color: var(--white);
   font-weight: bold;
}

.show-comments {
   margin-top: 20px;
   font-size: 15px;
   color: var(--black);
}

.empty {
   text-align: center;
   padding: 20px;
   font-style: italic;
   color: #888;
}

.delete-btn {
   background-color: var(--red);
   padding: 10px;
   border: none;
   cursor: pointer;
   color: white;
}

.delete-btn:hover {
   background-color: var(--black);
   color: var(--white);
}
</style>


</head>
<body>

<?php include '../components/admin1_header .php'; ?>
   

<section class="contact">
   <h1 class="heading">Video</h1>
   <div class="show-contact">
      <?php if(count($contents) > 0): ?>
         <table>
            <tr>
               <th>tutor_id</th>
               <th>playlist_id</th>
               <th>judul</th>
               <th>status</th>
               <th>video</th>
               <th>date</th>
               <th>Profile</th>
               <th>Aksi</th>
            </tr>
            <?php foreach ($contents as $tutors): ?>
               <?php
                  $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ?");
                  $select_tutor->execute([$tutors['tutor_id'] ?? '']);
                  $tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
               ?>
               <tr>
                  <td><?= $tutors['tutor_id']; ?></td>
                  <td><?= $tutors['playlist_id']; ?></td>
                  <td><?= $tutors['title']; ?></td>
                  <td><?= $tutors['status']; ?></td>
                  <td>
                     <video width="150" height="80" controls>
                        <source src="../uploaded_files/<?= $tutors['video']; ?>" type="video/mp4">
                        Your browser does not support the video tag.
                     </video>
                  </td>

                  <td><?= $tutors['date']; ?></td>
                  <td>
                     <?php if ($tutor && isset($tutor['image'])): ?>
                        <img src="../uploaded_files/<?= $tutor['image']; ?>" alt="Foto Profil">
                        <?php else: ?>
                           -
                        <?php endif; ?>
                  </td>
                  <td>
                  <form method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus konten ini?')">
                        <input type="hidden" name="content_id" value="<?= $tutors['id']; ?>">
                        <button type="submit" name="delete_content" class="delete-btn"><i class="fas fa-trash"></i></button>
                     </form>
                  </td>
               </tr>
            <?php endforeach; ?>
         </table>
      <?php else: ?>
         <p class="empty">Belum ada Video!</p>
      <?php endif; ?>
   </div>
</section>












<?php include '../components/footer.php'; ?>

<script src="../js/admin_script.js"></script>

</body>
</html>
<?php

include '../components/connect.php';

if(isset($_COOKIE['tutor_id'])){
   $tutor_id = $_COOKIE['tutor_id'];
}else{
   $tutor_id = '';
   header('location:login_admin.php');
}

if(isset($_POST['delete_playlist'])){
   $delete_id = $_POST['playlist_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $verify_playlist = $conn->prepare("SELECT * FROM `playlist` WHERE id = ?");
   $verify_playlist->execute([$delete_id]);

   if($verify_playlist->rowCount() > 0){
      $delete_playlist = $conn->prepare("DELETE FROM `playlist` WHERE id = ?");
      $delete_playlist->execute([$delete_id]);
      $message[] = 'playlist deleted successfully!';
   }else{
      $message[] = 'playlist already deleted!';
   }
}

// Query untuk mendapatkan semua kontak pengguna
$select_playlist = $conn->prepare("SELECT * FROM `playlist`");
$select_playlist->execute();
$playlist = $select_playlist->fetchAll(PDO::FETCH_ASSOC);
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
   font-family: 'Nunito', sans-serif;
}

table th, table td {
   padding: 10px;
   font-size: 15px;
   text-align: left;
   border-bottom: 1px solid #ddd;
}

table th {
   background-color: var(--white);
   font-weight: bold;
}

table td, img {
   width: 50px;
   height: 50px;
   border-radius: 50%;
   object-fit: cover;
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
   

<section class="playlist">
   <h1 class="heading">Playlist</h1>
   <div class="show-playlist">
      <?php if(count($playlist) > 0): ?>
         <table>
            <tr>
               <th>Tutor_Id</th>
               <th>Nama</th>
               <th>Judul</th>
               <th>Deskripsi</th>
               <th>Playlist</th>
               <th>Date</th>
               <th>Status</th>
               <th>Profile</th>
               <th>Aksi</th>
            </tr>
            <?php foreach ($playlist as $tutors): ?>
               <?php
                  $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ?");
                  $select_tutor->execute([$tutors['tutor_id'] ?? '']);
                  $tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
                  
                  $name = '';
                  if ($tutor && isset($tutor['name'])) {
                     $name = $tutor['name'];
                  }
               ?>
               <tr>
                  <td><?= $tutors['tutor_id']; ?></td>
                  <td><?= $name; ?></td>
                  <td><?= $tutors['title']; ?></td>
                  <td><?= $tutors['description']; ?></td>
                  <td><img src="../uploaded_files/<?= $tutors['thumb']; ?>" alt="Playlist Thumbnail"></td>
                  <td><?= $tutors['date']; ?></td>
                  <td><?= $tutors['status']; ?></td>
                  <td>
                     <?php if ($tutor && isset($tutor['image'])): ?>
                        <img src="../uploaded_files/<?= $tutor['image']; ?>" alt="Foto Profil">
                        <?php else: ?>
                           -
                        <?php endif; ?>
                  </td>
                  <td>
                  <form method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus konten ini?')">
                        <input type="hidden" name="playlist_id" value="<?= $tutors['id']; ?>">
                        <button type="submit" name="delete_playlist" class="delete-btn"><i class="fas fa-trash"></i></button>
                     </form>
                  </td>
               </tr>
            <?php endforeach; ?>
         </table>
      <?php else: ?>
         <p class="empty">Belum ada Playlist!</p>
      <?php endif; ?>
   </div>
</section>












<?php include '../components/footer.php'; ?>

<script src="../js/admin_script.js"></script>

</body>
</html>
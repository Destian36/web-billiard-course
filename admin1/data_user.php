<?php

include '../components/connect.php';

if(isset($_COOKIE['tutor_id'])){
   $tutor_id = $_COOKIE['tutor_id'];
}else{
   $tutor_id = '';
   header('location:login_admin.php');
}

if (isset($_POST['delete'])) {
   $user_id = $_POST['user_id'];

   // Query untuk menghapus pengguna berdasarkan ID
   $delete_user = $conn->prepare("DELETE FROM `users` WHERE id = ?");
   $delete_user->execute([$user_id]);
   // tambahkan pesan sukses atau perintah lain setelah penghapusan
   $message[] = 'Deleted successfully!';
}

// Query untuk mendapatkan semua data pengguna
$select_users = $conn->prepare("SELECT id, name, email, password, image FROM `users`");
$select_users->execute();
$users = $select_users->fetchAll(PDO::FETCH_ASSOC);
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
   body {
      font-size: 16px;
   }

   table td, img {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      object-fit: cover;
   }

   /* Memperbesar tulisan dalam tabel */
   table td {
      font-size: 15px;
   }

   

   
</style>


</head>
<body>

<?php include '../components/admin1_header .php'; ?>

<section class="playlists">

   <h3 class="heading">Data Users</h3>

   <div class="box-container">
      <div class="box">

      <div class="add-btn-container">
            <a href="../admin1/add_murid.php" class="add-btn">Tambah Murid</a>
         </div>
         
         <table>
            <tr>
               <th>ID</th>
               <th>Nama</th>
               <th>Email</th>
               <th>Password</th>
               <th>Image</th>
               <th>Action</th>
            </tr>
            <?php foreach ($users as $user): ?>
            <tr>
               <td><?= $user['id']; ?></td>
               <td><?= $user['name']; ?></td>
               <td><?= $user['email']; ?></td>
               <td><?= $user['password']; ?></td>
               <td><img src="../uploaded_files/<?= $user['image']; ?>" alt=""></td>
               
               <td>
                  <form method="post" onsubmit="return confirm('Are you sure you want to delete this user?')">
                     <input type="hidden" name="user_id" value="<?= $user['id']; ?>">
                     <button type="submit" name="delete" class="delete-btn"><i class="fas fa-trash"></i></button>
                  </form>
               </td>
            </tr>
            <?php endforeach; ?>
         </table>
      </div>
   </div>

</section>

<?php include '../components/footer.php'; ?>

<script src="../js/admin_script.js"></script>

<script>
   document.querySelectorAll('.playlists .box-container .box .description').forEach(content => {
      if(content.innerHTML.length > 100) content.innerHTML = content.innerHTML.slice(0, 100);
   });
</script>

</body>
</html>
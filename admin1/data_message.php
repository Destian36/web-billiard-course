<?php

include '../components/connect.php';

if(isset($_COOKIE['tutor_id'])){
   $tutor_id = $_COOKIE['tutor_id'];
}else{
   $tutor_id = '';
   header('location:login_admin.php');
}

if (isset($_POST['delete_contact'])) {
   $sender_id = $_POST['sender_id'];
   $sender_id = filter_var($sender_id, FILTER_SANITIZE_STRING);

   $delete_message = $conn->prepare("DELETE FROM `message` WHERE sender_id = ?");
   $delete_message->execute([$sender_id]);

   if ($delete_message->rowCount() > 0) {
      $message[] = 'Message deleted successfully!';
   } else {
      $message[] = 'Failed to delete message!';
   }
}


// Query untuk mendapatkan semua pesan dan informasi pengguna
$select_messages = $conn->prepare("SELECT m.*, u.name AS sender_name, u.image AS sender_image FROM `message` m LEFT JOIN `users` u ON u.id = m.sender_id");
$select_messages->execute();
$messages = $select_messages->fetchAll(PDO::FETCH_ASSOC);
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
   .message span{
      font-size: 2rem;
      color:#f201ff;
   }
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

table td, img {
   width: 50px;
   height: 50px;
   border-radius: 50%;
   object-fit: cover;
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
   <h1 class="heading">Message</h1>
   <div class="show-messages">
      <?php if(count($messages) > 0): ?>
         <table>
            <tr>
               <th>Nama Pengirim</th>
               <th>Pesan</th>
               <th>Timestamp</th>
               <th>Profil Pengirim</th>
               <th>Aksi</th>
            </tr>
            <?php foreach ($messages as $message): ?>
               <tr>
                  <td><?= $message['sender_name']; ?></td>
                  <td><?= $message['message']; ?></td>
                  <td><?= $message['timestamp']; ?></td>
                  <td>
                     <?php if ($message['sender_image']): ?>
                        <img src="../uploaded_files/<?= $message['sender_image']; ?>" alt="Foto Profil">
                     <?php else: ?>
                        -
                     <?php endif; ?>
                  </td>
                  <td>
                     <form method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')">
                        <input type="hidden" name="sender_id" value="<?= $message['sender_id']; ?>">
                        <button type="submit" name="delete_contact" class="delete-btn"><i class="fas fa-trash"></i></button>
                     </form>
                  </td>
               </tr>
            <?php endforeach; ?>

         </table>
      <?php else: ?>
         <p class="empty">Belum ada pesan!</p>
      <?php endif; ?>
   </div>
</section>












<?php include '../components/footer.php'; ?>

<script src="../js/admin_script.js"></script>

</body>
</html>
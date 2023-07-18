<?php

include '../components/connect.php';

if(isset($_COOKIE['tutor_id'])){
   $tutor_id = $_COOKIE['tutor_id'];
}else{
   $tutor_id = '';
   header('location:login_admin.php');
}

if(isset($_POST['delete_contact'])){
   $delete_ids = $_POST['checkbox'];
   foreach ($delete_ids as $delete_id) {
      $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

      $verify_contact = $conn->prepare("SELECT * FROM `contact` WHERE name = ?");
      $verify_contact->execute([$delete_id]);

      if($verify_contact->rowCount() > 0){
         $delete_contact = $conn->prepare("DELETE FROM `contact` WHERE name = ?");
         $delete_contact->execute([$delete_id]);
      }
   }

   $message[] = 'Deleted successfully!';
}

// Query untuk mendapatkan semua pesan dan informasi pengguna
if ($conn) {
   // Query untuk mendapatkan semua pesan kontak
   $select_contact = $conn->prepare("SELECT * FROM `contact`");
   if ($select_contact) {
       $select_contact->execute();
       $contact = $select_contact->fetchAll(PDO::FETCH_ASSOC);
   } else {
       $contact = [];
       $contact[] = 'Failed to fetch contact!';
   }
} else {
   $contact = [];
   $contact[] = 'Database connection failed!';
}

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
         padding: 10px 20px; /* Nilai padding pada kolom "Nama" */
         font-size: 15px;
         text-align: left;
         border-bottom: 1px solid #ddd;
      }

      table th {
         background-color: var(--white);
         font-weight: bold;
      }

      .show-messages {
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

      .email-btn {
         background-color: var(--red);
         padding: 15px;
         border-radius: 5px;
         cursor: pointer;
         color: white;
         margin-right: 10px;
      }

      .email-btn:hover {
         background-color: var(--black);
         color: var(--white);
      }

      .message-column {
         width: 200px; /* Sesuaikan lebar yang diinginkan */
      }

      .button-container {
         display: flex;
         align-items: center;
      }

      .checkbox {
         display: inline-block;
         width: 20px;
         height: 20px;
         margin-right: 10px;
         border: 1px solid #ccc;
         border-radius: 3px;
         cursor: pointer;
      }

      .checkbox.checked {
         background-color: #06c;
      }

      .checkbox.checked::before {
         content: '\f00c';
         font-family: 'FontAwesome';
         color: white;
         font-size: 12px;
         display: block;
         text-align: center;
         line-height: 20px;
      }

      .delete-container {
         display: flex;
         align-items: center;
         margin-top: 10px;
      }

      .delete-btn {
         background-color: var(--red);
         padding: 15px;
         border-radius: 5px;
         cursor: pointer;
         color: white;
         margin-right: 10px;
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
      <h1 class="heading">Contact</h1>
      <div class="show-contact">
         <?php if(count($contact) > 0): ?>
            <form method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kontak ini?')">
               <table>
                  <tr>
                     <th>Nama</th>
                     <th>Email</th>
                     <th>Nomor</th>
                     <th class="message-column">Message</th>
                     <th>Status</th>
                     <th>Aksi</th>
                  </tr>
                  <?php foreach ($contact as $contacts): ?>
                     <tr>
                        <td>
                           <div class="button-container">
                              <input type="checkbox" id="checkbox-<?= $contacts['name']; ?>" class="checkbox" name="checkbox[]" value="<?= $contacts['name']; ?>">
                              <label for="checkbox-<?= $contacts['name']; ?>"><?= $contacts['name']; ?></label>
                           </div>
                        </td>
                        <td><?= $contacts['email']; ?></td>
                        <td><?= $contacts['number']; ?></td>
                        <td><?= $contacts['message']; ?></td>
                        <td>
                           <?php
                           $user_name = $contacts['name'];
                           $select_user = $conn->prepare("SELECT * FROM `users` WHERE name = ?");
                           $select_user->execute([$user_name]);
                           $user = $select_user->fetch(PDO::FETCH_ASSOC);
                           if ($user && $user['image']): ?>
                              <img src="../uploaded_files/<?= $user['image']; ?>" alt="Foto Profil">
                           <?php else: ?>
                              Daftar Pelatih
                           <?php endif; ?>
                        </td>
                        <td>
                           <div class="button-container">
                              <a href="mailto:<?= $contacts['email']; ?>" class="email-btn"><i class="far fa-envelope"></i></a>
                           </div>
                        </td>
                     </tr>
                  <?php endforeach; ?>
               </table>
               <div class="delete-container">
                  <button type="submit" name="delete_contact" class="delete-btn"><i class="fas fa-trash"></i> Delete</button>
               </div>
            </form>
         <?php else: ?>
            <p class="empty">Belum ada pesan!</p>
         <?php endif; ?>
      </div>
   </section>

   <?php include '../components/footer.php'; ?>

   <script src="../js/admin_script.js"></script>

</body>
</html>

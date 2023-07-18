<?php
session_start();

include '../components/connect.php';

if (isset($_COOKIE['user_id'])) {
   $user_id = $_COOKIE['user_id'];
} else {
   $user_id = '';
}

if (isset($_POST['submit'])) {
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $msg = $_POST['msg'];
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);

   $select_contact = $conn->prepare("SELECT * FROM `contact` WHERE name = ? AND email = ? AND number = ? AND message = ?");
   $select_contact->execute([$name, $email, $number, $msg]);

   if ($select_contact->rowCount() > 0) {
      $message[] = 'incorrect email or password!';
   } else {
      $insert_message = $conn->prepare("INSERT INTO `contact`(name, email, number, message) VALUES(?,?,?,?)");
      $insert_message->execute([$name, $email, $number, $msg]);
      
      $message[] = 'incorrect email or password!';

      header('location:../teachers.php');
      exit();
   }

   header('Location: ' . $_SERVER['PHP_SELF']);
   exit();
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
   <link rel="stylesheet" href="../css/style.css">


   <style>
      .contact.small-register {
         max-width: 500px;
         margin: 0 auto;
      }
   </style>

</head>

<body style="padding-left: 0;">

   <!-- section kontak dimulai -->

   <section class="contact small-register">

      <div class="row">

         <form action="" method="post">

            <h3>Daftar sebagai Coach melalui Pesan!</h3>
            <input type="text" placeholder="Masukkan nama Anda" required maxlength="100" name="name" class="box">
            <input type="email" placeholder="Masukkan email Anda" required maxlength="100" name="email" class="box">
            <input type="number" min="0" max="9999999999" placeholder="Masukkan nomor Anda" required maxlength="10"
               name="number" class="box">
            <textarea name="msg" class="box" placeholder="Masukkan pesan Anda" required cols="30" rows="10"
               maxlength="1000"></textarea>
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            <input type="submit" value="Daftar" class="inline-btn" name="submit">
         </form>



      </div>

   </section>

   <!-- section kontak selesai -->


   <script>
      let darkMode = localStorage.getItem('dark-mode');
      let body = document.body;

      const enabelDarkMode = () => {
         body.classList.add('dark');
         localStorage.setItem('dark-mode', 'enabled');
      }

      const disableDarkMode = () => {
         body.classList.remove('dark');
         localStorage.setItem('dark-mode', 'disabled');
      }

      if (darkMode === 'enabled') {
         enabelDarkMode();
      } else {
         disableDarkMode();
      }
      
   </script>

</body>

</html>

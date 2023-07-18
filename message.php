<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
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
    $tutor_email = $_POST['tutor_email'];
    $tutor_email = filter_var($tutor_email, FILTER_SANITIZE_STRING);

    // Dapatkan ID tutor berdasarkan email tutor
    $select_tutor = $conn->prepare("SELECT id, email FROM tutors WHERE email = ?");
    $select_tutor->execute([$tutor_email]);

    if ($select_tutor->rowCount() > 0) {
        $tutor = $select_tutor->fetch();
        $receiver_id = $tutor['id'];

        // Masukkan pesan ke dalam tabel pesan
        $insert_message = $conn->prepare("INSERT INTO message (sender_id, receiver_id, message) VALUES (?, ?, ?)");
        $insert_message->execute([$user_id, $receiver_id, $msg]);


        $message[] = 'Message sent successfully!';

        // Alihkan ke email tutor
        $tutor_email = $tutor['email'];
        header("Location: mailto:$tutor_email");
        exit();
    } else {
        $message[] = 'Tutor not found!';
    }
}

// Mengambil pesan dari database
$select_messages = $conn->prepare("SELECT message.*, tutors.email AS tutor_email FROM message INNER JOIN tutors ON message.receiver_id = tutors.id WHERE sender_id = ?");
$select_messages->execute([$user_id]);
$messages = $select_messages->fetchAll(PDO::FETCH_ASSOC);
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
    .box {
  width: 100%;
  padding: 10px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  margin-bottom: 10px;
}
   </style>

</head>
<body>

<?php include 'components/user_header.php'; ?>

<!-- contact section starts  -->

<section class="contact">
    <div class="row">
        <form action="" method="post">
            <h3>Get in touch</h3>
            <input type="text" placeholder="Enter your name" required maxlength="100" name="name" class="box">
            <input type="email" placeholder="Enter your email" required maxlength="100" name="email" class="box">
            <input type="number" min="0" max="9999999999" placeholder="Enter your number" required maxlength="10" name="number" class="box">
            <select name="tutor_email" class="box">
                <option value="" selected disabled>Enter your tutor ID</option>
                <option value="endy@gmail.com">Coach Endy</option>
                <option value="verren@gmail.com">Verren</option>
                <option value="irwanto@gmail.com">Irwanto</option>
            </select>
            <textarea name="msg" class="box" placeholder="Enter your message" required cols="30" rows="10" maxlength="1000"></textarea>
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            <input type="submit" value="Send message" class="inline-btn" name="submit">
        </form>
    </div>
</section>

<!-- contact section ends -->











<?php include 'components/footer.php'; ?>  

<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>
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

   // Query untuk menghapus feedback berdasarkan user_id
   $delete_feedback = $conn->prepare("DELETE FROM `feedback` WHERE user_id = ?");
   $delete_feedback->execute([$user_id]);
   // tambahkan pesan sukses atau perintah lain setelah penghapusan
   $message[] = 'contact deleted successfully!';
}

// Query untuk mendapatkan semua data feedback dengan join ke tabel users
$select_feedback = $conn->prepare("SELECT f.user_id, u.name, u.image, f.message, f.reting, f.datetime FROM `feedback` AS f JOIN `users` AS u ON f.user_id = u.id");
$select_feedback->execute();
$feedbacks = $select_feedback->fetchAll(PDO::FETCH_ASSOC);

// Fungsi untuk mengonversi rating menjadi simbol bintang
function generateStarRating($rating) {
    $stars = '';

    for ($i = 1; $i <= $rating; $i++) {
       $stars .= '★';
    }

    return $stars;
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
        table th {
           font-size: 15px;
        }

        table td {
            font-size: 15px;
        }

        /* CSS untuk rating bintang */
        .star-rating {
            color: gold;
            font-size: 20px;
        }

        /* CSS untuk lebar kolom "Message" */
        .message-column {
            width: 350px; /* Sesuaikan lebar yang diinginkan */
        }

        /* CSS untuk mengatur padding pada kolom "Message" */
        .message-column {
            padding-left: 10px;  /* Padding kiri */
            padding-right: 10px; /* Padding kanan */
        }

        /* CSS untuk foto profil */
        .user-profile-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>

</head>
<body>

<?php include '../components/admin1_header .php'; ?>

<section class="playlists">

   <h3 class="heading">Data Feedback</h3>

   <div class="box-container">
      <div class="box">
         
         <table>
            <tr>
               <th>Nama</th>
               <th class="message-column">Message</th>
               <th>Rating</th>
               <th>Datetime</th>
               <th>Profil</th>
               <th>Action</th>
            </tr>
            <?php foreach ($feedbacks as $feedback): ?>
            <tr>
                <td><?= $feedback['name']; ?></td>
                <td><?= $feedback['message']; ?></td>
                <td>
                    <span class="star-rating">
                    <?= generateStarRating($feedback['reting']); ?>
                    </span>
                </td>
                <td><?= $feedback['datetime']; ?></td>
                <td>
                    <div>
                        <img src="../uploaded_files/<?= $feedback['image']; ?>" alt="User Profile" class="user-profile-img">
                    </div>
                </td>
                <td>
                    <form method="post" onsubmit="return confirm('Are you sure you want to delete this feedback?')">
                    <input type="hidden" name="user_id" value="<?= $feedback['user_id']; ?>">
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

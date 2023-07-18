<?php

include '../components/connect.php';

if(isset($_COOKIE['tutor_id'])){
   $tutor_id = $_COOKIE['tutor_id'];
}else{
   $tutor_id = '';
   header('location:login_admin.php');
}

if (isset($_POST['delete_comment'])) {
   $delete_id = $_POST['comment_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $verify_comment = $conn->prepare("SELECT * FROM `comments` WHERE id = ?");
   if ($verify_comment) {
       $verify_comment->execute([$delete_id]);

       if ($verify_comment->rowCount() > 0) {
           $delete_comment = $conn->prepare("DELETE FROM `comments` WHERE id = ?");
           if ($delete_comment) {
               $delete_comment->execute([$delete_id]);
               $message[] = 'Comment deleted successfully!';
           } else {
               $message[] = 'Failed to delete comment!';
           }
       } else {
           $message[] = 'Comment already deleted!';
       }
   } else {
       $message[] = 'Failed to verify comment!';
   }
}

if ($conn) {
   // Query untuk mendapatkan semua komentar pengguna
   $select_comments = $conn->prepare("SELECT * FROM `comments`");
   if ($select_comments) {
       $select_comments->execute();
       $comments = $select_comments->fetchAll(PDO::FETCH_ASSOC);
   } else {
       $comments = [];
       $message[] = 'Failed to fetch comments!';
   }
} else {
   $comments = [];
   $message[] = 'Database connection failed!';
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
   padding: 10px;
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
   

<section class="comments">

   <h1 class="heading">User Comments</h1>

   <div class="show-comments">
      <?php if(count($comments) > 0): ?>
         <table>
            <tr>
               
               <th>User ID</th>
               <th>Nama User</th>
               <th>Content ID</th>
               <th>Comment</th>
               <th>Date</th>
               <th>Profile Picture</th>
               <th>Action</th>
            </tr>
            <?php foreach ($comments as $comment): ?>
               <?php
                  $select_user = $conn->prepare("SELECT name, image FROM `users` WHERE id = ?");
                  $select_user->execute([$comment['user_id']]);
                  $user = $select_user->fetch(PDO::FETCH_ASSOC);
               ?>
               <tr>
                  
                  <td><?= $comment['user_id']; ?></td>
                  <td><?= isset($user['name']) ? $user['name'] : 'Unknown User'; ?></td>
                  <td><?= $comment['content_id']; ?></td>
                  <td><?= $comment['comment']; ?></td>
                  <td><?= $comment['date']; ?></td>
                  <td>
                     <img src="../uploaded_files/<?= $user['image']; ?>" alt="Profile Picture">
                  </td>
                  <td>
                     <form method="post" onsubmit="return confirm('Are you sure you want to delete this comment?')">
                        <input type="hidden" name="comment_id" value="<?= $comment['id']; ?>">
                        <button type="submit" name="delete_comment" class="delete-btn"><i class="fas fa-trash"></i></button>
                     </form>
                  </td>
               </tr>
            <?php endforeach; ?>
         </table>
      <?php else: ?>
         <p class="empty">Belum ada Comment!</p>
      <?php endif; ?>
   </div>
</section>












<?php include '../components/footer.php'; ?>

<script src="../js/admin_script.js"></script>

</body>
</html>
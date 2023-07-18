<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

if (isset($_POST['submit'])) {
   if (isset($_POST['msg'])) {
      $msg = $_POST['msg'];
      $msg = filter_var($msg, FILTER_SANITIZE_STRING);
   } else {
      $msg = '';
   }
   if (isset($_POST['reting'])) {
      $reting = $_POST['reting'];
      $reting = filter_var($reting, FILTER_SANITIZE_NUMBER_INT);
   } else {
      $reting = '';
   }
   $datetime = date("Y-m-d H:i:s");

   // Periksa apakah pesan yang sama sudah ada sebelumnya
   $check_duplicate = $conn->prepare("SELECT * FROM feedback WHERE message = ?");
   $check_duplicate->execute([$msg]);

   if ($check_duplicate->rowCount() === 0) {
      // Jika tidak ada pesan yang sama, simpan ke database
      $insert_feedback = $conn->prepare("INSERT INTO feedback (user_id, message, reting, datetime) VALUES (?, ?, ?, ?)");
      $insert_feedback->execute([$user_id, $msg, $reting, $datetime]);
   }

   $message[] = 'Feedback sent successfully!';
}




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
      .message span{
         font-size: 2rem;
         color:#f201ff;
      }
      .container{
         display: flex;
         align-items: center;
         justify-content: center;
         flex-direction: column;
      }

      .container .post {
         display: none;
      }

      .container .text {
         font-size: 25px;
         color: #666;
         font-weight: 500;
      }

      .container .edit {
         position: absolute;
         right: 10px;
         top: 5px;
         font-size: 16px;
         color: #666;
         font-weight: 500;
         cursor: pointer;
      }

      .container .edit:hover {
         text-decoration: underline;
      }

      .container .star-widget input {
         display: none;
      }

      .star-widget label {
         font-size: 30px;
         color: #444;
         padding: 10px;
         float: right;
         transition: all 0.2s ease;
      }

      input:not(:checked) ~ label:hover,
      input:not(:checked) ~ label:hover ~ label {
         color: #fd4;
      }

      input:checked ~ label {
         color: #fd4;
      }

      input#rate-5:checked ~ label {
         color: #fe7;
         text-shadow: 0 0 20px #952;
      }



      .container form {
         display: none;
      }

      input:checked ~ form {
         display: block;
      }

      form header {
         width: 100%;
         font-size: 25px;
         color: #fe7;
         font-weight: 500;
         margin: 5px 0 20px 0;
         text-align: center;
         transition: all 0.2s ease;
      }

      form .textarea {
         height: 100px;
         width: 100%;
         overflow: hidden;
      }

      form .textarea textarea {
         height: 100%;
         width: 100%;
         outline: none;
         color: #eee;
         border: 1px solid #333;
         background: #222;
         padding: 10px;
         font-size: 17px;
         resize: none;
      }

      .textarea textarea:focus {
         border-color: #444;
      }

      form .btn {
         height: 45px;
         width: 100%;
         margin: 15px 0;
      }
   </style>


</head>
<body>

<?php include 'components/user_header.php'; ?>

<!-- contact section starts  -->

<section class="contact">

   <div class="row">

      <div class="image">
         <img src="images/about 2.jpg" alt="">
      </div>

      <form action="" method="post">
         <h3>share your feedback</h3>
         <div class="container">
            <div class="star-widget">
                     <input type="radio" name="reting" id="reting-5" value="5">
                     <label for="reting-5" class="fas fa-star"></label>
                     <input type="radio" name="reting" id="reting-4" value="4">
                     <label for="reting-4" class="fas fa-star"></label>
                     <input type="radio" name="reting" id="reting-3" value="3">
                     <label for="reting-3" class="fas fa-star"></label>
                     <input type="radio" name="reting" id="reting-2" value="2">
                     <label for="reting-2" class="fas fa-star"></label>
                     <input type="radio" name="reting" id="reting-1" value="1">
                     <label for="reting-1" class="fas fa-star"></label>
            </div>
         </div>
            <textarea name="msg" class="box" placeholder="Enter your message" required cols="30" rows="10" maxlength="1000"></textarea>
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            <button type="submit" name="submit" class="inline-btn">Save Feedback</button>
      </form>


   </div>

   <div class="box-container">

      <div class="box">
         <i class="fas fa-phone"></i>
         <h3>phone number</h3>
         <a href="tel:1234567890">123-456-7890</a>
         
      </div>

      <div class="box">
         <i class="fas fa-envelope"></i>
         <h3>email address</h3>
         
         <a href="mailto:anasbhai@gmail.com">ionpool@gmail.com</a>
      </div>

      <div class="box">
         <i class="fas fa-map-marker-alt"></i>
         <h3>billiard house</h3>
         <a href="#">Jl. Galunggung No.82 </a>
      </div>


   </div>

</section>

<!-- contact section ends -->











<?php include 'components/footer.php'; ?>  

<!-- custom js file link  -->
<script src="js/script.js"></script>
<script>
      const btn = document.querySelector("button");
      const post = document.querySelector(".post");
      const widget = document.querySelector(".star-widget");
      const editBtn = document.querySelector(".edit");
      btn.onclick = () => {
         widget.style.display = "none";
         post.style.display = "block";
         editBtn.onclick = () => {
            widget.style.display = "block";
            post.style.display = "none";
         }
         return false;
      }
   </script>
   
</body>
</html>
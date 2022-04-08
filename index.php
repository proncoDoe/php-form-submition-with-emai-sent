<?php require 'inc/db.php' ?>

<?php 

            
require_once 'vendor/autoload.php';
require_once 'inc/cretials.php';


?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
    <link rel="stylesheet" hre="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!--           
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" integrity="sha512-c42qTSw/wPZ3/5LBzD+Bw5f7bSF2oxou6wEb+I/lqeaKV5FDIfMvvRp772y4jcJLKuGUOpbJMdg/BTl50fJYAw==" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.0/animate.min.css" integrity="sha512-kb1CHTNhoLzinkElTgWn246D6pX22xj8jFNKsDmVwIQo+px7n1yjJUZraVuR/ou6Kmgea4vZXZeUDbqKtXkEMg==" crossorigin="anonymous" /> -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css"
        integrity="sha512-TyUaMbYrKFZfQfp+9nQGOEt+vGu4nKzLk0KaV3nFifL3K8n7lzb8DayTzLOK0pNyzxGJzGRSw78e8xqJhURJ3Q=="
        crossorigin="anonymous" />

    <!-- <link rel="stylesheet" href="css/mdb.min.css">
        <link rel="stylesheet" href="css/animate.min.css"> -->

    <link href="css/error.css" rel="stylesheet">

    <!-- A meta tag that redirects after 5 seconds to one of my PHP tutorials-->


    <title>mobile form</title>
</head>

<body class="map">


    <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15862.687279753347!2d5.627283544758956!3d6.306776520811607!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1040d3ee1d24c635%3A0x884e47e4e5e505!2sPower%20Line%20Rd%2C%20Oka%2C%20Benin%20City!5e0!3m2!1sen!2sng!4v1598393109362!5m2!1sen!2sng"
        width="100%" height="700" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false"
        tabindex="0"></iframe>




    <?php
         

         $error = '';
         $response = '';
         
         if(isset($_POST['Submit'])){

            $name = $_POST['fullName'] ?? null; 
            $company = $_POST["company"] ?? null;
            $email = $_POST['email'] ?? null;
            $phone = $_POST['phone'] ?? null;
            $message = $_POST['message'] ?? null;
            $date = date('F, d Y');
   

// Create the Transport
$transport = (new Swift_SmtpTransport('smtp.gmail.com',587, 'tls'))
->setUsername(EMAIL)
->setPassword(PASS);
;

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

// Create a message
$message = (new Swift_Message($_POST['fullName']))
  ->setFrom([EMAIL => 'Welcome to proncotech'])
  ->setTo([$_POST['email']])
  ->setBody($_POST['message'])
  ;


  if(isset($_FILES['file'])){

    $message ->attach(Swift_Attachment::fromPath($_FILES['file']['tmp_name'])->setFilename('php.jpg'));
    
  }

// Send the message
     if($mailer->send($message)){


       echo  "<script type='text/javascript'> alert(Mail send !!!)</script>";

     }else{

        echo  "<script type='text/javascript'> alert(Fails to send !!!)</script>";
     }

         if(strlen(trim($name)) < 3){

            $error = 'Name is too short';


            
         }else if(strlen(trim($company)) < 6){

             $error = 'Company name must be greater than 6 or equal to 6 chracter';


         }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){

            $error = 'The email you enter is Invalid';
            
         }else if(strlen(trim($phone)) < 8 || strlen($phone) > 15){

                 $error = 'Phone number you enter those not existe';


             }else if(strlen(trim($message)) < 10){

                 $error = 'Message must be up to 10 character and more';


             }else{


                $statement = 'INSERT INTO `contact`(`fullName`,`company`,`email`,`phone`,`message`,`date`)';
                $statement .= 'VALUES (?,?,?,?,?,?)';

                $stmt = $conn->prepare($statement);
                
                $stmt->bind_param('ssssss', $name,$company,$email,$phone,$message,$date);
                $stmt->execute();


                if($stmt){

                   $time_out = 5;

                  
                     $response = 'Email send Succefully';
                    
                     header('refresh: $time_out; index.php',true, 303);

                      echo '<meta http-equiv="refresh" content="5;URL=\'http://localhost/mobile_form/index.php\'">';
                    
  
                }
                
             }$conn->close();



        }
      
      ?>


    <!-- <script>
        window.setTimeout(function() {
            window.location = 'page2.php';
          }, 5000);
        </script>
        <p>Message has been sent.</p> -->




    <div class="container">

        <div class="wrapper animated fadeInLeftBig ">

            <div class="company-info">

                <h3>One-off Web Development</h3>

                <ul>

                    <li><i class="fas fa-road"></i> No 1 Dawson Road</li>
                    <li> <i class="fas fa-phone"></i>(+234)7065015510</li>
                    <li><i class="fas fa-envelope"></i> ukachukwupromise@gmail.com</li>

                </ul>

            </div>

            <div class="contact">

                <h3>Email Us</h3>

                <form action="index.php" method="POST" enctype="multipart/form-data">


                    <p>

                        <label for="fullName">Name</label>

                        <input type="text" name="fullName" id="fullName" placeholder="Enter Name..." required
                            autocomplete="off">

                    </p>



                    <p>

                        <label for="company">Company Name</label>

                        <input type="text" name="company" id="company" placeholder="Enter Company..." required
                            autocomplete="off">

                    </p>


                    <p>

                        <label for="email">Email</label>

                        <input type="text" name="email" id="email" placeholder="Enter Email..." required
                            autocomplete="off">

                    </p>


                    <p>

                        <label for="phone">phone Number</label>

                        <input type="text" name="phone" id="phone" placeholder="Enter phone Number..." required
                            autocomplete="off">

                    </p>


                    <p class="full">

                        <label for="file">Attach File</label>

                        <input type="file" name="file" id="file" required autocomplete="off">

                        <span>attachment is optional</span>


                    </p>


                    <p class="full">

                        <label for="name">Message</label>

                        <textarea name="message" id="message" rows="5" placeholder="Enter Message..." required
                            autocomplete="off"></textarea>

                    </p>

                    <p class="full">
                        <button type="submit" name="Submit" value="Submit">Cotact Us</button>
                    </p>
                </form>

                <div class="error_check">

                    <div class="error"
                        style=" text-align: center; background-color:#c8232c;  <?php if($error != ""){ ?> display:block; <?php } ?>">
                        <?php echo $error; ?></div>
                    <div class="error"
                        style=" text-align:center; background-color:#25D366; <?php if($response !=""){ ?> display:block; <?php } ?>">
                        <?php echo $response; ?></div>
                </div>

            </div>
        </div>
    </div>

    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>


</body>

</html>
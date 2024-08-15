<?php
session_start();

$username = "";
$email    = "";
$errors = array(); 

$db = mysqli_connect('localhost', 'root', '', 'registration');

// REGISTER USER

if (isset($_POST['reg_user'])) {
  $username = $_POST['username'];
  $username_lowercase = strtolower($username);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  if (empty($username)) {
      array_push($errors, "Username is required");
  }
  if (empty($email)) {
      array_push($errors, "Email is required");
  }
  if (empty($password_1)) {
      array_push($errors, "Password is required");
  }
  if ($password_1 != $password_2) {
      array_push($errors, "The two passwords do not match");
  }
  $user_check_query = "SELECT * FROM users WHERE BINARY username='$username_lowercase' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);

  if ($user) {
      if ($user['username'] === $username_lowercase) {
          array_push($errors, "Username already exists");
      }

      if ($user['email'] === $email) {
          array_push($errors, "Email already exists");
      }
  }

  if (count($errors) == 0) {
      $password = md5($password_1);

      $query = "INSERT INTO users (username, email, password) 
                VALUES('$username', '$email', '$password')";
      mysqli_query($db, $query);

      $_SESSION['username'] = $username;
      $_SESSION['success'] = "You are now logged in";
      $to = $email;
        $subject = ' Welcome to IRRS - Registration Successful';
        $message = "<!DOCTYPE html>
        <html lang='en'>
        
        <head>
            <meta charset='UTF-8'>
            <meta http-equiv='X-UA-Compatible' content='IE=edge'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Document</title>
            <style>
                .header {
                    background-color: blue;
                    color: #fff;
                    padding: 10px;
                    text-align: center;
                }
        
                h3 {
                    font-size: 30px;
                }
        
                h2 {
                    color: white;
                    font-size: 30px;
                }
        
                p {
                    font-size: 20px;
                }
            </style>
        </head>
        
        <body>
            <div class='header'>
                <h2>WELCOME TO IRRS</h2>
            </div>
            <h3>Dear [".$username."],</h3>
            <p>Congratulations! You have successfully registered on IRRS (Indian Railway
                Reservation
                System). We are excited to have you as a member of our platform.
                <br><br>Thank you for choosing IRRS. You can now enjoy the convenience of booking train tickets hassle-free.<br>
                If you have any questions or need assistance, feel free to reach out to our customer support team at
                irrs.ticket@gmail.com.<br><br>
                Happy traveling!<br><br>
                Best regards,<br>
                Pratul Johari<br>
                Founder & CEO<br>
                Indian Railway Reservation System (IRRS)
            </p>
        </body>
        
        </html>";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: IRRS <irrs.ticket@gmail.com>' . "\r\n";
        if(mail($to, $subject, $message, $headers)) {
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            header('location: index.php');
            exit;
        } else {
            array_push($errors, "Failed to send OTP. Please try again.");
        }
  }
}



// LOGIN USER
  
  if (isset($_POST['login_user'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (empty($username)) {
      array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    if (count($errors) == 0) {
      $password = md5($password);
      $username_lowercase = strtolower($username);
      $query = "SELECT * FROM users WHERE LOWER(username)='$username_lowercase' AND password='$password'";
      $results = mysqli_query($db, $query);
      if (mysqli_num_rows($results) == 1) {
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        header('location: index.php');
      } else {
        array_push($errors, "Wrong username/password combination");
      }
    }
  }

?>
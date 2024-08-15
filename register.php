<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>IRRS-Register</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
            integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="shortcut icon" href="./assets/logo-new.png" type="image/x-icon">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
 
</head>
<body>
<nav class="head-container">
            <div class="left">
                <div class="logo">
                    <a href="./index.php">
                        <i class="fa-solid fa-train-subway"></i>
                    </a>
                </div>
                <p>IRRS</p>
            </div>
            <?php if(!isset($_SESSION['username'])): ?>
                <ul class="nav-links">
                    <li><a href="./login.php">LOGIN</a></li>
                    <li><a href="./register.php" class="active">REGISTER</a></li>
                    <li><a href="./fake.html">CONTACT US</a></li>
                </ul>
            <?php else: ?>
                <ul class="nav-links">
                    <li><a href="./index.php">HOME</a></li>
                    <li><a href="./userDetails.php" >LOGOUT</a></li>
                    <li><a href="./fake.html">CONTACT US</a></li>
                </ul>
            <?php endif; ?>
            <div class="right">
                <div class="user">
                    <a href="./userDetails.php">
                        <i class="fa-regular fa-user"></i>
                    </a>
                </div>
                <p class="username"><?php if(isset($_SESSION['username'])) { echo $_SESSION['username'];}?><p>
            </div>
        </nav>
    </div>
  <div class="header">
        <h2>Register</h2>
  </div>
        
  <form method="post" action="register.php">
        <?php include('errors.php'); ?>
        <div class="input-group">
          <label>Username</label>
          <input type="text" name="username" value="<?php echo $username; ?>">
        </div>
        <div class="input-group">
          <label>Email</label>
          <input type="email" name="email" value="<?php echo $email; ?>">
        </div>
        <div class="input-group">
          <label>Password</label>
          <input type="password" name="password_1">
        </div>
        <div class="input-group">
          <label>Confirm password</label>
          <input type="password" name="password_2">
        </div>
        <div class="input-group">
          <button type="submit" class="btn" name="reg_user">Register</button>
        </div>
        <p>Already a member? <a href="login.php">Log in</a></p>
  </form>
</body>
</html>
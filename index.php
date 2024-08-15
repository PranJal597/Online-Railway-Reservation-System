<?php 
  session_start(); 

  if (!isset($_SESSION['username'])) {
        $_SESSION['msg'] = "You must log in first";
        header("location: ./login.php");
  }
  if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username']);
        header("location: ./login.php");
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./style/style.css">
  <link rel="shortcut icon" href="./assets/logo-new.png" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <title>IRRS Indian Railway Reservation System</title>
</head>

<body>
    <header>
        <video autoplay muted loop id="background-video">
            <source src="./assets/banner1.mp4" type="video/mp4">
        </video>
        <nav class="head-container">
            <div class="left">
                <div class="logo">
                    <a href="./index.php">
                        <i class="fa-solid fa-train-subway"></i>
                    </a>
                </div>
                <p>IRRS</p>
            </div>
            <?php if(isset($_SESSION['username']) && $_SESSION['username'] === 'admin'): ?>
                <ul class="nav-links">
                    <li><a href="./index.php" class="active">HOME</a></li>
                    <li><a href="/registration/admin/book.php">ADMIN PANEL</a></li>
                    <li><a href="./userDetails.php">LOGOUT</a></li>
                    <li><a href="./fake.html">CONTACT US</a></li>
                </ul>
            <?php elseif(isset($_SESSION['username'])): ?>
                <ul class="nav-links">
                    <li><a href="./index.php" class="active">HOME</a></li>
                    <li><a href="./userDetails.php">LOGOUT</a></li>
                    <li><a href="./fake.html">CONTACT US</a></li>
                </ul>
            <?php else: ?>
                <ul class="nav-links">
                    <li><a href="./index.php" class="active">HOME</a></li>
                    <li><a href="./login.php">LOGIN</a></li>
                    <li><a href="./register.php">REGISTER</a></li>
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
    </header>
    <div id="search-train">
        <div class="card-container">
            <div class="btn">
                <button type="pnr">PNR STATUS</button>
                <button type="chart">CHARTS / VACANCY</button>
            </div>
            <h2>BOOK TICKET</h2>
            
            <form action="search.php" method="post">
                <input type="hidden" name="name" value="<?php echo $name; ?>">
                <div class="form">
                    <div class="form1">
                        <label for="departure">Departure Station:</label>
                        <input type="text" id="departure" name="departure" placeholder="Enter Departure Station" required>

                        <label for="destination">Destination Station:</label>
                        <input type="text" id="destination" name="destination" placeholder="Enter Destination Station" required>

                        <select name="quota-id" size=1>
                            <option value="choice-id1">GENERAL</option>
                            <option value="choice-id2">LADIES</option>
                            <option value="choice-id3">LOWER BERTH/SR.CITIZEN</option>
                            <option value="choice-id4">PERSON WITH DISABILITY</option>
                            <option value="choice-id5">DUTY PASS</option>
                            <option value="choice-id6">TATKAL</option>
                            <option value="choice-id7">PREMIUM TATKAL</option>
                        </select>
                    </div>

                    <div class="form2">
                        <label for="date">Date of Travel:</label>
                        <input type="date" id="date" name="date" required>

                        <select name="classID" size=1>
                            <option value="choice-id11">All Classes</option>
                            <option value="choice-id21">Anubhuti Class (EA)</option>
                            <option value="choice-id31">AC First Class (1A)</option>
                            <option value="choice-id41">Exec. Chair Car (EC)</option>
                            <option value="choice-id51">AC 2 Tier (2A)</option>
                            <option value="choice-id61">AC 3 Tier (3A)</option>
                            <option value="choice-id71">AC 3 Economy (3E)</option>
                            <option value="choice-id81">Sleeper (SL)</option>
                            <option value="choice-id91">Second Sitting (2S)</option>
                        </select>
                    </div>
                </div>
                <button class="button1" type="submit">Search Trains</button>
            </form>
        </div>
    </div>
    <script>
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('date').setAttribute('min', today);
        document.getElementById('date').setAttribute('value', today);
    </script>
</body>

</html>




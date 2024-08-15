<?php
session_start();
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: ./login.php');
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: ./login.php");
}

$src = $_POST['departure'];
$dst = $_POST['destination'];
$date = $_POST['date'];

$user = 'root';
$password = '';
$database = 'registration';
$servername = 'localhost';
$port = 3306;
$mysqli = new mysqli($servername, $user, $password, $database, $port);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$check_passenger_query = "SELECT COUNT(*) as count FROM passengers";
$result = $mysqli->query($check_passenger_query);
$row = $result->fetch_assoc();
$count = $row['count'];

if ($count > 0) {
    $truncate_passenger_query = "TRUNCATE TABLE passengers";
    if ($mysqli->query($truncate_passenger_query) === TRUE) {
    } else {
        echo "Error emptying passenger table: " . $mysqli->error;
        exit;
    }
}

$sql = "SELECT * FROM trains WHERE source = '$src' AND destination ='$dst'";
$result = $mysqli->query($sql);
$mysqli->close();
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
  <link rel="shortcut icon" href="./assets/logo-new.png" type="image/x-icon">
    <link rel="stylesheet" href="./style/search.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <title>IRRS</title>
    
</head>

<body>
    <div id="header">
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
                    <li><a href="./register.php">REGISTER</a></li>
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
    <div id="main">
        <div class="main-container">
            <div class="find-schedule">
                <div class="find-journey">
                    <p><?php echo $src?></p>
                    <i class="fa-solid fa-arrow-right"></i>
                    <p><?php echo $dst?></p>
                </div>
                <div class="find-date">
                    <a href=""><i class="fa-solid fa-angle-left"></i></a>
                    <?php echo "$date";?>
                    <a href=""><i class="fa-solid fa-angle-right"></i></a>
                </div>
            </div>
            <div class="left-right">

                <div class="filter-schedule">
                    <form>
                    <br>
                    <div class="filter-head">
                        <p>FILTERS</p>
                        <input type="reset" id="reset" value="RESET ALL">
                    </div>
                    <br>
                    <hr>
                    <br>
                    <div class="filter-main-quota">
                        <p>Quota</p>
                        <br>
                        <div class="quota">
                            <span><input type="radio" id="general" value="GENERAL" checked="checked">
                                GENERAL&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <span><input type="radio" id="general" value="TATKAL"> TATKAL</span>
                        </div>
                        <br>
                        <input type="radio" id="general" value="LADIES"> LADIES
                    </div>
                    <br>
                    <hr>
                    <br>
                    <div class="filter-main-quota">
                        <p>Journey Class</p>
                        <br>
                        <div class="journey-1">
                            <input type="checkbox" value="GENERAL" checked="checked"> AC First Class(1A)<br><br>
                            <input type="checkbox" value="TATKAL" checked="checked"> Anubhuti Class (EA)<br><br>
                            <input type="checkbox" value="TATKAL" checked="checked"> Exec. Chair Car (EC)<br><br>
                            <input type="checkbox" value="TATKAL" checked="checked"> AC 2 Tier (2A)<br><br>
                            <input type="checkbox" value="GENERAL" checked="checked"> AC 3 Tier (3A)<br><br>
                            <input type="checkbox" value="TATKAL" checked="checked"> AC 3 Economy (3E)<br><br>
                            <input type="checkbox" value="TATKAL" checked="checked"> Sleeper (SL)<br><br>
                            <input type="checkbox" value="TATKAL" checked="checked"> Second Sitting (2S)<br><br>
                        </div>
                        <br>
                    </div>
                    </form>
                </div>
                <div class="train-schedule">
                <?php 
				while($rows=$result->fetch_assoc())
				{
			    ?>

                    <div class="train-card">
                        <div class="train-no-name">
                            <div class="train-name-extra">
                                <p><?php echo $rows['train_no'];?>&nbsp;</p>
                                <p><?php echo ' - ';?>
                                <p><?php echo $rows['train_name'];?></p>
                            </div>
                            <p><?php echo $rows['day'];?></p>
                        </div>
                        <div class="train-time">
                            <div class="time">
                                <p><?php echo $rows['departure_time'];?>&nbsp;</p> 
                                <p><?php echo $rows['src'];?> &nbsp;</p>
                            </div>
                            <div class="journey-time">
                                <hr>
                                <p>&nbsp;<?php echo $rows['time'];?> &nbsp;</p>
                                <hr>
                            </div>
                            <div class="time1">
                                <p> &nbsp;<?php echo $rows['arrival_time'];?>&nbsp;</p>
                                <p><?php echo $rows['dst'];?></p>
                            </div>
                        </div>
                        <div class="train-coach-book-card">
                            <button class="book-now-btn">Book Now</button>
                            <p>Available Seats: <?php echo $rows['seats'];?></p>
                            <p>₹ <?php echo $rows['fare'];?></p>
                        </div>
                    </div>

                <?php
				}
			    ?>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <div class="foot-1">
            <a href="#">Back to top</a>
        </div>
        <div class="foot-3">
            <div class="logo">
                <a href="#"><i class="fa-solid fa-train-subway"></i></a>
            </div>
        </div>
        <div class="foot-4">
            <div class="pages">
                <a href="#">Conditions of Use</a>
                <a href="#">Privacy Notice</a>
                <a href="#">Your Ads Privacy Choices</a>
            </div>
            <div class="copyright">
                <p>© 2025, Pratul Johari, Inc. or its affiliates</p>
            </div>
        </div>

    </footer>

    <script>
        $(function () {
            var dtToday = new Date();

            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate();
            var year = dtToday.getFullYear();
            if (month < 10) month = "0" + month.toString();
            if (day < 10) day = "0" + day.toString();
            var maxDate = year + "-" + month + "-" + day;
            $("#date").attr("min", maxDate);
        });
        document.addEventListener('DOMContentLoaded', function() {
            var buttons = document.querySelectorAll('.book-now-btn');
            buttons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var trainCard = button.closest('.train-card');
                    var trainNo = trainCard.querySelector('.train-name-extra p:first-child').textContent;
                    var trainName = trainCard.querySelector('.train-name-extra p:last-child').textContent;
                    var departureTime = trainCard.querySelector('.time p:first-child').textContent.trim();
                    var arrivalTime = trainCard.querySelector('.time1 p:first-child').textContent.trim();
                    var fare = trainCard.querySelector('.train-coach-book-card p:last-child').textContent.replace('₹', '').trim();  
                    var seats = trainCard.querySelector('.train-coach-book-card p:nth-child(2)').textContent.replace('Available Seats: ', '').trim();  

                    var src = '<?php echo $src; ?>';
                    var dst = '<?php echo $dst; ?>';
                    var date = '<?php echo $date; ?>';

                    var url = 'booking.php?src=' + encodeURIComponent(src) + '&dst=' + encodeURIComponent(dst) + '&date=' + encodeURIComponent(date) +
                        '&trainNo=' + encodeURIComponent(trainNo) + '&trainName=' + encodeURIComponent(trainName) +
                        '&departureTime=' + encodeURIComponent(departureTime) + '&arrivalTime=' + encodeURIComponent(arrivalTime) + '&seats=' + encodeURIComponent(seats)  + 
                        '&fare=' + encodeURIComponent(fare);
                    window.location.href = url;
                });
            });
        });
</script>

</body>

</html>             
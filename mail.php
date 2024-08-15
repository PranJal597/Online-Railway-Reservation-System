<?php
session_start();

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header("location: ./login.php");
    exit();
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: ./login.php");
    exit();
}

$user = 'root';
$password = '';
$database = 'registration';
$servername='localhost:3306';
$mysqli = new mysqli($servername, $user, $password, $database);
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$username = $_SESSION['username'];
$sql = "SELECT email FROM users WHERE username = '$username'";

$result = $mysqli->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $email = $row['email'];
} else {
    echo "Error retrieving email: " . $mysqli->error;
}

$passengerData = array();
$sql_passenger = "SELECT * FROM passengers";
$result_passenger = $mysqli->query($sql_passenger);

if ($result_passenger && $result_passenger->num_rows > 0) {
    while($row_passenger = $result_passenger->fetch_assoc()) {
        $passengerData[] = $row_passenger;
    }
} else {
    echo "Error retrieving passenger data: " . $mysqli->error;
}

$mysqli->close();

$to = $email;
$subject = 'Booking Confirmation on IRRS';

$message = "<html>
<head>
    <title>Booking Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
        }
        .header {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            text-align: center;
        }
        .content {
            padding: 20px;
        }
        .passenger-details {
            border-collapse: collapse;
            width: 100%;
        }
        .passenger-details td,
        .passenger-details th {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .passenger-details th {
            text-align: left;
            background-color: #f2f2f2;
        }
        .head {
            color: blue;
        }
    </style>
</head>
<body>
    <div class='header'>
        <h2>Booking confirmation on IRRS</h2>
    </div>
    <div class='content'>
        <p>Dear ".$username.",</p>
        <p>Thank you for using IRRS's online rail reservation facility. Your booking details are indicated below:</p>
        <table class='passenger-details'>
            <tr>
                <th>PNR No.</th>
                <td>".$passengerData[0]['pnr']."</td>
                <th>Train No./Name</th>
                <td>".$passengerData[0]['trainNo']."/".$passengerData[0]['trainName']."</td>
            </tr>
            <tr>
                <th>FROM</th>
                <td>".$passengerData[0]['source']."</td>
                <th>TO</th>
                <td>".$passengerData[0]['destination']."</td>
            </tr>
            <tr>
                <th>BOARDING AT</th>
                <td>".$passengerData[0]['source']."</td>
                <th>SCHEDULE DEPARTURE</th>
                <td>".$passengerData[0]['journeydate']." ".$passengerData[0]['depTime']."</td>
            </tr>
        </table>
        <h2 class='head'>Passenger Details</h2>
        <table class='passenger-details'>
            <tr>
                <th>NAME</th>
                <th>AGE</th>
                <th>GENDER</th>
                <th>COACH</th>
                <th>SEAT</th>
            </tr>";
foreach ($passengerData as $passenger) {
    $message .= "<tr>
                    <td>".$passenger['name']."</td>
                    <td>".$passenger['age']."</td>
                    <td>".$passenger['gender']."</td>
                    <td>".$passenger['co']."</td>
                    <td>".$passenger['se']."</td>
                </tr>";
}
$message .= "</table></div></body></html>";

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From: IRRS irrs.ticket@gmail.com' . "\r\n";
$check = mail($to, $subject, $message, $headers);
if($check){
    header("location: ./transfer.php");
} else {
    echo "Email not sent";
}
?>

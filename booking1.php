<?php
$user = 'root';
$password = '';
$database = 'registration';
$servername = 'localhost';
$port = 3306;
$mysqli = new mysqli($servername, $user, $password, $database, $port);
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
$pnr = '21474' . rand(2111, 9999);
$co = 'S' . rand(1, 9);
$se = rand(1, 90);
$date = $_POST['date'];
$src = $_POST['src'];
$dst = $_POST['dst'];
$trainNo = $_POST['trainNo'];
$trainName = $_POST['trainName'];
$depTime = $_POST['depTime'];
$arrTime = $_POST['arrTime'];
$fare = $_POST['fare'];
$name = $_POST['name'];
$age = $_POST['age'];
$berth = $_POST['berth'];
$gender = $_POST['gender'];
$country = $_POST['country'];
$currentPath = $_POST['currentPath'];
$currentPath = $currentPath . '?from=temp1';
date_default_timezone_set('Asia/Kolkata');
$bookDate = date("Y-m-d H:i:s");
$sql = "INSERT INTO passengers (name, gender, age, berth, country, trainNo, trainName, journeydate, bookDate, source, destination, fare, depTime, arrTime, pnr, co, se) 
VALUES ('$name', '$gender', '$age', '$berth', '$country', '$trainNo', '$trainName', '$date', '$bookDate', '$src', '$dst', '$fare', '$depTime', '$arrTime', '$pnr', '$co', '$se')";
$update_query = "UPDATE trains SET seats = seats - 1 WHERE train_no = '$trainNo'";

if ($mysqli->query($sql) === TRUE) {
    if ($mysqli->query($update_query) === TRUE) {
        header("location: $currentPath");
    } else {
        echo "Error updating record: " . $mysqli->error;
    }
} else {
    echo "Error inserting record: " . $mysqli->error;
}
$mysqli->close();
?>

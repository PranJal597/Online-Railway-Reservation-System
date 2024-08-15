<?php
session_start();

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
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

$sql_passenger = "SELECT * FROM passengers";
$result_passenger = $mysqli->query($sql_passenger);

if ($result_passenger && $result_passenger->num_rows > 0) {
    while($row_passenger = $result_passenger->fetch_assoc()) {
        $name = $row_passenger['name'];
        $gender = $row_passenger['gender'];
        $age = $row_passenger['age'];
        $berth = $row_passenger['berth'];
        $country = $row_passenger['country'];
        $trainNo = $row_passenger['trainNo'];
        $trainName = $row_passenger['trainName'];
        $journeydate = $row_passenger['journeydate'];
        $bookDate = $row_passenger['bookDate'];
        $source = $row_passenger['source'];
        $destination = $row_passenger['destination'];
        $fare = $row_passenger['fare'];
        $depTime = $row_passenger['depTime'];
        $arrTime = $row_passenger['arrTime'];
        $pnr = $row_passenger['pnr'];
        $co = $row_passenger['co'];
        $se = $row_passenger['se'];

        $sql_booking = "INSERT INTO booking (name, gender, age, berth, country, trainNo, trainName, journeydate, bookDate, source, destination, fare, depTime, arrTime, pnr, co, se) 
                        VALUES ('$name', '$gender', '$age', '$berth', '$country', '$trainNo', '$trainName', '$journeydate', '$bookDate', '$source', '$destination', '$fare', '$depTime', '$arrTime', '$pnr', '$co', '$se')";

        if ($mysqli->query($sql_booking) !== TRUE) {
            echo "Error inserting data into booking table: " . $mysqli->error;
        }
    }
} 
else {
    echo "Error retrieving passenger data: " . $mysqli->error;
}


$sql_delete = "DELETE FROM passengers";

if ($mysqli->query($sql_delete) === TRUE) {
    echo "All data from passengers table deleted successfully";
} else {
    echo "Error deleting data from passengers table: " . $mysqli->error;
}
header("location: ./thankyou.html");
$mysqli->close();
?>

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

$user = 'root';
$password = '';
$database = 'registration';
$servername='localhost:3306';
$mysqli = new mysqli($servername, $user, $password, $database);
if ($mysqli->connect_error) {
	die('Connect Error (' .
	$mysqli->connect_errno . ') '.
	$mysqli->connect_error);
}
$totalFare = 0;
$sql = "SELECT *FROM passengers";
$result = $mysqli->query($sql);
while($rows=$result->fetch_assoc())
{
    $totalFare = $totalFare + $rows['fare'];
}

$mysqli->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="payment.css">
</head>

<body>
    <div id="main">
        <div class="header">
            <h1>Payment</h1>
        </div>
        <div class="container">
            <div class="payment-options">
                <div class="option">
                    <input type="radio" id="credit-card" name="payment" value="credit-card">
                    <label for="credit-card">Credit Card</label>
                </div>
                <div class="option">
                    <input type="radio" id="debit-card" name="payment" value="debit-card">
                    <label for="debit-card">Debit Card</label>
                </div>
                <div class="option">
                    <input type="radio" id="upi" name="payment" value="upi">
                    <label for="upi">UPI</label>
                </div>
                <div class="option">
                    <input type="radio" id="qr-code" name="payment" value="qr-code">
                    <label for="qr-code">QR Code</label>
                </div>
            </div>
            <div class="payment-details" id="payment-details">
                <div class="credit-card-details">
                    <label for="card-number">Card Number:</label>
                    <input type="text" id="card-number" placeholder="Enter card number">
                    <label for="expiry">Expiry Date:</label>
                    <input type="text" id="expiry" placeholder="MM/YY">
                    <label for="cvv">CVV:</label>
                    <input type="text" id="cvv" placeholder="CVV">
                </div>
                <div class="upi-details">
                    <label for="upi-id">UPI ID:</label>
                    <input type="text" id="upi-id" placeholder="Enter UPI ID">
                </div>
                <div class="qr-code-details" id="qr-code-details">
                    <img src="./assets/qr.jpg" alt="QR Code">
                </div>
            </div>
            <div class="total-amount">
                <label for="total-amount">Total Amount:</label>
                <input type="text" id="total-amount" placeholder="Total amount" readonly>
            </div>
            <button id="pay-button">Pay Now</button>
        </div>
    </div>
    <script>

  document.addEventListener("DOMContentLoaded", function () {
  const creditCardDetails = document.querySelector(".credit-card-details");
  const upiDetails = document.querySelector(".upi-details");
  const qrCodeDetails = document.querySelector(".qr-code-details");
  const buttondetail = document.getElementById("pay-button");

  // Function to hide all payment details
  function hideAllDetails() {
    creditCardDetails.style.display = "none";
    upiDetails.style.display = "none";
    qrCodeDetails.style.display = "none";
  }

  hideAllDetails();

  // Function to show payment details based on selected option
  function showPaymentDetails(option) {
    hideAllDetails();
    switch (option) {
      case "credit-card":
        creditCardDetails.style.display = "block";
        buttondetail.innerHTML = "Pay Now";
        break;
      case "debit-card":
        creditCardDetails.style.display = "block";
        buttondetail.innerHTML = "Pay Now";
        break;
      case "upi":
        upiDetails.style.display = "block";
        buttondetail.innerHTML = "Verify Now";
        break;
      case "qr-code":
        qrCodeDetails.style.display = "block";
        buttondetail.innerHTML = "Verify Now";
        break;
      default:
        break;
    }
  }

  // Event listener for radio button changes
  const radioButtons = document.querySelectorAll('input[name="payment"]');
  radioButtons.forEach(function (radio) {
    radio.addEventListener("change", function () {
      if (this.checked) {
        showPaymentDetails(this.value);
      }
    });
  });
});

// Calculate Total Fare
document.addEventListener("DOMContentLoaded", function () {
  function updateTotalAmount(amount) {
    const totalAmountInput = document.getElementById("total-amount");
    totalAmountInput.value = amount.toFixed(2);
  }
  const totalAmount = <?php echo $totalFare; ?>;
  updateTotalAmount(totalAmount);
});

document.addEventListener("DOMContentLoaded", function () {
  var redirectButton = document.getElementById("pay-button");
  redirectButton.addEventListener("click", function () {
    window.location.href = "./mail.php";
  });
});

    </script>
</body>

</html>
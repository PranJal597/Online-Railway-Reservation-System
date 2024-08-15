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

$date = $_GET['date'];
$date = date("d-m-Y", strtotime($date));

$src = $_GET['src'];
$dst = $_GET['dst'];
$trainNo = $_GET['trainNo'];
$trainName = $_GET['trainName'];
$depTime = $_GET['departureTime'];
$arrTime = $_GET['arrivalTime'];
$fare = $_GET['fare'];
$seats = $_GET['seats'];

$currentPath = $_SERVER['REQUEST_URI'];
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
    <link rel="shortcut icon" href="./asset/irrs-india-logo1.png" type="image/x-icon">
    <link rel="stylesheet" href="booking.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <title>IRRS</title>
    <style>
        * {
            padding: 0;
            margin: 0;
        }

        .hidden {
            display: none;
        }

        .alert {
            border-radius: 5px;
            border: 1px solid #30634c;
            background-color: #D1E7DD;
            padding: 15px 25px;
        }

        .head-container {
            max-height: 17vh;
            background-color: aliceblue;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-links,
        .head-container,
        nav,
        .user,
        .left,
        .right {
            display: flex;
            align-items: center;
        }

        nav p {
            font-size: 30px;
        }

        .nav-links {
            justify-content: center;
            padding: 20px auto;
            gap: .5rem;
            list-style: none;
            font-size: .8rem;
        }

        .nav-links li a:hover {
            display: inline-block;
            list-style: none;
            background-color: #2b509a;
            color: #fff
        }

        .nav-links li a {
            display: inline-block;
            color: black;
            text-decoration: none;
            padding: 10px;
            text-decoration-color: white;
        }

        .nav-links li a.active {
            padding: 10px;
            color: #fff;
            background-color: #2b509a;
            cursor: pointer;
        }

        .logo,
        .user {
            background-color: white;
            margin: 10px 10px 10px 30px;
            padding: 10px;
            border: 1px solid lightgrey;
            border-radius: 50%;
        }

        .username {
            margin: 10px 40px 10px 0;
            font-size: 20px;
        }

        .logo a,
        .user a {
            text-decoration: none;
            color: #131921;
        }

        .logo i,
        .user i {
            font-size: 30px;
        }

        .logo:hover,
        .user:hover {
            cursor: default;
        }
    </style>
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
    <div id="main">
    <div class="alert alert-success hidden" role="alert" id="successAlert">
                        Passengers Details has been saved successfully.
    </div>
        <div class="container">
            <div class="passenger">
                <h2 class="pass-head">Passenger Details</h2>
                <div class="journey card">
                    <h4 class="card-head">JOURNEY DETAILS</h4>
                    <p class="bold">
                        <?php echo $trainNo . $trainName ?></p>
                    <p class="bold">Mon, <?php echo $date ?></p>
                    <p class="bold">
                        <?php echo $src ?> (<?php echo $depTime ?>)
                        <i class="fa-solid fa-arrow-right"></i>
                        <?php echo $dst ?> (<?php echo $arrTime ?>)
                    </p>
                </div>
                <form action="booking1.php" method="POST">
                <div id="passengerDetails" class="details card">
                    <h4 class="card-head">PASSENGER DETAILS</h4>
                    <div class="container-card">
                        <div class="card-left">
                            <label for="name">Full Name</label><br>
                            <input type="text" id="name" class="name" name="name" placeholder="Enter Full Name" required>
                            <p class="note">Note - Name should be the same as on Government ID proof</p>
                        </div>
                        <div class="card-right">
                            <label for="age">Age</label><br>
                            <input type="text" id="age" class="age" name="age" placeholder="Enter Age" required><br>
                        </div>
                    </div>
                    <br>
                    <div class="container-card">
                        <div class="card-left">
                            <label for="berth">Berth Preferences</label><br>
                            <select id="berth" name="berth">
                                <option value="No Berth Preference">No Berth Preference</option>
                                <option value="Lower Berth">Lower Berth</option>
                                    <option value="Middle Berth">Middle Berth</option>
                                    <option value="Upper Berth">Upper Berth</option>
                                    <option value="Side Lower">Side Lower</option>
                                    <option value="Side Upper">Side Upper</option>
                            </select>
                            </div>
                            <div class="card-right">
                                <label for="nationality">Nationality</label><br>
                                <select id="country" name="country">
                                    
                                    <option value="IN">India</option>
                                    <option value="AF">Afghanistan</option>
                                    <option value="AX">Aland Islands</option>
                                    <option value="AL">Albania</option>
                                    <option value="DZ">Algeria</option>
                                    <option value="AS">American Samoa</option>
                                    <option value="AD">Andorra</option>
                                    <option value="AO">Angola</option>
                                    <option value="AI">Anguilla</option>
                                    <option value="AQ">Antarctica</option>
                                    <option value="AG">Antigua and Barbuda</option>
                                    <option value="AR">Argentina</option>
                                    <option value="AM">Armenia</option>
                                    <option value="AW">Aruba</option>
                                    <option value="AU">Australia</option>
                                    <option value="AT">Austria</option>
                                    <option value="AZ">Azerbaijan</option>
                                    <option value="BS">Bahamas</option>
                                    <option value="BH">Bahrain</option>
                                    <option value="BD">Bangladesh</option>
                                    <option value="BB">Barbados</option>
                                    <option value="BY">Belarus</option>
                                    <option value="BE">Belgium</option>
                                    <option value="BZ">Belize</option>
                                    <option value="BJ">Benin</option>
                                    <option value="BM">Bermuda</option>
                                    <option value="BT">Bhutan</option>
                                    <option value="BO">Bolivia</option>
                                    <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                                    <option value="BA">Bosnia and Herzegovina</option>
                                    <option value="BW">Botswana</option>
                                    <option value="BV">Bouvet Island</option>
                                    <option value="BR">Brazil</option>
                                    <option value="IO">British Indian Ocean Territory</option>
                                    <option value="BN">Brunei Darussalam</option>
                                    <option value="BG">Bulgaria</option>
                                    <option value="BF">Burkina Faso</option>
                                    <option value="BI">Burundi</option>
                                    <option value="KH">Cambodia</option>
                                    <option value="CM">Cameroon</option>
                                    <option value="CA">Canada</option>
                                    <option value="CV">Cape Verde</option>
                                    <option value="KY">Cayman Islands</option>
                                    <option value="CF">Central African Republic</option>
                                    <option value="TD">Chad</option>
                                    <option value="CL">Chile</option>
                                    <option value="CN">China</option>
                                    <option value="CX">Christmas Island</option>
                                    <option value="CC">Cocos (Keeling) Islands</option>
                                    <option value="CO">Colombia</option>
                                    <option value="KM">Comoros</option>
                                    <option value="CG">Congo</option>
                                    <option value="CD">Congo, Democratic Republic of the Congo</option>
                                    <option value="CK">Cook Islands</option>
                                    <option value="CR">Costa Rica</option>
                                    <option value="CI">Cote D'Ivoire</option>
                                    <option value="HR">Croatia</option>
                                    <option value="CU">Cuba</option>
                                    <option value="CW">Curacao</option>
                                    <option value="CY">Cyprus</option>
                                    <option value="CZ">Czech Republic</option>
                                    <option value="DK">Denmark</option>
                                    <option value="DJ">Djibouti</option>
                                    <option value="DM">Dominica</option>
                                    <option value="DO">Dominican Republic</option>
                                    <option value="EC">Ecuador</option>
                                    <option value="EG">Egypt</option>
                                    <option value="SV">El Salvador</option>
                                    <option value="GQ">Equatorial Guinea</option>
                                    <option value="ER">Eritrea</option>
                                    <option value="EE">Estonia</option>
                                    <option value="ET">Ethiopia</option>
                                    <option value="FK">Falkland Islands (Malvinas)</option>
                                    <option value="FO">Faroe Islands</option>
                                    <option value="FJ">Fiji</option>
                                    <option value="FI">Finland</option>
                                    <option value="FR">France</option>
                                    <option value="GF">French Guiana</option>
                                    <option value="PF">French Polynesia</option>
                                    <option value="TF">French Southern Territories</option>
                                    <option value="GA">Gabon</option>
                                    <option value="GM">Gambia</option>
                                    <option value="GE">Georgia</option>
                                    <option value="DE">Germany</option>
                                    <option value="GH">Ghana</option>
                                    <option value="GI">Gibraltar</option>
                                    <option value="GR">Greece</option>
                                    <option value="GL">Greenland</option>
                                    <option value="GD">Grenada</option>
                                    <option value="GP">Guadeloupe</option>
                                    <option value="GU">Guam</option>
                                    <option value="GT">Guatemala</option>
                                    <option value="GG">Guernsey</option>
                                    <option value="GN">Guinea</option>
                                    <option value="GW">Guinea-Bissau</option>
                                    <option value="GY">Guyana</option>
                                    <option value="HT">Haiti</option>
                                    <option value="HM">Heard Island and Mcdonald Islands</option>
                                    <option value="VA">Holy See (Vatican City State)</option>
                                    <option value="HN">Honduras</option>
                                    <option value="HK">Hong Kong</option>
                                    <option value="HU">Hungary</option>
                                    <option value="IS">Iceland</option>
                                    <option value="ID">Indonesia</option>
                                    <option value="IR">Iran, Islamic Republic of</option>
                                    <option value="IQ">Iraq</option>
                                    <option value="IE">Ireland</option>
                                    <option value="IM">Isle of Man</option>
                                    <option value="IL">Israel</option>
                                    <option value="IT">Italy</option>
                                    <option value="JM">Jamaica</option>
                                    <option value="JP">Japan</option>
                                    <option value="JE">Jersey</option>
                                    <option value="JO">Jordan</option>
                                    <option value="KZ">Kazakhstan</option>
                                    <option value="KE">Kenya</option>
                                    <option value="KI">Kiribati</option>
                                    <option value="KP">Korea, Democratic People's Republic of</option>
                                    <option value="KR">Korea, Republic of</option>
                                    <option value="XK">Kosovo</option>
                                    <option value="KW">Kuwait</option>
                                    <option value="KG">Kyrgyzstan</option>
                                    <option value="LA">Lao People's Democratic Republic</option>
                                    <option value="LV">Latvia</option>
                                    <option value="LB">Lebanon</option>
                                    <option value="LS">Lesotho</option>
                                    <option value="LR">Liberia</option>
                                    <option value="LY">Libyan Arab Jamahiriya</option>
                                    <option value="LI">Liechtenstein</option>
                                    <option value="LT">Lithuania</option>
                                    <option value="LU">Luxembourg</option>
                                    <option value="MO">Macao</option>
                                    <option value="MK">Macedonia, the Former Yugoslav Republic of</option>
                                    <option value="MG">Madagascar</option>
                                    <option value="MW">Malawi</option>
                                    <option value="MY">Malaysia</option>
                                    <option value="MV">Maldives</option>
                                    <option value="ML">Mali</option>
                                    <option value="MT">Malta</option>
                                    <option value="MH">Marshall Islands</option>
                                    <option value="MQ">Martinique</option>
                                    <option value="MR">Mauritania</option>
                                    <option value="MU">Mauritius</option>
                                    <option value="YT">Mayotte</option>
                                    <option value="MX">Mexico</option>
                                    <option value="FM">Micronesia, Federated States of</option>
                                    <option value="MD">Moldova, Republic of</option>
                                    <option value="MC">Monaco</option>
                                    <option value="MN">Mongolia</option>
                                    <option value="ME">Montenegro</option>
                                    <option value="MS">Montserrat</option>
                                    <option value="MA">Morocco</option>
                                    <option value="MZ">Mozambique</option>
                                    <option value="MM">Myanmar</option>
                                    <option value="NA">Namibia</option>
                                    <option value="NR">Nauru</option>
                                    <option value="NP">Nepal</option>
                                    <option value="NL">Netherlands</option>
                                    <option value="AN">Netherlands Antilles</option>
                                    <option value="NC">New Caledonia</option>
                                    <option value="NZ">New Zealand</option>
                                    <option value="NI">Nicaragua</option>
                                    <option value="NE">Niger</option>
                                    <option value="NG">Nigeria</option>
                                    <option value="NU">Niue</option>
                                    <option value="NF">Norfolk Island</option>
                                    <option value="MP">Northern Mariana Islands</option>
                                    <option value="NO">Norway</option>
                                    <option value="OM">Oman</option>
                                    <option value="PK">Pakistan</option>
                                    <option value="PW">Palau</option>
                                    <option value="PS">Palestinian Territory, Occupied</option>
                                    <option value="PA">Panama</option>
                                    <option value="PG">Papua New Guinea</option>
                                    <option value="PY">Paraguay</option>
                                    <option value="PE">Peru</option>
                                    <option value="PH">Philippines</option>
                                    <option value="PN">Pitcairn</option>
                                    <option value="PL">Poland</option>
                                    <option value="PT">Portugal</option>
                                    <option value="PR">Puerto Rico</option>
                                    <option value="QA">Qatar</option>
                                    <option value="RE">Reunion</option>
                                    <option value="RO">Romania</option>
                                    <option value="RU">Russian Federation</option>
                                    <option value="RW">Rwanda</option>
                                    <option value="BL">Saint Barthelemy</option>
                                    <option value="SH">Saint Helena</option>
                                    <option value="KN">Saint Kitts and Nevis</option>
                                    <option value="LC">Saint Lucia</option>
                                    <option value="MF">Saint Martin</option>
                                    <option value="PM">Saint Pierre and Miquelon</option>
                                    <option value="VC">Saint Vincent and the Grenadines</option>
                                    <option value="WS">Samoa</option>
                                    <option value="SM">San Marino</option>
                                    <option value="ST">Sao Tome and Principe</option>
                                    <option value="SA">Saudi Arabia</option>
                                    <option value="SN">Senegal</option>
                                    <option value="RS">Serbia</option>
                                    <option value="CS">Serbia and Montenegro</option>
                                    <option value="SC">Seychelles</option>
                                    <option value="SL">Sierra Leone</option>
                                    <option value="SG">Singapore</option>
                                    <option value="SX">Sint Maarten</option>
                                    <option value="SK">Slovakia</option>
                                    <option value="SI">Slovenia</option>
                                    <option value="SB">Solomon Islands</option>
                                    <option value="SO">Somalia</option>
                                    <option value="ZA">South Africa</option>
                                    <option value="GS">South Georgia and the South Sandwich Islands</option>
                                    <option value="SS">South Sudan</option>
                                    <option value="ES">Spain</option>
                                    <option value="LK">Sri Lanka</option>
                                    <option value="SD">Sudan</option>
                                    <option value="SR">Suriname</option>
                                    <option value="SJ">Svalbard and Jan Mayen</option>
                                    <option value="SZ">Swaziland</option>
                                    <option value="SE">Sweden</option>
                                    <option value="CH">Switzerland</option>
                                    <option value="SY">Syrian Arab Republic</option>
                                    <option value="TW">Taiwan, Province of China</option>
                                    <option value="TJ">Tajikistan</option>
                                    <option value="TZ">Tanzania, United Republic of</option>
                                    <option value="TH">Thailand</option>
                                    <option value="TL">Timor-Leste</option>
                                    <option value="TG">Togo</option>
                                    <option value="TK">Tokelau</option>
                                    <option value="TO">Tonga</option>
                                    <option value="TT">Trinidad and Tobago</option>
                                    <option value="TN">Tunisia</option>
                                    <option value="TR">Turkey</option>
                                    <option value="TM">Turkmenistan</option>
                                    <option value="TC">Turks and Caicos Islands</option>
                                    <option value="TV">Tuvalu</option>
                                    <option value="UG">Uganda</option>
                                    <option value="UA">Ukraine</option>
                                    <option value="AE">United Arab Emirates</option>
                                    <option value="GB">United Kingdom</option>
                                    <option value="US">United States</option>
                                    <option value="UM">United States Minor Outlying Islands</option>
                                    <option value="UY">Uruguay</option>
                                    <option value="UZ">Uzbekistan</option>
                                    <option value="VU">Vanuatu</option>
                                    <option value="VE">Venezuela</option>
                                    <option value="VN">Viet Nam</option>
                                    <option value="VG">Virgin Islands, British</option>
                                    <option value="VI">Virgin Islands, U.s.</option>
                                    <option value="WF">Wallis and Futuna</option>
                                    <option value="EH">Western Sahara</option>
                                    <option value="YE">Yemen</option>
                                    <option value="ZM">Zambia</option>
                                    <option value="ZW">Zimbabwe</option>
                                </select> 
                            </div>
                        </div>
                        <input type="hidden" name="date" value="<?php echo $date; ?>">
                        <input type="hidden" name="src" value="<?php echo $src; ?>">
                        <input type="hidden" name="dst" value="<?php echo $dst; ?>">
                        <input type="hidden" name="trainNo" value="<?php echo $trainNo; ?>">
                        <input type="hidden" name="trainName" value="<?php echo $trainName; ?>">
                        <input type="hidden" name="depTime" value="<?php echo $depTime; ?>">
                        <input type="hidden" name="arrTime" value="<?php echo $arrTime; ?>">
                        <input type="hidden" name="fare" value="<?php echo $fare; ?>">
                        <input type="hidden" name="currentPath" value="<?php echo $currentPath; ?>">
    
                        <br>
                        <div class="container-card">
                            <div class="gender">
                                <input type="radio" name="gender" id="male" value="Male">
                                <label for="male">Male</label>
                                <input type="radio" name="gender" id="female" value="Female">
                                <label for="female">Female</label>
                                <input type="radio" name="gender" id="trans" value="Transgender">
                                <label for="trans">Transgender</label>
                            </div>
                            <div class="button-right">
                                <button type="submit" class="button-box-2">Save</button>
                            </div></form>
                        </div>
                    </div>
                    
                    <button type="button" id="submit-button" onclick="proceed()">Proceed</button>
                </div>
                </div>
                <div class="train"></div>
            </div>
        </div>
        
    <footer>
        <div class="foot-1">
            <a href="#">Back to top</a>
        </div>
        <div class="foot-3">
            <div class="logo">
                <a href="#">
                    <i class="fa-solid fa-train-subway"></i>
                </a>
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
         if (window.location.href.indexOf('from=temp1') !== -1) {
            document.getElementById('successAlert').classList.remove('hidden');
            setTimeout(function () {
                document.getElementById('successAlert').classList.add('hidden');
            }, 5000);
        }

        var button = document.getElementById("submit-button");
        button.addEventListener("click", function() {
            var destinationURL = "./payment.php";
            window.location.href = destinationURL;
        });
    </script>
</body>

</html>
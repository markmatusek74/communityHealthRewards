<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require("simpleXML.class.php");

require_once("classes/phpMailer/class.phpmailer.php");
require_once("classes/phpMailer/class.smtp.php");
//$eml = new PHPMailer();

$status = "failed";


$firstname = trim("Mark");
$lastName = trim("Matusek");
$streetAddress = trim("3905 Crown Ridge Ct.");
$streetAddress2 = "";
$city = trim("College Station");
$state = trim("TX");
$zip = trim("77845");
$country = "";
$phone = trim("9795715353");
$email = strtolower("markmatusek74@gmail.com");
$dobD = trim("05/17/1974");

//$existingID = $users->checkForExistingAccount($email);
//$accountType = ($existingID > 0 ) ? "existing" : "new";


$v = array(
    array(
        "data" => array(
            "status" => $status,
            "member_id" => $MemberID,
            "first_name" =>   $firstname,
            "last_name" => $lastName,
            "street_address" => $streetAddress,
            "street_address2" => $streetAddress2,
            "city" => $city,
            "state" => $state,
            "zip" => $zip,
            "country" => $country,
            "phone" => $phone,
            "email" => $email,
            "dob" => $dobD

        )
    )
);

$jsonI = json_encode($v);
print $jsonI;


?>

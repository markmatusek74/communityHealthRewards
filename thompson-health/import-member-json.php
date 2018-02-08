<?php
require("simpleXML.class.php");
require_once("classes/users.class.php");
$users = new users();

require_once("classes/phpMailer/class.phpmailer.php");
require_once("classes/phpMailer/class.smtp.php");
$eml = new PHPMailer();

$status = "failed";

$url = 'https://amt.accessdevelopment.com/api/v1/imports.xml';

// BEGIN - Variables Set for use in the XML transmission
$orgCustId = "2002214";
$programCustId = "200590";
$recordType = "MEM_SYN";
$recordIdentity = "th2017";
$memberStatus = "OPEN";
$nextId = $users->getLastUserID();  // Last inserted user id as int (with the chr prefix removed in query)
$nextId++; // Increment for next insert.
$MemberID =  "TH" . str_pad($nextId, 7, '0', STR_PAD_LEFT);
// END - Variables Set for use in the XML transmission
$debug = false;

//$firstname = $_POST['dnn$ctr3561$View$Fullname_3561_1_FirstName'];
//$lastName = $_POST['dnn$ctr3561$View$Fullname_3561_1_LastName'];
//$streetAddress = $_POST['dnn$ctr3561$View$Address_3561_2_StreetAddress'];
//$streetAddress2 = $_POST['dnn$ctr3561$View$Address_3561_2_StreetAddressLine2'];
//$city = $_POST['dnn$ctr3561$View$Address_3561_2_City'];
//$state = $_POST['dnn$ctr3561$View$Address_3561_2_StateProvince'];
//$zip = $_POST['dnn$ctr3561$View$Address_3561_2_PostalZipCode'];
//$country = $_POST['dnn$ctr3561$View$Address_3561_2_Country'];
//$phone = "(" . $_POST['dnn$ctr3561$View$Phone_3561_3'] . ")" . $_POST['dnn$ctr3561$View$Phone_3561_3_PhoneNo'];
//$email = $_POST['dnn$ctr3561$View$Email_3561_4'];
//$dob = $_POST['dnn$ctr3561$View$Birthdate_3561_5_Month'] . "/" . $_POST['dnn$ctr3561$View$Birthdate_3561_5'] . "/" . $_POST['dnn$ctr3561$View$Birthdate_3561_5_Year'];
//$dobD = $_POST['dnn$ctr3561$View$Birthdate_3561_5_Month'] . "-" . $_POST['dnn$ctr3561$View$Birthdate_3561_5'] . "-" . $_POST['dnn$ctr3561$View$Birthdate_3561_5_Year'];

$firstname = trim($_POST["First"]);
$lastName = trim($_POST["Last"]);
$streetAddress = trim($_POST["Address"]);
$streetAddress2 = "";
$city = trim($_POST["City"]);
$state = trim($_POST["State"]);
$zip = trim($_POST["Zip"]);
$country = "";
$phone = trim($_POST["Phone"]);
$email = strtolower(trim($_POST["Email"]));
$dob = trim($_POST["Birthdate"]);
$dobD = trim($_POST["Birthdate"]);

$existingID = $users->checkForExistingAccount($email);
$accountType = ($existingID > 0 ) ? "existing" : "new";


$users->addUserFormSubmission($_POST,$existingID,$accountType);
if ($debug == true)
{
    echo "<table width='600px' cellpadding='5' cellspacing='0' border='1'>";
    echo "<tr><td>First Name</td><td>" . $firstname . "</td></tr>";
    echo "<tr><td>Last Name</td><td>" . $lastName . "</td></tr>";
    echo "<tr><td>Street Address</td><td>" . $streetAddress . "</td></tr>";
    echo "<tr><td>Street Address Line 2</td><td>" . $streetAddress2 . "</td></tr>";
    echo "<tr><td>City</td><td>" . $city . "</td></tr>";
    echo "<tr><td>State</td><td>" . $state . "</td></tr>";
    echo "<tr><td>Zip</td><td>" . $zip . "</td></tr>";
    echo "<tr><td>Country</td><td>" . $country . "</td></tr>";
    echo "<tr><td>Phone</td><td>" . $phone . "</td></tr>";
    echo "<tr><td>Email</td><td>" . $email . "</td></tr>";
    echo "<tr><td>Date of Birth</td><td>" . $dob . "</td></tr>";

    echo "</table>";
}

if ($existingID == 0 )
{

    $header = array("Content-Type: application/xml", "Access-Token: 93f3a53befc4c4c1dfb5d6af4e28af7d475739caac394c9a5b95a6c9ae130eb2");


    // organization_customer_identifier: "2002214" ,program_customer_identifier: "200352", member_customer_identifier: "mmatuseks1138", full_name: "Mark Matusek",
    //email_address: "mark1138@matusek.com" }]}},
    function XML2Array ( $xml )
    {
        $array = simplexml_load_string ( $xml );
        $newArray = array ( ) ;
        $array = ( array ) $array ;
        foreach ( $array as $key => $value )
        {
            $value = ( array ) $value ;
            $newArray [ $key] = $value [ 0 ] ;
        }
        $newArray = array_map("trim", $newArray);
        return $newArray ;
    }
    $request ='<?xml version="1.0" encoding="UTF-8"?>
    <import>
    <members type="array">
    <member>
    <organization-customer-identifier>' . $orgCustId . '</organization-customer-identifier>
    <program-customer-identifier>' .$programCustId . '</program-customer-identifier>
    <first-name>' . $firstname . '</first-name>
    <last-name>' . $lastName . '</last-name>
    <email-address>' . $email . '</email-address>
    <member-customer-identifier>' . $MemberID . '</member-customer-identifier>
    <member-status>' . $memberStatus . '</member-status>
    <record-identifier>' . $recordIdentity . '</record-identifier>
    <record-type>' . $recordType . '</record-type>
    </member>
    </members>
    </import>';

    //print_r($request);
    //print_r($header);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 50);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_POST, true);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
    $page_content = curl_exec($ch);


    $xml=simplexml_load_string($page_content) or die("Error: Cannot create object");
    //print_r($xml);

    $status = $xml->data->status;


    if ($status == "imported")
    {
        $users->addUserToDB($_POST,$nextId); // Add the user to the database.
        $admMessage .= "<body><p>The following user was submitted for the Thompson Health Rewards system</p>";
        $admMessage .= "<table cellspacing=0 cellpadding=3 border=1>";
        $admMessage .= "<tr>";
        $admMessage .= "<td>Existing ID</td><td>" . $existingID . "</td>";
        $admMessage .= "</tr>";

        $admMessage .= "<tr>";
        $admMessage .= "<td>User ID</td><td>" . $MemberID . "</td>";
        $admMessage .= "</tr>";
        $admMessage .= "<tr>";
        $admMessage .= "<td>First Name</td><td>" . $firstname . "</td>";
        $admMessage .= "</tr>";
        $admMessage .= "<tr>";
        $admMessage .= "<td>Last Name</td><td>" . $lastName . "</td>";
        $admMessage .= "</tr>";

        $admMessage .= "<tr>";
        $admMessage .= "<td>Email Address</td><td>" . $email . "</td>";
        $admMessage .= "</tr>";

        $admMessage .= "<tr>";
        $admMessage .= "<td>Street Address</td><td>" . $streetAddress . "</td>";
        $admMessage .= "</tr>";

        $admMessage .= "<tr>";
        $admMessage .= "<td>Street Address Line 2</td><td>" . $streetAddress2 . "</td>";
        $admMessage .= "</tr>";

        $admMessage .= "<tr>";
        $admMessage .= "<td>City</td><td>" . $city . "</td>";
        $admMessage .= "</tr>";

        $admMessage .= "<tr>";
        $admMessage .= "<td>State</td><td>" . $state . "</td>";
        $admMessage .= "</tr>";

        $admMessage .= "<tr>";
        $admMessage .= "<td>Zip</td><td>" . $zip . "</td>";
        $admMessage .= "</tr>";

        $admMessage .= "<tr>";
        $admMessage .= "<td>Country</td><td>" . $country . "</td>";
        $admMessage .= "</tr>";

        $admMessage .= "<tr>";
        $admMessage .= "<td>Phone</td><td>" . $phone . "</td>";
        $admMessage .= "</tr>";

        $admMessage .= "<tr>";
        $admMessage .= "<td>Date Of Birth</td><td>" . $dob. "</td>";
        $admMessage .= "</tr>";

        $admMessage .= "<tr>";
        $admMessage .= "<td>Organization Name</td><td>" . $_POST["orgName"] . "</td>";
        $admMessage .= "</tr>";

        $admMessage .= "</table>";
        $admMessage .= "</body>";
    //  Email to Admin User for Property
        $eml->AddAddress("markmatusek74@gmail.com");
        $eml->AddAddress("zpayer@cmgms.com");
        $eml->AddAddress("Misty.Ufholz@thompsonhealth.org");
        $eml->AddAddress("margaret.fowler@thompsonhealth.org");
        $eml->FromName = "Thompson Health - Support Department - JSON ";
        $eml->From = "support@thompsonhealth.com";

        $eml->MsgHTML($admMessage);
        $eml->Subject = "Thompson Health - User submitted";
        $eml->Send();



       // $custMessage .= "<p> Congratulations, your individual member ID is  " . $MemberID . ".</p> <p>Use the link below to register and start saving today.
       //                 You will also receive a welcome email within 24 hours.</p>  <p>If you need help please contact our support line at 1-888-503-1003.</p>";
       // $eml->AddAddress($_POST["email"]);

        //$eml->MsgHTML($custMessage);
       // $eml->Subject = "Community Health Rewards Signup";
       // $eml->Send();

    }
}
else
{

    $admMessage .= "<body><p>The following user was submitted for the Thompson Health Rewards system</p>";
    $admMessage .= "<table cellspacing=0 cellpadding=3 border=1>";
    $admMessage .= "<tr>";
    $admMessage .= "<td>Existing ID</td><td>" . "TH" . str_pad($existingID, 7, '0', STR_PAD_LEFT)  . "</td>";
    $admMessage .= "</tr>";
    $admMessage .= "<tr>";
    $admMessage .= "<td>First Name</td><td>" . $firstname . "</td>";
    $admMessage .= "</tr>";
    $admMessage .= "<tr>";
    $admMessage .= "<td>Last Name</td><td>" . $lastName . "</td>";
    $admMessage .= "</tr>";

    $admMessage .= "<tr>";
    $admMessage .= "<td>Email Address</td><td>" . $email . "</td>";
    $admMessage .= "</tr>";

    $admMessage .= "<tr>";
    $admMessage .= "<td>Street Address</td><td>" . $streetAddress . "</td>";
    $admMessage .= "</tr>";

    $admMessage .= "<tr>";
    $admMessage .= "<td>Street Address Line 2</td><td>" . $streetAddress2 . "</td>";
    $admMessage .= "</tr>";

    $admMessage .= "<tr>";
    $admMessage .= "<td>City</td><td>" . $city . "</td>";
    $admMessage .= "</tr>";

    $admMessage .= "<tr>";
    $admMessage .= "<td>State</td><td>" . $state . "</td>";
    $admMessage .= "</tr>";

    $admMessage .= "<tr>";
    $admMessage .= "<td>Zip</td><td>" . $zip . "</td>";
    $admMessage .= "</tr>";

    $admMessage .= "<tr>";
    $admMessage .= "<td>Country</td><td>" . $country . "</td>";
    $admMessage .= "</tr>";

    $admMessage .= "<tr>";
    $admMessage .= "<td>Phone</td><td>" . $phone . "</td>";
    $admMessage .= "</tr>";

    $admMessage .= "<tr>";
    $admMessage .= "<td>Date Of Birth</td><td>" . $dob. "</td>";
    $admMessage .= "</tr>";

    $admMessage .= "<tr>";
    $admMessage .= "<td>Organization Name</td><td>" . $_POST["orgName"] . "</td>";
    $admMessage .= "</tr>";

    $admMessage .= "</table>";
    $admMessage .= "</body>";
//  Email to Admin User for Property
    $eml->AddAddress("markmatusek74@gmail.com");
    $eml->AddAddress("zpayer@cmgms.com");
    $eml->AddAddress("Misty.Ufholz@thompsonhealth.org");
    $eml->AddAddress("margaret.fowler@thompsonhealth.org");
    $eml->FromName = "Thompson Health - Support Department - JSON ";
    $eml->From = "support@thompsonhealth.com";

    $eml->MsgHTML($admMessage);
    $eml->Subject = "Thompson Health - USER ALREADY EXISTS ";
    $eml->Send();

  //  print $_POST["email"] . " was not imported<br />";


}

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

<?php
require("simpleXML.class.php");
require_once("classes/users.class.php");
$users = new users();

require_once("classes/phpMailer/class.phpmailer.php");
require_once("classes/phpMailer/class.smtp.php");
$eml = new PHPMailer();


require_once("includes/header.php");

$url = 'https://amt.accessdevelopment.com/api/v1/imports.xml';

// BEGIN - Variables Set for use in the XML transmission
$orgCustId = "2002214";
$programCustId = "200352";
$recordType = "MEM_SYN";
$recordIdentity = "cmng2016";
$memberStatus = "OPEN";
$nextId = $users->getLastUserID();  // Last inserted user id as int (with the chr prefix removed in query)
$nextId++; // Increment for next insert.
$MemberID =  "CHR" . str_pad($nextId, 7, '0', STR_PAD_LEFT);
// END - Variables Set for use in the XML transmission

$firstname = $_POST["First"];
$lastName = $_POST["Last"];
$streetAddress = $_POST["Address"];
$streetAddress2 = "";
$city = $_POST["City"];
$state = $_POST["State"];
$zip = $_POST["Zip"];
$country = "";
$phone = $_POST["Phone"];
$email = $_POST["Email"];
$dob = $_POST["Birthdate"];
$dobD = $_POST["Birthdate"];


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
    $admMessage .= "<body><p>The following user was submitted for the Community Health Rewards system</p>";
    $admMessage .= "<table cellspacing=0 cellpadding=3 border=1>";
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
    $eml->FromName = "Thompson Health - Support Department - JSON ";
    $eml->From = "support@thompsonhealth.com";

    $eml->MsgHTML($admMessage);
    $eml->Subject = "Thompson Health - User submitted - XML";
    $eml->Send();



   // $custMessage .= "<p> Congratulations, your individual member ID is  " . $MemberID . ".</p> <p>Use the link below to register and start saving today.
   //                 You will also receive a welcome email within 24 hours.</p>  <p>If you need help please contact our support line at 1-888-503-1003.</p>";
   // $eml->AddAddress($_POST["email"]);

    //$eml->MsgHTML($custMessage);
   // $eml->Subject = "Community Health Rewards Signup";
   // $eml->Send();

}
else
{
  //  print $_POST["email"] . " was not imported<br />";

}

?>
    <div class="container">

        <div class="welcomeMessage">
            Congratulations, your individual member ID is <? print $MemberID; ?>. Use the link below to register and start saving today.  You will also receive a welcome email within 24 hours.  If you need help please contact our support line at 1-888-503-1003.
        </div>

        <div class="wrapper">
            <div class="signup1">
                <div id="greatDealsHeader" class="deallist-header">

                    <div class="titleBar">YOUR MEMBER INFORMATION</div></div>
                <p>Thank you for applying for your Community Health Rewards member ID.  Please use the following information to register your account.<br><br>

                    <b>Register at:</b><br>
                    <a href="http://communityhealthrewards.com" target="_blank">communityhealthrewards.com</a><br><br>

                    <b>Member ID:</b><br>
                    <? print $MemberID; ?><br><br>

                    <b>E-mail Address:</b><br>
                    <? print $_POST["email"]; ?><br><br>

                    <b>Organization:</b><br>
                    <? print $_POST["orgName"]; ?>
                </p>
            </div>
            <div class="registerimg">
                <img src="http://intranet.communitymediagroup.com/demo/chrewards/registration.png" width="300px"><br>
                <div class="example">Example registration form</div>
            </div>
        </div>
    </div>

<?
require_once("includes/footer.php");
?>
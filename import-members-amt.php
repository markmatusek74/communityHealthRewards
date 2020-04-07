<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require("simpleXML.class.php");
require_once("classes/users.class.php");
$users = new users();

require_once("classes/phpMailer/class.phpmailer.php");
require_once("classes/phpMailer/class.smtp.php");
$eml = new PHPMailer();
$url = 'https://amt.accessdevelopment.com/api/v1/imports.xml';


$status = "failed";

// BEGIN - Variables Set for use in the XML transmission
$orgCustId = "2002214";
$programCustId = "200352";
$recordType = "MEM_SYN";
$recordIdentity = "cmng2016";
$memberStatus = "OPEN";

// END - Variables Set for use in the XML transmission
$formData = array();
$formData["register"] = "Y";
require_once("includes/getFilesFromTownNews.php");

//header ("Content-Type:text/xml");
if (is_dir($baseFolder)){
 //   print "base folder of: " . $baseFolder . " is a directory<br />";
    if ($dh = opendir($baseFolder)){
        while (($file = readdir($dh)) !== false){

//$path = $_FILES['image']['name'];
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            if ($ext == "csv")
            {
                $procFile = $baseFolder . "/".  $file;
                $arcFile = $archiveFolder . "/" . date('YmdHis_') .$file;
                $linecount = exec('perl -pe \'s/\r\n|\n|\r/\n/g\' ' . escapeshellarg($procFile) . ' | wc -l');
                if (($linecount > 1) && (strpos($file,'_new') !== false))
                {
                    if ((strpos($file, '5066') !== false) || (strpos($file, '5065') !== false))
                    {
                        $date = DateTime::createFromFormat('U.u', microtime(TRUE));
                        $expFilename = "cmd-ad-2199-" . date_format($date,"Ymd-Hmsu") . "-MEMBER.csv";
                  //      print "filename: " . $file .", has " . $linecount . " lines in it.<br />";

                        $row = 1;

                       $request ='<?xml version="1.0" encoding="UTF-8"?>
                                <import>
                                <members type="array">';

// Start looping of content
                     //   print $baseFolder . "<br />";
                        if (($handle = fopen($baseFolder ."/" . $file, "r")) !== FALSE) {
                            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                                if ($row > 1) {
                                    //$s->SetAccountNumber($data[8]);
                                    $firstname = $data[2];
                                    $lastName = $data[1];
                                    $phone = $data[8];
                                    $email = $data[4];
                                    $streetAddress = "";
                                    $streetAddress2 = "";
                                    $city = "";
                                    $state = "";
                                    $zip = "";
                                    $country = "";
                                    $formData["fname"] = $firstname;
                                    $formData['lname'] = $lastName;
                                    $formData['email'] = $email;
                                    $formData["orgName"] = "";
                                    $existingID = $users->checkForExistingAccount($email);
                                    $accountType = ($existingID > 0 ) ? "existing" : "new";

                                    if ($accountType == "new")
                                    {
                                        $nextId = $users->getLastUserID();  // Last inserted user id as int (with the chr prefix removed in query)
                                        $nextId++; // Increment for next insert.print "org customer ID: " . $orgCustId . "<br />";

                                        $MemberID =  "CHR" . str_pad($nextId, 7, '0', STR_PAD_LEFT);
                                        $users->addUserToDB($formData,$nextId);

                                  //  print "account type: " . $accountType . "<br />";
                                     $request .= '<member>
                                         <organization-customer-identifier>' . $orgCustId . '</organization-customer-identifier>
                                         <program-customer-identifier>' .$programCustId . '</program-customer-identifier>
                                         <full_name>' . $firstname . ' ' . $lastName . '</full_name>
                                         <first-name>' . $firstname . '</first-name>
                                         <last-name>' . $lastName . '</last-name>
                                         <email-address>' . $email . '</email-address>
                                         <street_line1>' . $streetAddress . '</street_line1>
                                         <street_line2>' . $streetAddress2 . '</street_line2>
                                         <city>' . $city . '</city>
                                         <state>' . $state . '</state>
                                         <postal_code>' . $zip . '</postal_code>
                                         <country>' . $country . '</country>
                                         <phone_number>' . $phone . '</phone_number>

                                         <member-customer-identifier>' . $MemberID . '</member-customer-identifier>
                                         <member-status>' . $memberStatus . '</member-status>
                                         <record-identifier>' . $recordIdentity . '</record-identifier>
                                         <record-type>' . $recordType . '</record-type>
                                         </member>';
                                    }
                                }
                                $row++;
                            }
                            // print "Total Rows: " . $row . "<br />";
                            //fclose($handle);
                               $request .= '
   </members>
   </import>';

                        }
                      //  print_r($formData);
                        print "<br />" . $request . "<br />";

                        //include_once("includes/uploadToAccess.php");
                     //   echo 'courier express<br />';
                    }
                    else
                    {
                      //  print "not sure<br />";
                    }
                    rename($procFile, $arcFile);

                }
                else
                {
                    unlink($procFile);
                }
            }
        }
    }
}

?>
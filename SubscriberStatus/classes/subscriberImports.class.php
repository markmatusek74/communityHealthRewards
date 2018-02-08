<?php
ini_set('auto_detect_line_endings', true);
/**
 * Created by JetBrains PhpStorm.
 * User: MarkMatusek74
 * Date: 7/9/16
 * Time: 10:21 PM
 * To change this template use File | Settings | File Templates.
 */
require_once("Subscriber.class.php");
require_once("accessDev.class.php");
class subscriberImports extends Subscriber  {
    public $Publication;
    public $AccountNumber;

    function __construct()
    {
    }

    public function mapSubscriberToAccess($s,$aDev)
    {
        //$aDev = new accessDev();
        //$s = new Subscriber();
        $aDev->SetAccountNumber($s->GetAccountNumber());
        $aDev->SetRecordType($s->GetRecordType());
        $aDev->SetFirstName($s->GetFirstName());
        $aDev->SetMiddleName($s->GetMiddleName());
        $aDev->SetLastName($s->GetLastName());
        $aDev->SetAddressLine1($s->GetAddressLine1());
        $aDev->SetAddressLine2($s->GetAddressLine2());
        $aDev->SetCity($s->GetCity());
        $aDev->SetState($s->GetState());
        $aDev->SetPostalCode($s->GetPostalCode());
        $aDev->SetCountry($s->GetCountry());
        $aDev->SetPhone($s->GetPhone());
        $aDev->SetEmailAddress($s->GetEmailAddress());
        $aDev->SetMembershipRenewalDate($s->GetMembershipRenewalDate);
        $aDev->SetProductIdentifier($s->GetProductIdentifier);
        $aDev->SetFullName($s->GetFullName);

    }
    private function WriteFileContents($aDev)
    {

        //$aDev = new accessDev();

        //$aDev->SetCSVHeaders( "\"recordIdentifier\",\"recordType\",\"organizationcustomeridentifier\",\"programCustomerIdentifier\",
        //\"membercustomeridentifier\",\"memberStatus\",\"firstName\",\"middleName\",\"lastName\",\"streetLine1\",\"streetLine2\",\"city\",\"state\",\"postalCode\"
        //,\"country\",\"phoneNumber\",\"emailAddress\"\n");

        $fileContents = "";
        $fileContents .= "\"" .  $aDev->GetOrganizationCustomerID()
            .  "\",\"" . $aDev->GetProgramCustomerIDentifier() . "\",\"" . $aDev->GetAccountNumber() . "\",\"" . $aDev->GetMemberStatus()
            . "\",\"" .  $aDev->GetFullName() . "\",\"" .
            $aDev->GetFirstName() . "\",\"" . $aDev->GetMiddleName() . "\",\"" . $aDev->GetLastName() . "\",\"" . $aDev->GetAddressLine1() . "\",\"" .
            $aDev->GetAddressLine2() . "\",\"" . $aDev->GetCity() . "\",\"" . $aDev->GetState() . "\",\"" .
            $aDev->GetPostalCode() . "\",\"" . $aDev->GetCountry()  . "\",\"" . $aDev->GetPhone()  . "\",\"" .$aDev->GetEmailAddress()  . "\",\"" .
            $aDev->GetMembershipRenewalDate() . "\",\"" . $aDev->GetProductIdentifier() ."\"\n";

        return $fileContents;
    }
    public function impCourierExpress($dir, $file)
    {
        $aDev = new accessDev();
        $fileContents = "";
        $s = new Subscriber();
        $row = 1;
        if (($handle = fopen($dir . $file, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                if ($row > 1 )
                {
                    $s->SetAccountNumber($data[8]);
                    $s->SetFirstName(($data[2]));
                    $s->SetLastName($data[1]);
                    $s->SetPhone($data[8]);
                    $s->SetEmailAddress($data[4]);
                    self::mapSubscriberToAccess($s,$aDev);
                    $fileContents .= self::WriteFileContents($aDev);
                }
                $row++;
            }
           // print "Total Rows: " . $row . "<br />";
            fclose($handle);
        }
        return $fileContents;
    }

    public function impHartfordCityNewsTimes($dir, $file)
    {
        $aDev = new accessDev();
        $fileContents = "";
        $s = new Subscriber();
        $row = 1;
        if (($handle = fopen($dir . $file, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {

                if ($row > 2 )
                {
                    $s->SetAccountNumber($data[2]);
                    $s->SetFirstName(($data[3]));
                    $s->SetLastName($data[4]);
                    $s->SetPhone($data[5]);
                    self::mapSubscriberToAccess($s,$aDev);
                    $fileContents .= self::WriteFileContents($aDev);
                }
                $row++;
            }
            // print "Total Rows: " . $row . "<br />";
            fclose($handle);
        }
        return $fileContents;
    }


    public function impWinchesterNewsGazette($dir, $file)
    {
        $aDev = new accessDev();
        $fileContents = "";
        $s = new Subscriber();
        $row = 1;
        if (($handle = fopen($dir . $file, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                if ($row > 2 )
                {
                    $s->SetAccountNumber($data[2]);
                  //  $s->SetAddressLine1($data[2]);
                    $s->SetFirstName($data[3]);
                    $s->SetLastName($data[4]);
                    $s->SetPhone($data[5]);
                   // $s->SetEmailAddress(trim($data[5]));

                  //  print "Account Number: " . $s->GetAccountNumber() . "<br />";
                   // print "First Name: " . $s->GetFirstName() . "<br />";
                   // print "Last Name: " . $s->GetLastName() . "<br />";
                   // print "Phone #: " . $s->GetPhone() . "<br />";
                    //print "Email Address: " . $s->GetEmailAddress() . "<br />";
                   // print "<br />";
                    self::mapSubscriberToAccess($s,$aDev);
                    $fileContents .= self::WriteFileContents($aDev);
                }
                $row++;
            }
            // print "Total Rows: " . $row . "<br />";
            fclose($handle);
        }
        return $fileContents;
    }

}
<?php
/**
 * Created by JetBrains PhpStorm.
 * User: MarkMatusek74
 * Date: 7/9/16
 * Time: 10:21 PM
 * To change this template use File | Settings | File Templates.
 */

require_once("imports.class.php");

class accessDev {

    private $MemberStatus = "OPEN";
    private $OrganizationCustomerID = "2002214";
    private $ProgramCustomerIDentifier = "200566";
    private $Filename;
    private $FileContents;
    private $RecordIdentifier;
    private $RecordType;
    private $AccountNumber;
    private $FirstName;
    private $MiddleName;
    private $LastName;
    private $AddressLine1;
    private $AddressLine2;
    private $City;
    private $State;
    private $PostalCode;
    private $Country;
    private $Phone;
    private $EmailAddress;
    private $CSVHeaders;
    private $BaseFolder;
    private $UploadFolder;
    private $membershipRenewalDate;
    private $ProductIdentifier;
    private $FullName;

    public function SetFullName($FullName)
    {
        $this->FullName = $FullName;
    }

    public function GetFullName()
    {
        return $this->FullName;
    }


    public function SetProductIdentifier($ProductIdentifier)
    {
        $this->ProductIdentifier = $ProductIdentifier;
    }

    public function GetProductIdentifier()
    {
        return $this->ProductIdentifier;
    }


    public function SetMembershipRenewalDate($membershipRenewalDate)
    {
        $this->membershipRenewalDate = $membershipRenewalDate;
    }

    public function GetMembershipRenewalDate()
    {
        return $this->membershipRenewalDate;
    }


    public function SetProgramCustomerIDentifier($ProgramCustomerIDentifier)
    {
        $this->ProgramCustomerIDentifier = $ProgramCustomerIDentifier;
    }

    public function GetProgramCustomerIDentifier()
    {
        return $this->ProgramCustomerIDentifier;
    }

    public function SetUploadFolder($UploadFolder)
    {
        $this->UploadFolder = $UploadFolder;
    }

    public function GetUploadFolder()
    {
        return $this->UploadFolder;
    }

    public function SetMemberStatus($MemberStatus)
    {
        $this->MemberStatus = $MemberStatus;
    }

    public function GetMemberStatus()
    {
        return $this->MemberStatus;
    }

    public function SetOrganizationCustomerID($OrganizationCustomerID)
    {
        $this->OrganizationCustomerID = $OrganizationCustomerID;
    }

    public function GetOrganizationCustomerID()
    {
        return $this->OrganizationCustomerID;
    }

    public function SetEmailAddress($EmailAddress)
    {
        $this->EmailAddress = $EmailAddress;
    }

    public function GetEmailAddress()
    {
        return $this->EmailAddress;
    }


    public function SetRecordIdentifier($RecordIdentifier)
    {
        $this->RecordIdentifier = $RecordIdentifier;
    }

    public function GetRecordIdentifier()
    {
        return $this->RecordIdentifier;
    }

    public function SetRecordType($RecordType)
    {
        $this->RecordType = $RecordType;
    }

    public function GetRecordType()
    {
        return $this->RecordType;
    }

    public function SetAccountNumber($AccountNumber)
    {
        $this->AccountNumber = $AccountNumber;
    }

    public function GetAccountNumber()
    {
        return $this->AccountNumber;
    }

    public function SetFirstName($FirstName)
    {
        $this->FirstName = $FirstName;
    }

    public function GetFirstName()
    {
        return $this->FirstName;
    }

    public function SetMiddleName($MiddleName)
    {
        $this->MiddleName = $MiddleName;
    }

    public function GetMiddleName()
    {
        return $this->MiddleName;
    }

    public function SetLastName($LastName)
    {
        $this->LastName = $LastName;
    }

    public function GetLastName()
    {
        return $this->LastName;
    }

    public function SetAddressLine1($AddressLine1)
    {
        $this->AddressLine1 = $AddressLine1;
    }

    public function GetAddressLine1()
    {
        return $this->AddressLine1;
    }

    public function SetAddressLine2($AddressLine2)
    {
        $this->AddressLine2 = $AddressLine2;
    }

    public function GetAddressLine2()
    {
        return $this->AddressLine2;
    }

    public function SetCity($City)
    {
        $this->City = $City;
    }

    public function GetCity()
    {
        return $this->City;
    }

    public function SetState($State)
    {
        $this->State = $State;
    }

    public function GetState()
    {
        return $this->State;
    }

    public function SetPostalCode($PostalCode)
    {
        $this->PostalCode = $PostalCode;
    }

    public function GetPostalCode()
    {
        return $this->PostalCode;
    }

    public function SetCountry($Country)
    {
        $this->Country = $Country;
    }

    public function GetCountry()
    {
        return $this->Country;
    }

    public function SetPhone($Phone)
    {
        $this->Phone = $Phone;
    }

    public function GetPhone()
    {
        return $this->Phone;
    }

    public function SetFilename($Filename)
    {
        $this->Filename = $Filename;
    }

    public function GetFilename()
    {
        return $this->Filename;
    }

    public function SetFileContents($FileContents)
    {
        $this->FileContents = $FileContents;
    }

    public function GetFileContents()
    {
        return $this->FileContents;
    }


    public function SetCSVHeaders($CSVHeaders)
    {
        $this->CSVHeaders = $CSVHeaders;
    }

    public function GetCSVHeaders()
    {
        return $this->CSVHeaders;
    }

    public function SetBaseFolder($BaseFolder)
    {
        $this->BaseFolder = $BaseFolder;
    }

    public function GetBaseFolder()
    {
        return $this->BaseFolder;
    }



    function __construct()
    {
    }

    public function getSubscriberCSV()
    {
        $dir = $_SERVER["DOCUMENT_ROOT"] . "/SubscriberStatus/accessDev/";
        $filename = "cmd-ad-2199-" . date("Ymd-Hms") . "-MEMBER.csv";
        $this->Filename = "cmd-ad-2199-" . date("Ymd-Hms") . "-MEMBER.csv";
        $imp = new imports();
        $fline = "";
        $subs = $imp->getSubscriberData();
        $headers = "yes";
        if ($headers == "yes")
        {
//            $this->CSVHeaders =  "\"recordIdentifier\",\"recordType\",\"organizationcustomeridentifier\",\"programCustomerIdentifier\",\"membercustomeridentifier\",\"memberStatus\",\"firstName\",\"middleName\",\"lastName\",\"streetLine1\",\"streetLine2\",\"city\",\"state\",\"postalCode\",\"country\",\"phoneNumber\",\"emailAddress\"";
            $this->CSVHeaders =  "\"organizationcustomeridentifier\",\"programCustomerIdentifier\",\"membercustomeridentifier\",\"memberStatus\",\"fullName\",\"firstName\",\"middleName\",\"lastName\",\"streetLine1\",\"streetLine2\",\"city\",\"state\",\"postalCode\",\"country\",\"phoneNumber\",\"emailAddress\",\"membershipRenewalDate\",\"productIdentifier\"";

        }
        foreach ($subs as  $isub) {
            $recordIdentifier = "";
            $recordType = "";
            $orgCustID = "2002214";
            $memberCustID = $isub["Account"];
            $memberStatus = "OPEN";
            $fName = $isub["FirstName"];
            $middleName = "";
            $lName = $isub["LastName"];
            $fullName = $fName . " " . $lName;
            $state = "";
            $postalCode = "";
            $country = "";
            $phone = $isub["Phone"];
            $emailAddress = "";
            $membershipRenewalDate = "";
            $productIdentifier = "";
            //print "Name is: " . $fName . ", " . $lName . "\n";
            $fline .= "\"" . $orgCustID . "\",\"" . $memberCustID . "\",\"" . $memberStatus . "\",\"" . $fullName . "\",\"" .
                $fName . "\",\"" . $middleName . "\",\"" . $lName . "\",\"" . $street1 . "\",\"" . $street2 . "\",\"" . $city . "\",\"" . $state . "\",\"" .
                $postalCode . "\",\"" . $country . "\",\"" . $phone . "\",\"" . $emailAddress . "\",\"" . $membershipRenewalDate . "\",\"" . $productIdentifier . "\n";

            // $arr[3] will be updated with each value from $arr...
            //echo "Account: " . $isub["Account"] . "<br /> ";
            //  print_r($arr);

        }

        file_put_contents($dir . $filename,$fline);
        return $filename;
    }

    public function WriteCSV()
    {
      /*  print "upload folder: " . $this->GetUploadFolder() . "<br />";
        print "filename: " . $this->Filename . "<br />";
        print "file contents: " . $this->GetFileContents() . "<br />";
      */
        file_put_contents($this->GetUploadFolder() . $this->Filename,$this->GetFileContents());
    }
}
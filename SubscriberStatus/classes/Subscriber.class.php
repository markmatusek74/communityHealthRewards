<?php
/**
 * Created by JetBrains PhpStorm.
 * User: MarkMatusek74
 * Date: 7/9/16
 * Time: 10:21 PM
 * To change this template use File | Settings | File Templates.
 */



class Subscriber {

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
        
    public function SetEmailAddress($EmailAddress)
    {
        $this->EmailAddress = $EmailAddress;
    }

    public function GetEmailAddress()
    {
        return $this->EmailAddress;
    }

}
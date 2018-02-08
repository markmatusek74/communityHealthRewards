<?php
/**
 * Created by JetBrains PhpStorm.
 * User: MarkMatusek74
 * Date: 7/9/16
 * Time: 10:21 PM
 * To change this template use File | Settings | File Templates.
 */

require_once("database.class.php");
require_once("phpMailer/class.phpmailer.php");
require_once("phpMailer/class.smtp.php");



class users {

    function __construct()
    {
        $this->db = database::connnectToDB();
    }


    public function addUserToDB(array $formData, $user_id)
    {
        $eml = new PHPMailer();
        $user_id = "TH" . str_pad($user_id, 7, '0', STR_PAD_LEFT);

            $firstname = $formData["First"];
            $lastName = $formData["Last"];
            $streetAddress = $formData["Address"];
            $streetAddress2 = "";
            $city = $formData["City"];
            $state = $formData["State"];
            $zip = $formData["Zip"];
            $country = "";
            $phone = $formData["Phone"];
            $email = $formData["Email"];
            $dob = $formData["Birthdate"];
            $dobD = $formData["Birthdate"];
            $orgName = "";
            /*
            $firstname = $formData['dnn$ctr3561$View$Fullname_3561_1_FirstName'];
            $lastName = $formData['dnn$ctr3561$View$Fullname_3561_1_LastName'];
            $streetAddress = $formData['dnn$ctr3561$View$Address_3561_2_StreetAddress'];
            $streetAddress2 = $formData['dnn$ctr3561$View$Address_3561_2_StreetAddressLine2'];
            $city = $formData['dnn$ctr3561$View$Address_3561_2_City'];
            $state = $formData['dnn$ctr3561$View$Address_3561_2_StateProvince'];
            $zip = $formData['dnn$ctr3561$View$Address_3561_2_PostalZipCode'];
            $country = $formData['dnn$ctr3561$View$Address_3561_2_Country'];
            $phone = "(" . $formData['dnn$ctr3561$View$Phone_3561_3'] . ")" . $formData['dnn$ctr3561$View$Phone_3561_3_PhoneNo'];
            $email = $formData['dnn$ctr3561$View$Email_3561_4'];
            $dob = $formData['dnn$ctr3561$View$Birthdate_3561_5_Month'] . "/" . $formData['dnn$ctr3561$View$Birthdate_3561_5'] . "/" . $formData['dnn$ctr3561$View$Birthdate_3561_5_Year'];
            $orgName = "";
       */
            $OK = false;
            $conn = $this->db;
            $sql = "INSERT INTO th_users (user_id, first_name, last_name, email_address, organization_name, ip_address,
                    Street_Address, Street_Address2, City, State, Zip, Country, Phone, DOB)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->stmt_init();
            if ($stmt->prepare($sql))
            {
                // bind parameters and execute statment
                $stmt->bind_param('ssssssssssssss', $user_id, $firstname, $lastName,  $email, $orgName, $_SERVER['REMOTE_ADDR'], $streetAddress, $streetAddress2, $city, $state, $zip, $country, $phone, $dob);
                $OK = $stmt->execute();
            }
            if ($OK)
            {
//                header('Location: http://www.matusek.com/budget/view.php?asset=category');
//                exit;
            }
            else
            {
                $eml->AddAddress("markmatusek74@gmail.com");
                $eml->FromName = "Thompson Health - Support Department - Error Email ";
                $eml->From = "support@thompsonhealth.com";

                $eml->MsgHTML($stmt->error);
                $eml->Subject = "Thompson Health - User submitted";
                $eml->Send();

            }

    }


    public function addUserFormSubmission(array $formData, $user_id, $accountType)
    {
        $eml = new PHPMailer();

        $firstname = $formData["First"];
        $lastName = $formData["Last"];
        $streetAddress = $formData["Address"];
        $city = $formData["City"];
        $state = $formData["State"];
        $zip = $formData["Zip"];
        $country = "";
        $phone = $formData["Phone"];
        $email = $formData["Email"];
        $dob = $formData["Birthdate"];

        $OK = false;
        $conn = $this->db;
        $sql = "INSERT INTO th_form_submissions (user_id, first_name, last_name, email_address,
                    street_address, city, state, zip, phone, dob, account_type)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->stmt_init();
        if ($stmt->prepare($sql))
        {
            // bind parameters and execute statment
            $stmt->bind_param('sssssssssss', $user_id, $firstname, $lastName,  $email,  $streetAddress,  $city, $state, $zip, $phone, $dob, $accountType);
            $OK = $stmt->execute();
        }
        if ($OK)
        {
//                header('Location: http://www.matusek.com/budget/view.php?asset=category');
//                exit;
        }
        else
        {
            $eml->AddAddress("markmatusek74@gmail.com");
            $eml->FromName = "Thompson Health - Support Department - Error Email - Form Submission ";
            $eml->From = "support@thompsonhealth.com";

            $eml->MsgHTML($stmt->error);
            $eml->Subject = "Thompson Health - User submission error";
            $eml->Send();

        }

    }


    public function getLastUserID()
    {
        $conn = $this->db;
        $sql = "SELECT id, REPLACE(user_id, 'TH','') as user_id FROM `th_users` ORDER BY id DESC LIMIT 1";
        $result = $conn->query($sql) or die(mysqli_error());
        while($row = $result->fetch_assoc())
        {
            $lastID = (int)$row['user_id'];
        }
        return $lastID;
    }

    public function checkForExistingAccount($email)
    {
        $lastID = 0;
        $conn = $this->db;
        $sql = "SELECT id, REPLACE(user_id, 'TH','') as user_id FROM `th_users` where email_address LIKE  '%" . $email . "%'";
        $result = $conn->query($sql) or die(mysqli_error());
        while($row = $result->fetch_assoc())
        {
            $lastID = (int)$row['user_id'];
        }
        return $lastID;

    }

    public function getUserData($RecordId=NULL)
    {
        if ($RecordId)
        {
            $qWhere = " WHERE id = '" . $RecordId . "' ";
        }
        $conn = $this->db;
        $sql = "SELECT id, user_id, first_name, last_name, email_address, organization_name, create_date, ip_address
                FROM th_users $qWhere ORDER BY last_name, first_name, email_address";

        //print $sql . "<br />";
        $result = $conn->query($sql) or die(mysqli_error());
        $counter = 0;
        while($row = $result->fetch_assoc())
        {
            $chrItem[$counter]["id"] = $row['id'];
            $chrItem[$counter]["UserID"] = $row['user_id'];
            $chrItem[$counter]["FirstName"] = $row['first_name'];
            $chrItem[$counter]["LastName"] = $row['last_name'];
            $chrItem[$counter]["EmailAddress"] = $row['email_address'];
            $chrItem[$counter]["OrganizationName"] = $row['organization_name'];
            $chrItem[$counter]["CreateDate"] = $row['create_date'];
            $chrItem[$counter]["IPAddress"] = $row['ip_address'];
            $counter++;
        }
        return $chrItem;
    }

}
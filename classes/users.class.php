<?php
/**
 * Created by JetBrains PhpStorm.
 * User: MarkMatusek74
 * Date: 7/9/16
 * Time: 10:21 PM
 * To change this template use File | Settings | File Templates.
 */

require_once("database.class.php");

class users {

    function __construct()
    {
        $this->db = database::connnectToDB();
    }


    public function addUserToDB(array $formData, $user_id)
    {
        $user_id = "CHR" . str_pad($user_id, 7, '0', STR_PAD_LEFT);
        if (array_key_exists('register', $formData))
        {
            $OK = false;
            $conn = $this->db;
            $sql = "INSERT INTO chr_users (user_id, first_name, last_name, email_address, organization_name, ip_address)
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->stmt_init();
            if ($stmt->prepare($sql))
            {
                // bind parameters and execute statment
                $stmt->bind_param('ssssss', $user_id, $formData['fname'], $formData['lname'],  $formData['email'], $formData["orgName"], $_SERVER['REMOTE_ADDR']);
                $OK = $stmt->execute();
            }
            if ($OK)
            {
//                header('Location: http://www.matusek.com/budget/view.php?asset=category');
//                exit;
            }
            else
            {
                echo $stmt->error;
            }
        }

    }


    public function getLastUserID()
    {
        $conn = $this->db;
        $sql = "SELECT id, REPLACE(user_id, 'CHR','') as user_id FROM `chr_users` ORDER BY id DESC LIMIT 1";
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
                FROM chr_users $qWhere ORDER BY last_name, first_name, email_address";
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
<?php
/**
 * Created by JetBrains PhpStorm.
 * User: MarkMatusek74
 * Date: 7/9/16
 * Time: 10:21 PM
 * To change this template use File | Settings | File Templates.
 */

require_once("database.class.php");

class imports {

    function __construct()
    {
       // $this->db = database::connnectToDB();
    }


    public function importRecord($account,$firstName,$lastName,$phone)
    {

        $OK = false;
        $conn = $this->db;
        $sql = "INSERT INTO Subscriber_Export (Account,FirstName, LastName,Phone)
                    VALUES (?, ?, ?, ?)";
        $stmt = $conn->stmt_init();
        if ($stmt->prepare($sql))
        {
            // bind parameters and execute statment
            $stmt->bind_param('ssss', $account, $firstName, $lastName,  $phone);
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


    public function truncateData()
    {

        $OK = false;
        $conn = $this->db;
        $sql = "TRUNCATE Subscriber_Export ";
        $stmt = $conn->stmt_init();
        if ($stmt->prepare($sql))
        {
            // bind parameters and execute statment
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

    public function getSubscriberData($RecordId=NULL)
    {
        if ($RecordId)
        {
            $qWhere = " WHERE id = '" . $RecordId . "' ";
        }
        $conn = $this->db;
        $sql = "SELECT Account, FirstName, LastName, Phone
                FROM Subscriber_Export $qWhere ";
        $result = $conn->query($sql) or die(mysqli_error());
        $counter = 0;
        while($row = $result->fetch_assoc())
        {
            $chrItem[$counter]["Account"] = $row['Account'];
            $chrItem[$counter]["FirstName"] = $row['FirstName'];
            $chrItem[$counter]["LastName"] = $row['LastName'];
            $chrItem[$counter]["Phone"] = $row['Phone'];
            $counter++;
        }
        return $chrItem;
    }



}
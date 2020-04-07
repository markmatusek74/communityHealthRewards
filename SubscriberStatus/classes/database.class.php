<?php
/**
 * Created by PhpStorm.
 * User: markmatusek
 * Date: Jan 9, 2011
 * Time: 9:01:14 PM
 * To change this template use File | Settings | File Templates.
 */

class database {

    public static function connnectToDB()
    {
        $mysqli = new mysqli("67.227.135.216", "wwwldn_ldndb", "ldn01pass2");
        $mysqli->select_db("wwwCommHealthRewards");
        if($mysqli->errno)
        {
            printf("Unable to connect to database:</br /> %s", $mysqli->error);
            exit();
        }
        else
        {
            return $mysqli;
        }

    }


    public static function getDataFromUsersTable()
    {
        self::connnectToDB();
        $result = mysql_query("SELECT * FROM chr_users");

        if (!$result)
        {
            echo 'Could not run query: ' . mysql_error();
            exit;
        }
        if (mysql_num_rows($result) > 0)
        {
            while ($row = mysql_fetch_assoc($result))
            {
                print_r($row);
            }
        }
    }
}
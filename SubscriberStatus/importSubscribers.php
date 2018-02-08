<?php
require_once("classes/accessDev.class.php");
require_once("classes/subscriberImports.class.php");
$aDev = new accessDev();
$imp = new imports();
$subImp = new subscriberImports();

$baseFolder = $_SERVER["DOCUMENT_ROOT"] . "/SubscriberStatus/uploads/tnsite";
$archiveFolder = $_SERVER["DOCUMENT_ROOT"] . "/SubscriberStatus/uploads/archive";

$ftp_server    = "ftp-chicago2.bloxcms.com";
$user          = '2586';
$password      = 'D4492Xtf';
$document_root = '//';
$sync_path     = 'dir2copy';
chdir("uploads/tnsite");
$conn_id = ftp_connect($ftp_server);
if ($conn_id) {
    $login_result = ftp_login($conn_id, $user, $password);
    ftp_pasv($conn_id, true);
    if ($login_result) {
        ftp_sync(".");
        ftp_close($conn_id);
    } else {
        echo 'login to server failed!' . PHP_EOL;
    }
} else {
    echo 'connection to server failed!';
}
function ftp_sync ($dir) {

    global $conn_id;

    if ($dir != ".") {
        if (ftp_chdir($conn_id, $dir) == false) {
            echo ("Change Dir Failed: $dir<BR>\r\n");
            return;
        }
        if (!(is_dir($dir)))
            mkdir($dir);
        chdir ($dir);
    }

    $contents = ftp_nlist($conn_id, ".");
    foreach ($contents as $file) {

        if ($file == '.' || $file == '..')
            continue;

        if (@ftp_chdir($conn_id, $file)) {
            ftp_chdir ($conn_id, "..");
            ftp_sync ($file);
        }
        else
            ftp_get($conn_id, $file, $file, FTP_BINARY);
    }

    ftp_chdir ($conn_id, "..");
    chdir ("..");

}
$aDev->SetCSVHeaders( "\"organizationcustomeridentifier\",\"programCustomerIdentifier\",\"membercustomeridentifier\",\"memberStatus\",\"fullName\",\"firstName\",\"middleName\",\"lastName\",\"streetLine1\",\"streetLine2\",\"city\",\"state\",\"postalCode\",\"country\",\"phoneNumber\",\"emailAddress\",\"membershipRenewalDate\",\"productIdentifier\"\n");

if (is_dir($baseFolder)){
    print "base folder of: " . $baseFolder . " is a directory<br />";
    if ($dh = opendir($baseFolder)){
        while (($file = readdir($dh)) !== false){

//$path = $_FILES['image']['name'];
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            if ($ext == "csv")
            {
                $procFile = $baseFolder . "/".  $file;
                $arcFile = $archiveFolder . "/" . date('YmdHis_') .$file;
                $linecount = exec('perl -pe \'s/\r\n|\n|\r/\n/g\' ' . escapeshellarg($procFile) . ' | wc -l');
                if ($linecount > 1)
                {
                    if ((strpos($file, '5066') !== false) || (strpos($file, '5065') !== false))
                    {
                        $date = DateTime::createFromFormat('U.u', microtime(TRUE));
                        $expFilename = "cmd-ad-2199-" . date_format($date,"Ymd-Hmsu") . "-MEMBER.csv";
                        print "filename: " . $file .", has " . $linecount . " lines in it.<br />";
                        $aDev->SetUploadFolder($_SERVER["DOCUMENT_ROOT"] . "/SubscriberStatus/accessDev/courier_express/");
                        $aDev->SetFilename($expFilename);
                        print "filename is: " . $expFilename . "<br />";
                        $fileContent = $aDev->GetCSVHeaders();
                        $fileContent .= $subImp->impCourierExpress($baseFolder. "/",$file);
                        $aDev->SetFileContents($fileContent);
                        $aDev->WriteCSV();

                        echo 'courier express<br />';
                    }
                    else
                    {
                        print "not sure<br />";
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

echo 'done.' . PHP_EOL;?>

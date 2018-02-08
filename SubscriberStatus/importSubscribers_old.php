<?php
require_once("classes/accessDev.class.php");
require_once("classes/subscriberImports.class.php");
$aDev = new accessDev();
$imp = new imports();
$subImp = new subscriberImports();
//$imp->truncateData();
$baseFolder = $_SERVER["DOCUMENT_ROOT"] . "/SubscriberStatus/uploads/tnsite";
$dirArr = array("courier_express","hartford_city_news_times","winchester_news_gazette" );


$handle = opendir('ftp://2586:D4492Xtf@ftp-chicago2.bloxcms.com') || die();

while (false !== ($file = readdir($handle))) {
    if(is_file($file)){
        $c = file_get_contents($file);
        file_put_contents($baseFolder .basename($file), $c);
    }
}

closedir($handle);

exit;

$aDev->SetCSVHeaders( "\"organizationcustomeridentifier\",\"programCustomerIdentifier\",\"membercustomeridentifier\",\"memberStatus\",\"fullName\",\"firstName\",\"middleName\",\"lastName\",\"streetLine1\",\"streetLine2\",\"city\",\"state\",\"postalCode\",\"country\",\"phoneNumber\",\"emailAddress\",\"membershipRenewalDate\",\"productIdentifier\"\n");
foreach ($dirArr as $f)
{

    print "current directory is " . $f . "<br />";
    // Open a directory, and read its contents
    $dir = $baseFolder . $f . "/";
    $fileCount = 0;
    if (is_dir($dir)){
        if ($dh = opendir($dir)){
            while (($file = readdir($dh)) !== false){
                //$path = $_FILES['image']['name'];
                $ext = pathinfo($file, PATHINFO_EXTENSION);
                if ($ext == "csv")
                {
                    $aDev->SetFilename("cmd-ad-2199-" . date("Ymd-Hms") . "-MEMBER.csv");
                    echo "filename:" . $aDev->GetFilename() . "<br>";
                    if ($f == "courier_express")
                    {
                        $aDev->SetUploadFolder($_SERVER["DOCUMENT_ROOT"] . "/SubscriberStatus/accessDev/courier_express/");
                        $fileContent = $aDev->GetCSVHeaders();
                        $fileContent .= $subImp->impCourierExpress($dir,$file);
                        $aDev->SetFileContents($fileContent);
                        $aDev->WriteCSV();
                      //  $filname = $aDev->getSubscriberCSV();ow
                    }
                    else if ($f == "hartford_city_news_times")
                    {
                        $aDev->SetUploadFolder($_SERVER["DOCUMENT_ROOT"] . "/SubscriberStatus/accessDev/hartford_city_news_times/");
                        $fileContent = $aDev->GetCSVHeaders();
                        $fileContent .= $subImp->impHartfordCityNewsTimes($dir,$file);
                        $aDev->SetFileContents($fileContent);
                        $aDev->WriteCSV();
                    }
                    else if ($f == "winchester_news_gazette")
                    {
                        $aDev->SetUploadFolder($_SERVER["DOCUMENT_ROOT"] . "/SubscriberStatus/accessDev/" . $f . "/");

                        $fileContent = $aDev->GetCSVHeaders();
                        $fileContent .= $subImp->impWinchesterNewsGazette($dir,$file);
                        $aDev->SetFileContents($fileContent);
                        $aDev->WriteCSV();
                        print "Winchester filename: " . $aDev->GetFilename() . "<br />";
                    }
                    $fileCount++;
                }
            }
            closedir($dh);
        }
        print "Processed " . $fileCount . " file(s) for " . $dir . ".<br />";
    }
}
exit;


// PGP Encrypt the file.
putenv("GNUPGHOME=/tmp");

// it assumes public key exists in the /tmp/keys folder
$publicKey = file_get_contents(getenv('GNUPGHOME') . '/keys/public.key');

$gpg = new gnupg();
$gpg->seterrormode(gnupg::ERROR_EXCEPTION);
$info = $gpg->import($publicKey);
$gpg->addencryptkey($info['fingerprint']);

$uploadFileContent = file_get_contents('/tmp/file-to-encrypt');
$enc = $gpg->encrypt($uploadFileContent);
echo $enc
?>

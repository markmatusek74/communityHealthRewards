<?php
$baseFolder = $_SERVER["DOCUMENT_ROOT"] . "/uploads/tnsite";
$archiveFolder = $_SERVER["DOCUMENT_ROOT"] . "//uploads/archive";

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
?>
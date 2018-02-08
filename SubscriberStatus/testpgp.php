<?php
$gpg = '/usr/bin/gpg';
print "got to line 3";
$recipient = "markmatusek74@gmail.com";
$secret_file = "testpgp.php";

echo shell_exec("$gpg -e -r $recipient $secret_file");
print "<br />got to end";
exit;
// get list of keys containing string 'example'

?>
<?php
set_include_path(get_include_path() . PATH_SEPARATOR . '/web/groups/strat/TSCreator_Website/lib/php/');
include('Net/SSH2.php');

$ssh = new Net_SSH2('msee288lnx01.ecn.purdue.edu');
if (!$ssh->login('strat', 'qt2wQpJKiawRUj9V')) {
	exit('Password for ssh login is incorrect. Login Failed');
}
$ssh->exec('rm -rf /web/groups/strat/private/tsclite/server_new_settings/*');
$ssh->exec('rm -rf /web/groups/strat/private/tsclite/server_pdf_output/*');
$ssh->exec('rm -rf /web/groups/strat/private/tsclite/server_pdf_temp/*');
$ssh->exec('rm -rf /web/groups/strat/private/tsclite/server_temp_settings/*');
$ssh->exec('rm -rf /web/groups/strat/private/tsclite/server_used_settings/*');
?>
<html>
<title>TSCreator Cache Clearance</title>
<body>
<h3>TSCLite server cache (old images, settings) is cleared successfully.</h3>
<h3><a href="index.php">Go back to TSCLite</a></h3><br>
</body>
</html>

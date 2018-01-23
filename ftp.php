<?php
function ftpFile($source,$ftpDir,$basename){
	//ini_set('display_errors', 1);
	//ini_set('display_startup_errors', 1);
	//error_reporting(E_ALL|E_STRICT);
	
	$remoteFile = "$ftpDir$basename";
    // echo "<br>" . $source . "...." . $ftpDir . "...." . $basename . "...." . $remoteFile . "<br>";
	
	$pictionServer = 'ucb1.piction.com';

	$conn_id = ftp_connect($pictionServer);
	// read credentials from a file outside the documentroot
	$ftp_credential_array = file('/var/www/ftp/ftp.txt',FILE_IGNORE_NEW_LINES);
	
	$username = $ftp_credential_array[0];
	$password = $ftp_credential_array[1];
	$login = ftp_login($conn_id,$username,$password);
	ftp_pasv($conn_id,true);
	ftp_chdir($conn_id, $ftpDir);

	if (ftp_put($conn_id, $basename, $source, FTP_BINARY))
	  {
	  echo "<div class='card card-success'><div class='card card-header'>SUCCESS!</div><div class='card card-block'>Successfully uploaded " . $basename . "</div></div>";
	  }
	else
	  {
	  echo "<div class='card card-danger'><div class='card card-header'>ERROR!</div><div class='card card-block'>Error uploading " . $basename . "</div></div>";
	  }

	// close connection
	ftp_close($conn_id);

}

?>

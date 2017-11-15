<?php
function ftpFile($source,$ftpDir,$basename){
	$remoteFile = "$ftpDir$basename";
	echo $source . "....". $ftpDir . "....". $basename . "....". $remoteFile;
	$pictionServer = 'ucb1.piction.com';
	$conn_id  = ftp_connect($pictionServer) or die("Could not connect to $pictionServer");
	$login = ftp_login($conn_id , 'bampfa', 'QDp4Tp25');

	ftp_chdir($conn_id, $ftpDir);

	if (ftp_put($conn_id, $basename, $source, FTP_BINARY))
	  {
	  echo "Successfully uploaded $basename.<br>";
	  }
	else
	  {
	  echo "Error uploading $basename.<br>";
	  }

	// close connection
	ftp_close($conn_id);

}

?>

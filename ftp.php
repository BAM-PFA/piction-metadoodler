<?php
function ftpFile($source,$ftpDir,$basename){
	$remoteFile = "$ftpDir$basename";
	$pictionServer = 'ucb1.piction.com';
	$conn_id  = ftp_connect($pictionServer) or die("Could not connect to $pictionServer");
	$login = ftp_login($conn_id , 'bampfa', 'QDp4Tp25');
	
	echo "$remotefilepath<br>";
	echo "$source<br>";

	if (ftp_put($conn_id, $remoteFile, $source, FTP_BINARY))
	  {
	  echo "Successfully uploaded $basename.";
	  }
	else
	  {
	  echo "Error uploading $basename.<br>";
	  }

	// close connection
	ftp_close($conn_id);

}

?>

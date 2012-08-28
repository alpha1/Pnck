<?php
DEFINE('MYSQLI_SERVER', "localhost");
DEFINE('MYSQLI_USER', "root");
DEFINE('MYSQLI_PASSWORD', "");
DEFINE('MYSQLI_DB', "shrty");
$mysqli_connect = mysqli_connect(MYSQLI_SERVER, MYSQLI_USER,MYSQLI_PASSWORD) or die("Could not connect to server");
$mysqli_db = mysqli_select_db($mysqli_connect, MYSQLI_DB) or die("Could not connect to database");
if(isset($_GET['url'])){
	$url = urldecode($_GET['url']);
	if(preg_match('|^(https?)://[\w-.]+([.][a-z]{2,7})*(:[\d]+)?(/.*)?$|', $url)){
		if(isset($_GET['name'])){
			$name = urldecode($_GET['name']); 
		} else {
			regenerate: 
			$name = hash('adler32', $url);
		}
	$name =mysqli_real_escape_string($mysqli_connect, $name);
	$url = mysqli_real_escape_string($mysqli_connect, $url);
		if(mysqli_query($mysqli_connect, "INSERT INTO shrties (`short`, `long`) VALUES ('$name', '$url')")){
		//echo $name;
		} else{
		//echo mysqli_error($mysqli_connect);
		$errorNo =  mysqli_errno($mysqli_connect);
		switch($errorNo){
		case 1062:
		$fetch_existing = mysqli_query($mysqli_connect, "SELECT `short` FROM `shrties` WHERE `long`='$url' LIMIT 1");
			if($fetch_existing){
			while($row = mysqli_fetch_array($fetch_existing)){
				$name = $row['short'];
				//echo $name;
			}
			} //else {} //regenerate because its already been used
		break;
		default:
		$name = "An Unknown Error has occured";
		}
		//if duplicate for short, regenerate
		//if duplicate for long, use existing short url
		}
		if(isset($_SERVER['HTTPS'])){
		echo 'https://'. $_SERVER['HTTP_HOST'] .'/'. $name;
		} else {
		echo 'http://'. $_SERVER['HTTP_HOST'] .'/'. $name;
		}
	} else {
	echo "Not a Valid URL";
	}
} else {
	if(isset($_SERVER['PATH_INFO'])){
	$short = str_replace("/", "", $_SERVER['PATH_INFO']);
	mysqli_query($mysqli_connect, "UPDATE `shrties` SET `hits`= hits+1 WHERE`short`='$short'");
	$fetch_short = mysqli_query($mysqli_connect, "SELECT `long` FROM `shrties` WHERE `short`='$short'  LIMIT 1");
		while($row = mysqli_fetch_array($fetch_short)){
		$long = $row['long'];
		//Header( "HTTP/1.1 301 Moved Permanently" ); 
		//Header( "Location: $long" ); 
		}
	} else {
	//gui
	}
}
mysqli_close($mysqli_connect);
?> 
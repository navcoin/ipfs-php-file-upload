<?php
include "IPFS.php";
use Cloutier\PhpIpfsApi\IPFS;
error_reporting(0);
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
if (count($_FILES)>0)
{
	if (move_uploaded_file($_FILES["file"]["tmp_name"], "upload/".$_FILES['file']['name']))
	{
		$content=file_get_contents("upload/".$_FILES['file']['name']);
	}
	//echo $content;
	$ipfs = new IPFS("127.0.0.1", "8080", "5001"); // leaving out the arguments will default to these values
	$cid=$ipfs->add($content);
	if ($cid)
	{
		$url="https://ipfs.nextwallet.org/ipfs/";
		$o->success=true;
		$o->url=$url;
		$o->cid=$cid;
	}
	else
	{
		$o->success=false;
		$o->message=$cid;
	}
}
else
{
	$o->success=false;
	$o->message="Select file";
}
echo json_encode($o);
?>

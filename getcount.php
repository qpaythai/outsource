<?
include("../main_include.php");
$action = $_GET['action'];
$arr = array();
switch($action){
	case 'getcount':
	$resultset = ROOT::query("select count(id) as c from log" );
	$row = mysqli_fetch_row($resultset);
	//$resultset->fetch_object();
	$arr['count'] = $row[0];
	break;
	case 'mapviewcount':
	extract($_GET);
	$n=10.449382871076676;
	$e=104.74223327636719;
	$s=17.092942157798294;
	$w=93.20658874511719;
//echo 	$sql = "select count(id) as c from log where ( gpslat <= ".$n." and gpslat >= ".$s." and gpslong >= ".$w." and gpslong <= ".$e." ) ";
	$logtransaction = new log();
	$logtransaction->gpslat = "!# between $n and $s #!";
	$logtransaction->gpslong = "!# between $w and $e #!";
	$logtransaction->loadmany();
	
	$logtransaction->track();
	
	break;
}

echo json_encode($arr);

?>
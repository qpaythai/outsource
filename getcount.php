<?
include("../main_include.php");
$action = $_GET['action'];
$arr = array();
switch($action){
	case 'getcount':
	$resultset = ROOT::query("select count(id) as c from log" );
	$row = $resultset->fetch_object();
	$arr['count'] = $row['c'];
	break;
	case 'mapviewcount':
	extract($_GET);
	$n=17.092942157798294;
	$e=104.74223327636719;
	$s=10.449382871076676;
	$w=93.20658874511719;
	$sql = "select count(id) as c from log where ( gpslat <= ".$n." and gpslat >= ".$s." and gpslong >= ".$w." and gpslong <= ".$e." ) ";
	$resultset = ROOT::query($sql );
	$row = $resultset->fetch_object();
	$arr['count'] = $row['c'];
	break;
}

echo json_encode($arr);

?>
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
	extract($_POST);
	$n=isset($_POST['n']) && $_POST['n']!=''? $_POST['n'] : 10.449382871076676;
	$e=isset($_POST['e']) && $_POST['e']!=''? $_POST['e'] : 104.74223327636719;
	$s=isset($_POST['s']) && $_POST['s']!=''? $_POST['s'] : 17.092942157798294;
	$w=isset($_POST['w']) && $_POST['w']!=''? $_POST['w'] : 93.20658874511719;
//echo 	$sql = "select count(id) as c from log where ( gpslat <= ".$n." and gpslat >= ".$s." and gpslong >= ".$w." and gpslong <= ".$e." ) ";
	$ids = isset($_POST['ids']) &&  $_POST['ids']!='' ? $_POST['ids'] : 0;
	
	if($n>$s){
		$t=$s;
		$n=$s;
		$s=$t;
	}
	if($e>$w){
		$t=$e;
		$w=$e;
		$e=$t;
	}
	$logtransaction = new log();
	$logtransaction->gpslat = "!# between $n and $s #!";
	$logtransaction->gpslong = "!# between $w and $e #!";
	$logtransaction->id = "!# NOT IN ($ids) #!";
	$logtransaction->loadmany();
	
	$arr->id = $logtransaction->id;
	$arr->lat = $logtransaction->gpslat;
	$arr->long  = $logtransaction->gpslong;	
	break;
}

echo json_encode($arr);



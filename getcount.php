<?
include("../main_include.php");
$action = $_GET['action'];
$arr = array();

extract($_REQUEST);
	$n=isset($_REQUEST['n']) && $_REQUEST['n']!=''? $_REQUEST['n'] : 10.449382871076676;
	$e=isset($_REQUEST['e']) && $_REQUEST['e']!=''? $_REQUEST['e'] : 104.74223327636719;
	$s=isset($_REQUEST['s']) && $_REQUEST['s']!=''? $_REQUEST['s'] : 17.092942157798294;
	$w=isset($_REQUEST['w']) && $_REQUEST['w']!=''? $_REQUEST['w'] : 93.20658874511719;
	$ids = isset($_REQUEST['ids']) &&  $_REQUEST['ids']!='' ? $_REQUEST['ids'] : 0;
	
	
switch($action){
	case 'getcount':
	
	if($n>$s){
		$t=$s;
		$n=$s;
		$s=$t;
	}
	if($w>$e){
		$t=$e;
		$w=$e;
		$e=$t;
	}
	$logtransaction = new log();
	$logtransaction->gpslat = "!# between $n and $s #!";
	$logtransaction->gpslong = "!# between $w and $e #!";
	$logtransaction->id = "!# NOT IN ($ids) #!";
	$logtransaction->loadmany();
	
	$arr->totlaRecords = $logtransaction->totalrecords;
	break;
	case 'mapviewcount':
	
	if($n>$s){
		$t=$s;
		$n=$s;
		$s=$t;
	}
	if($w>$e){
		$t=$e;
		$w=$e;
		$e=$t;
	}
	if(is_numeric($_POST['page'])) $page = $_POST['page'];
	else $page = 1;
	if(is_numberic($_POST['limit'])) $limit =$_POST['limit'];
	else $limit = 100;
	$logtransaction = new log();
	$logtransaction->gpslat = "!# between $n and $s #!";
	$logtransaction->gpslong = "!# between $w and $e #!";
	$logtransaction->loadmany(' order by id desc',$limit,$page);
	
	$arr->id = $logtransaction->id;
	$arr->lat = $logtransaction->gpslat;
	$arr->long = $logtransaction->gpslong;	
	break;
}

echo json_encode($arr);
?>
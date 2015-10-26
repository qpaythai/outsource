<?
include("../main_include.php");
$action = $_GET['action'];
extract($_REQUEST);
	$n=isset($_REQUEST['n']) && $_REQUEST['n']!=''? $_REQUEST['n'] : 10.449382871076676;
	$e=isset($_REQUEST['e']) && $_REQUEST['e']!=''? $_REQUEST['e'] : 104.74223327636719;
	$s=isset($_REQUEST['s']) && $_REQUEST['s']!=''? $_REQUEST['s'] : 17.092942157798294;
	$w=isset($_REQUEST['w']) && $_REQUEST['w']!=''? $_REQUEST['w'] : 93.20658874511719;
	$ids = isset($_REQUEST['ids']) &&  $_REQUEST['ids']!='' ? $_REQUEST['ids'] : 0;
	
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
	
switch($action){
	case 'getcount':
	
	$logtransaction->loadmany();
	
	$arr->totlaRecords = $logtransaction->totalrecords;
	break;
	case 'mapviewcount':
	
	
	if(is_numeric($_POST['page'])) $page = $_POST['page'];
	else $page = 1;
	if(is_numeric($_POST['limit'])) $limit =$_POST['limit'];
	else $limit = 1000;
	
	$logtransaction->id = "!# NOT IN ($ids) #!";
	$logtransaction->loadmany(' order by id desc',$limit,$page);

	$arr->id = $logtransaction->id;
	$arr->lat = $logtransaction->gpslat;
	$arr->long = $logtransaction->gpslong;	

	break;
}

echo json_encode($arr);
?>
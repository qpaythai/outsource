<?
include("../main_include.php");

$allowtable = array("member","log");
if(in_array($_POST['table'],$allowtable)){
	
	$classname = $_POST['table'];
	$preview = new $classname();
	if($_POST['field'] ){ 
		$field = $_POST['field'];
		$preview->$field = $_POST['fieldval'];
	}
	$preview->loadmany(' order by id desc',10); // 10 records limit
}



?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Test</title>
</head>
<body>
<p>&nbsp;</p>
<p>&nbsp;</p>
<form method="post">
<p>Table :
  <input type="text" name="table" value="<?= $_POST['table'];?>"  >
</p>
<p>field name :
  <input type="text" name="field">
</p>
<p>field value :
  <input type="text" name="fieldval" >
</p>
  <input type='submit'>
</form>
<? if($preview)  $preview->track(); ?>
</body>
</html>
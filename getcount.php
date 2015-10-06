<?
include("../main_include.php");
$resultset = ROOT::query("select count(id) as c from log group by id" );
var_dump($resultset);

?>
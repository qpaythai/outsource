<?
include("../main_include.php");
$resultset = ROOT::query("select count(id) as c from log" );
var_dump($resultset);

?>
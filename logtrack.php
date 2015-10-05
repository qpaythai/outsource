<?
include("../main_include.php");

if($_POST['log_id'] >  0 ) {

$log = new log;
$log->id = $_REQUEST['log_id'];	
$log->loadmany();
}

function track_object(&$obj) {
    

    $classname = get_class($obj);
    if ($classname) {
        echo "<table border=1 cellspacing=0 cellpadding=0>";
        $class_vars = get_object_vars($obj);
        foreach ($class_vars as $name => $value) {
            echo "<tr><td>\$$name : </td><td>";
            track_object($value);
            echo "</td></tr>";
        }
        echo "</table>";
    } else {
        if (is_array($obj)) {
            while (list($key, $val) = each($obj)) {
                echo "[ $key ] = ";
                track_object($val);
                echo "<br>";
            }
        } else {
            echo " $obj ";
        } 
    }
}


?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>
<form method='post'>
ID: <input type='text' name='log_id'>
<p>
<input type='submit'>
</form>


<table width="100%" border="1">
    <tbody>
        <tr bgcolor="#55AAFF">
            <td width="1%" align="center">ID</td>
            <td width="20%" align="center">FILE</td>
            <td width="79%" align="center">POST & GET Parametor</td>

        </tr>
        <?
        for ($x = 0; $x < $log->TOTALITEMS; $x++) {
            if ($log->detail[$x])
                $env = json_decode($log->detail[$x]);
            ?>
            <tr>
                <td align="center"><?= $log->id[$x]; ?></td>
                <td align="center"><strong><?= $log->title[$x]; ?></strong> <BR> <BR>
                    FROM IP :<? echo $log->ip[$x];
        echo "<BR>Passcode: {$log->passcode[$x]} <BR>";
            ?>
                    <br>
    <?= ROOT::day($log->create_date[$x], true); ?>
                </td>
                <td align="left">
                
                
                 <table><tr><td><? echo "<BR>DECODE BODY : $env->LANG";
                            track_object($env->BODY);
                    ?></td><td><? 
							if($env->msg->data->count > 4 ) {
								echo '<a href="#" class="viewmoremsg">ViewMSG......</a><div class="replymsg" style="display:none;">';track_object($env->msg); echo "</DIV>";
							}else{
							
							 echo "REPLYMSG: ";
                            track_object($env->msg);
							}
                            ?></td></tr></table>


                </td>


            </tr>
<? } ?>
    </tbody>
</table>


</body>
</html>
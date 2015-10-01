<?
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
    } else {## NOT Object
        if (is_array($obj)) { #  Array
            while (list($key, $val) = each($obj)) {
                echo "[ $key ] = ";
                track_object($val);
                echo "<br>";
            }
        } else {
            echo " $obj ";
        } # Normal
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
<form method="post">

<textarea type='text' name='jsontxt'> </textarea>
<input type='submit'>
</form>
<?
if($_POST['jsontxt']){
	track_object	(json_decode($_POST['jsontxt']));
}
?>
</body>
</html>

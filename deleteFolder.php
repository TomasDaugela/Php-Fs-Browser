
<?php

$file = $_GET['dir'];

rmdir($file);

header("location: index.php");

?>

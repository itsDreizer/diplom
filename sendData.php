<?php
include "connect.php";

$textData = $_POST["textData"];
$textData = htmlspecialchars($textData);
mysqli_query($db, "INSERT INTO `comments` (`textdata`) VALUES ('$textData')");
?>

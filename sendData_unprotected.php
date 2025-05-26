<?php
include "connect.php";

$textData = $_POST["textData"];

mysqli_query($db, "INSERT INTO `comments` (`textdata`) VALUES ('$textData')");
header("Location: comments_unprotected.php");

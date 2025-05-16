<?php
include "connect.php";

$textData = $_POST["textData"];
// Не экранируем HTML-сущности, что позволит XSS-атакам работать
mysqli_query($db, "INSERT INTO `comments` (`textdata`) VALUES ('$textData')");
header("Location: comments_unprotected.php");

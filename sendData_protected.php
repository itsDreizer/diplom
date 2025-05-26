<?php
include "connect.php";

$textData = $_POST["textData"];

$textData = htmlspecialchars($textData, ENT_QUOTES, 'UTF-8');

$stmt = $db->prepare("INSERT INTO `comments` (`textdata`) VALUES (?)");
$stmt->bind_param("s", $textData);
$stmt->execute();

header("Location: comments_protected.php");

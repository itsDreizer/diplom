<?php
include "connect.php";

$textData = $_POST["textData"];
// Экранируем HTML-сущности, чтобы предотвратить XSS
$textData = htmlspecialchars($textData, ENT_QUOTES, 'UTF-8');

$stmt = $db->prepare("INSERT INTO `comments` (`textdata`) VALUES (?)");
$stmt->bind_param("s", $textData);
$stmt->execute();

header("Location: comments_protected.php");

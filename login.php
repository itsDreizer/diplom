<?php
include "connect.php";

// $username = mysqli_real_escape_string($db, $_POST["login"]);
// $password = mysqli_real_escape_string($db, $_POST["password"]);

$username =  $_POST["login"];
$password =  $_POST["password"];

$response =  mysqli_query($db, "SELECT * FROM `users` WHERE `username` = '$username' AND `password` = '$password' ") or die(mysqli_error($db));
$user = mysqli_fetch_assoc($response);

$message = "";


if ($user) {
  $message = "Вход успешно выполнен!";
} else {
  $message = "Ошибка!";
}
echo ($message)
?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $message ?></title>
</head>

<body style="
    display: flex;
    align-items: center;
    justify-content: center;
    background: black;
    color: white;
    font-size: 50px;
">

</body>

</html>
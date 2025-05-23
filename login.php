<?php
include "connect.php";
require_once 'vendor/autoload.php';

use \Firebase\JWT\JWT;

$username = $_POST["login"];
$password = $_POST["password"];

$stmt = mysqli_prepare($db, "SELECT * FROM `users` WHERE `username` = ? AND `password` = ?");
mysqli_stmt_bind_param($stmt, "ss", $username, $password);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

$message = "";

if ($user) {

  $key = "your-secret-key";
  $payload = array(
    "user_id" => $user['id'],
    "username" => $user['username'],
    "iat" => time(),
    "exp" => time() + (86400 * 30)
  );

  $token = JWT::encode($payload, $key, 'HS256');


  $stmt = mysqli_prepare($db, "SELECT id FROM tokens WHERE user_id = ?");
  mysqli_stmt_bind_param($stmt, "i", $user['id']);
  mysqli_stmt_execute($stmt);
  $existingToken = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

  if ($existingToken) {
    $stmt = mysqli_prepare($db, "UPDATE tokens SET token = ? WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, "si", $token, $user['id']);
  } else {
    $stmt = mysqli_prepare($db, "INSERT INTO tokens (user_id, token) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "is", $user['id'], $token);
  }
  mysqli_stmt_execute($stmt);

  $cookieSet = setcookie(
    'accessToken',
    $token,
    [
      'expires' => time() + (86400 * 30),
      'path' => '/',
      'samesite' => 'Strict',
    ]
  );

  if (!$cookieSet) {
    error_log("Не удалось установить куки");
  }

  $message = "Вход успешно выполнен!";
} else {
  $message = "Ошибка!";
}

?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($message) ?></title>
</head>

<body style="
    display: flex;
    align-items: center;
    justify-content: center;
    background: black;
    color: white;
    font-size: 50px;
    margin: 0;
    min-height: 100vh;
">
  <div><?= htmlspecialchars($message) ?></div>
</body>

</html>
<?php
include "connect.php";
require_once 'vendor/autoload.php';

use \Firebase\JWT\JWT;

$username = $_POST["login"];
$password = $_POST["password"];

$response = mysqli_query($db, "SELECT * FROM users WHERE username = '$username' AND password = '$password'") or die(mysqli_error($db));
$user = mysqli_fetch_assoc($response);

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

  
  $existingToken = mysqli_fetch_assoc(mysqli_query($db, "SELECT id FROM tokens WHERE user_id = " . $user['id']));

  if ($existingToken) {
    
    mysqli_query($db, "UPDATE tokens SET token = '$token' WHERE user_id = " . $user['id']);
  } else {
    mysqli_query($db, "INSERT INTO tokens (user_id, token) VALUES (" . $user['id'] . ", '$token')");
  }

  $cookieSet = setcookie(
    'accessToken',
    $token,
    [
      'expires' => time() + (86400 * 30),
      'path' => '/',
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
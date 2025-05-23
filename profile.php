<?php
include "connect.php";
require_once 'vendor/autoload.php';

use \Firebase\JWT\JWT;

$userLogin = "";
$error = "";

if (isset($_COOKIE['accessToken'])) {
  try {
    $key = "your-secret-key"; 
    $token = $_COOKIE['accessToken'];

  
    $decoded = JWT::decode($token, $key, array('HS256'));

    $stmt = mysqli_prepare($db, "SELECT username FROM users WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $decoded->user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
      $userLogin = $user['username'];
    } else {
      header("Location: form_protected.php");
      exit();
    }
  } catch (Exception $e) {
    header("Location: form_protected.php");
    exit();
  }
} else {
  header("Location: form_protected.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles.css" />
  <title>Настройки профиля</title>
</head>

<body>
  <div class="container">
    <h1 style="margin-bottom: 40px;">Настройки профиля</h1>

    <div id="message" style="display: none; margin-bottom: 20px; padding: 10px; border-radius: 5px;"></div>

    <form id="profileForm" method="post" action="update.php" novalidate autocomplete="off" class="form">
      <label class="form__label" for="login">Логин:</label>
      <input placeholder="Введите логин" class="form__input" name="login" type="text" value="<?= htmlspecialchars($userLogin) ?>">
      <label class="form__label" for="password">Новый пароль:</label>
      <input placeholder="Введите пароль" class="form__input" name="password" type="text">
      <button type="submit" class="form__submit">Сохранить</button>
    </form>
  </div>

  <script>
    document.getElementById('profileForm').addEventListener('submit', function(e) {
      e.preventDefault();

      const formData = new FormData(this);
      const messageDiv = document.getElementById('message');

      fetch('update.php', {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          messageDiv.style.display = 'block';
          if (data.success) {
            messageDiv.style.backgroundColor = '#d4edda';
            messageDiv.style.color = '#155724';
          } else {
            messageDiv.style.backgroundColor = '#f8d7da';
            messageDiv.style.color = '#721c24';
          }
          messageDiv.textContent = data.message || data.error;
        })
        .catch(error => {
          messageDiv.style.display = 'block';
          messageDiv.style.backgroundColor = '#f8d7da';
          messageDiv.style.color = '#721c24';
          messageDiv.textContent = 'Произошла ошибка при обновлении данных';
        });
    });
  </script>
</body>

</html>
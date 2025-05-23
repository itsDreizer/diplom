<?php
include "connect.php";
require_once 'vendor/autoload.php';

use \Firebase\JWT\JWT;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $requestData = $_POST;
} else {
  $requestData = $_GET;
}

if (!isset($_COOKIE['accessToken'])) {
  http_response_code(401);
  echo json_encode(['error' => 'Требуется авторизация']);
  exit();
}

try {
  $key = "your-secret-key";
  $token = $_COOKIE['accessToken'];

  $decoded = JWT::decode($token, $key, array('HS256'));
  $userId = $decoded->user_id;

  $stmt = mysqli_prepare($db, "SELECT username, password FROM users WHERE id = ?");
  mysqli_stmt_bind_param($stmt, "i", $userId);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $currentUser = mysqli_fetch_assoc($result);

  if (!$currentUser) {
    http_response_code(404);
    echo json_encode(['error' => 'Пользователь не найден']);
    exit();
  }

  $updates = [];
  $params = [];
  $types = "";

  if (isset($requestData['login']) && !empty($requestData['login']) && $requestData['login'] !== $currentUser['username']) {
    $updates[] = "username = ?";
    $params[] = $requestData['login'];
    $types .= "s";
  }

  if (isset($requestData['password']) && !empty($requestData['password']) && $requestData['password'] !== $currentUser['password']) {
    $updates[] = "password = ?";
    $params[] = $requestData['password'];
    $types .= "s";
  }

  if (!empty($updates)) {
    $params[] = $userId;
    $types .= "i";

    $sql = "UPDATE users SET " . implode(", ", $updates) . " WHERE id = ?";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, $types, ...$params);

    if (mysqli_stmt_execute($stmt)) {
      echo json_encode(['success' => true, 'message' => 'Данные успешно обновлены']);
    } else {
      http_response_code(500);
      echo json_encode(['error' => 'Ошибка при обновлении данных']);
    }
  } else {
    echo json_encode(['success' => true, 'message' => 'Нет изменений для обновления']);
  }
} catch (Exception $e) {
  http_response_code(401);
  echo json_encode(['error' => 'Недействительный токен']);
}

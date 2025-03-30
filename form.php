<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="styles.css" />
  <title>Практика</title>
</head>

<body>
  <div class="container">
    <form method="post" action="login.php" novalidate autocomplete="off" class="form">
      <label class="form__label" for="login">Введите логин:</label>
      <input placeholder="Введите логин" class="form__input" name="login" type="text">
      <label class="form__label" for="password">Введите пароль:</label>
      <input placeholder="Введите пароль" class="form__input" name="password" type="text">
      <button type="submit" class="form__submit">Отправить</button>
    </form>
  </div>
</body>

</html>
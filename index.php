<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles.css" />
  <title>Практика</title>
</head>

<body>
  <div class="container">
    <h1>Имитация XSS, CSRF атак и SQL Инъекций</h1>
    <div class="pages">
      <ul class="pages-list">
        <li class="pages-list__item">
          <a class="pages-list__link" href="form_protected.php">Форма (защищенная)</a>
        </li>
        <li class="pages-list__item">
          <a class="pages-list__link" href="form_unprotected.php">Форма (незащищенная)</a>
        </li>
        <li class="pages-list__item">
          <a class="pages-list__link" href="comments_protected.php">Комментарии (защищенные)</a>
        </li>
        <li class="pages-list__item">
          <a class="pages-list__link" href="comments_unprotected.php">Комментарии (незащищенные)</a>
        </li>
        <li class="pages-list__item">
          <a class="pages-list__link" href="profile.php">Профиль</a>
        </li>
      </ul>
    </div>
  </div>

</body>

</html>
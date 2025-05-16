<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles.css" />
  <title>Комментарии (Незащищенная версия)</title>
</head>

<body>
  <div class="comments">
    <div class="comments__container">
      <form novalidate method="post" action="sendData_unprotected.php" enctype="multipart/form-data" class="form comments-form">
        <input autocomplete="off" name="textData" placeholder="Напишите комментарий" class="comments-form__input form__input" type="text">
        <button name="submitter" type="submit" class="form__submit comments-form__submit">Отправить</button>
      </form>
      <?php
      include "connect.php";
      $data = mysqli_query($db, "SELECT * FROM `comments`");
      $data = mysqli_fetch_all($data);
      $data = array_reverse($data);
      foreach ($data as $data) {
      ?>
        <div class="comment">
          <div class="comment__block-img">
            <img class="comment__img" src="images/avatar.jpg" alt="">
          </div>
          <div class="comment__block-text">
            <div class="comment__title">Anonymous</div>
            <div class="comment__text"><?php echo $data[1]; ?></div>
          </div>
        </div>
      <?php
      }
      ?>
    </div>
  </div>
  <script>
    const form = document.querySelector('.form');
    form.addEventListener("submit", async (e) => {
      e.preventDefault();
      const input = form.querySelector('.form__input');
      const formData = new FormData(form);
      if (input.value) {
        const response = await fetch("sendData_unprotected.php", {
          method: "POST",
          body: formData,
        });
        if (response.ok) {
          location.reload();
        }
      } else {
        alert("Заполните поле!");
      }
    });
  </script>
</body>

</html>
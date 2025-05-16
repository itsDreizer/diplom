const form = document.querySelector(`.form`);

form.addEventListener("submit", async (e) => {
  e.preventDefault();
  const input = form.querySelector(`.form__input`);

  const formData = new FormData(form);
  if (input.value) {
    const isProtected = window.location.pathname.includes("protected");
    const endpoint = isProtected ? "sendData_protected.php" : "sendData_unprotected.php";

    const response = await fetch(endpoint, {
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

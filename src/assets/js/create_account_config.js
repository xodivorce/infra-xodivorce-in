document.addEventListener("DOMContentLoaded", () => {
  const input = document.getElementById("password");
  const btn = document.getElementById("togglePasswordBtn");

  if (input && btn) {
    btn.addEventListener("click", () => {
      if (input.type === "password") {
        input.type = "text";
        btn.textContent = btn.dataset.hide;
      } else {
        input.type = "password";
        btn.textContent = btn.dataset.show;
      }
    });
  }
});

document.addEventListener("keydown", function (event) {
  if (event.key === "Enter") {
    event.preventDefault();
    document.getElementById("nextBtn").click();
  }
});

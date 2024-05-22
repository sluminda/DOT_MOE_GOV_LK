const loginBtn = document.querySelector(".login_btn_container");
const closeBtn = document.querySelector(".close_btn_container");
const loginWindow = document.querySelector(".login-background_container");

loginBtn.addEventListener("click", () => {
  loginWindow.classList.remove("close-transition");
  loginWindow.classList.add("open-transition");
});

closeBtn.addEventListener("click", () => {
  loginWindow.classList.add("close-transition");
  loginWindow.classList.remove("open-transition");
});

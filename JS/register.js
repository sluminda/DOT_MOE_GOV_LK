function validateForm() {
  let valid = true;
  let username = document.getElementById("username");
  let email = document.getElementById("email");
  let userType = document.getElementById("userType");
  let phoneNumber = document.getElementById("phoneNumber");
  let password = document.getElementById("password");
  let rePassword = document.getElementById("re_password");

  let usernameError = document.getElementById("username-error");
  let emailError = document.getElementById("email-error");
  let phoneNumberError = document.getElementById("phoneNumber-error");
  let passwordError = document.getElementById("password-error");
  let rePasswordError = document.getElementById("re_password-error");

  usernameError.style.display = "none";
  emailError.style.display = "none";
  phoneNumberError.style.display = "none";
  passwordError.style.display = "none";
  rePasswordError.style.display = "none";

  username.classList.remove("input-error");
  email.classList.remove("input-error");
  phoneNumber.classList.remove("input-error");
  password.classList.remove("input-error");
  rePassword.classList.remove("input-error");

  if (username.value.trim() === "") {
    usernameError.style.display = "block";
    usernameError.textContent = "Username is required.";
    username.classList.add("input-error");
    valid = false;
  }

  if (!/\S+@\S+\.\S+/.test(email.value)) {
    emailError.style.display = "block";
    emailError.textContent = "Invalid email address.";
    email.classList.add("input-error");
    valid = false;
  }

  if (!/^0[0-9]{9}$/.test(phoneNumber.value)) {
    phoneNumberError.style.display = "block";
    phoneNumberError.textContent =
      "Phone number must be 10 digits and start with 0.";
    phoneNumber.classList.add("input-error");
    valid = false;
  }

  if (password.value.length < 6) {
    passwordError.style.display = "block";
    passwordError.textContent = "Password must be at least 6 characters.";
    password.classList.add("input-error");
    valid = false;
  }

  if (password.value !== rePassword.value) {
    rePasswordError.style.display = "block";
    rePasswordError.textContent = "Passwords do not match.";
    rePassword.classList.add("input-error");
    valid = false;
  }

  return valid;
}

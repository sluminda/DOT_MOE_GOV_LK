document.addEventListener("DOMContentLoaded", () => {
  const fullName = document.getElementById("fullName");
  const nic = document.getElementById("nic");
  const email = document.getElementById("email");
  const mobileNumber = document.getElementById("mobileNumber");
  const subject = document.getElementById("subject");
  const message = document.getElementById("message");

  const fullNameError = document.getElementById("fullNameError");
  const nicError = document.getElementById("nicError");
  const emailError = document.getElementById("emailError");
  const mobileNumberError = document.getElementById("mobileNumberError");
  const subjectError = document.getElementById("subjectError");
  const messageError = document.getElementById("messageError");

  const validateFullName = () => {
    const fullNameValue = fullName.value.trim();
    const regex = /^[A-Za-z\s.]+$/;
    if (!regex.test(fullNameValue)) {
      fullNameError.textContent =
        "Full Name can only contain letters, spaces, and dots.";
      return false;
    } else {
      fullNameError.textContent = "";
      return true;
    }
  };

  const validateNIC = () => {
    const nicValue = nic.value.trim();
    const regexOldNIC = /^[0-9]{9}[vV]$/;
    const regexNewNIC = /^[0-9]{12}$/;
    if (!regexOldNIC.test(nicValue) && !regexNewNIC.test(nicValue)) {
      nicError.textContent =
        "NIC must be 10 digits ending with 'v' or 'V', or 12 digits of only numbers.";
      return false;
    } else {
      nicError.textContent = "";
      return true;
    }
  };

  const validateEmail = () => {
    const emailValue = email.value.trim();
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!regex.test(emailValue)) {
      emailError.textContent = "Invalid email address.";
      return false;
    } else {
      emailError.textContent = "";
      return true;
    }
  };

  const validateMobileNumber = () => {
    const mobileNumberValue = mobileNumber.value.trim();
    const regex = /^0[0-9]{9}$/;
    if (!regex.test(mobileNumberValue)) {
      mobileNumberError.textContent =
        "Mobile Number must be 10 digits starting with 0.";
      return false;
    } else {
      mobileNumberError.textContent = "";
      return true;
    }
  };

  const validateSubject = () => {
    const subjectValue = subject.value.trim().split(/\s+/);
    if (subjectValue.length > 50) {
      subjectError.textContent = "Subject cannot exceed 50 words.";
      return false;
    } else {
      subjectError.textContent = "";
      return true;
    }
  };

  const validateMessage = () => {
    const messageValue = message.value.trim().split(/\s+/);
    if (messageValue.length > 500) {
      messageError.textContent = "Message cannot exceed 500 words.";
      return false;
    } else {
      messageError.textContent = "";
      return true;
    }
  };

  fullName.addEventListener("input", validateFullName);
  nic.addEventListener("input", validateNIC);
  email.addEventListener("input", validateEmail);
  mobileNumber.addEventListener("input", validateMobileNumber);
  subject.addEventListener("input", validateSubject);
  message.addEventListener("input", validateMessage);

  document.getElementById("detailsForm").addEventListener("submit", (event) => {
    const isFullNameValid = validateFullName();
    const isNICValid = validateNIC();
    const isEmailValid = validateEmail();
    const isMobileNumberValid = validateMobileNumber();
    const isSubjectValid = validateSubject();
    const isMessageValid = validateMessage();

    if (
      !isFullNameValid ||
      !isNICValid ||
      !isEmailValid ||
      !isMobileNumberValid ||
      !isSubjectValid ||
      !isMessageValid
    ) {
      event.preventDefault();
    }
  });
});

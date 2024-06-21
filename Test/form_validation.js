function validateFullName() {
  const fullName = document.getElementById("fullName").value;
  const regex = /^[A-Za-z\s.]+$/;
  const errorMessage = document.getElementById("fullName-error");
  if (!regex.test(fullName)) {
    errorMessage.textContent =
      "Full Name should only contain letters, dots, or spaces.";
    errorMessage.style.display = "block";
    return false;
  } else {
    errorMessage.style.display = "none";
    return true;
  }
}

function validateInitials() {
  const initials = document.getElementById("initials").value;
  const regex = /^[A-Za-z\s.]+$/;
  const errorMessage = document.getElementById("initials-error");
  if (!regex.test(initials)) {
    errorMessage.textContent =
      "Name with Initials should only contain letters, dots, or spaces.";
    errorMessage.style.display = "block";
    return false;
  } else {
    errorMessage.style.display = "none";
    return true;
  }
}

function validateNic() {
  const nic = document.getElementById("nic").value;
  const regex = /^[0-9]{9}[vVxX]?$|^[0-9]{12}$/;
  const errorMessage = document.getElementById("nic-error");
  if (!regex.test(nic)) {
    errorMessage.textContent =
      "NIC should be a maximum of 12 digits. 'v' or 'V' can be included at the end.";
    errorMessage.style.display = "block";
    return false;
  } else {
    errorMessage.style.display = "none";
    return true;
  }
}

function validateEmail() {
  const email = document.getElementById("email").value;
  const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  const errorMessage = document.getElementById("email-error");
  if (!regex.test(email)) {
    errorMessage.textContent = "Please enter a valid email address.";
    errorMessage.style.display = "block";
    return false;
  } else {
    errorMessage.style.display = "none";
    return true;
  }
}

function validatePhoneNumber(id) {
  const phoneNumber = document.getElementById(id).value;
  const regex = /^0[0-9]{9}$/;
  const errorMessage = document.getElementById(`${id}-error`);
  if (!regex.test(phoneNumber)) {
    errorMessage.textContent =
      "Phone number must contain 10 digits starting with 0.";
    errorMessage.style.display = "block";
    return false;
  } else {
    errorMessage.style.display = "none";
    return true;
  }
}

function validatePrincipleName() {
  const principleName = document.getElementById("principleName").value;
  const regex = /^[A-Za-z\s.]+$/;
  const errorMessage = document.getElementById("principleName-error");
  if (!regex.test(principleName)) {
    errorMessage.textContent =
      "Principle Name should only contain letters, dots, or spaces.";
    errorMessage.style.display = "block";
    return false;
  } else {
    errorMessage.style.display = "none";
    return true;
  }
}

function validateHeadOfInstituteName() {
  const headOfInstituteName = document.getElementById(
    "headOfInstituteName"
  ).value;
  const regex = /^[A-Za-z\s.]+$/;
  const errorMessage = document.getElementById("headOfInstituteName-error");
  if (!regex.test(headOfInstituteName)) {
    errorMessage.textContent =
      "Head of Institute Name should only contain letters, dots, or spaces.";
    errorMessage.style.display = "block";
    return false;
  } else {
    errorMessage.style.display = "none";
    return true;
  }
}

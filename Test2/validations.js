const form = document.getElementById("registrationForm");
const fullName = document.getElementById("fullName");
const initialsName = document.getElementById("initialsName");
const nic = document.getElementById("nic");
const email = document.getElementById("email");
const whatsapp = document.getElementById("whatsapp");
const mobile = document.getElementById("mobile");
const workingPlace = document.getElementById("workingPlace");
const schoolDetails = document.getElementById("schoolDetails");
const officeDetails = document.getElementById("officeDetails");
const sendOtpButton = document.getElementById("sendOtpButton");
const otp = document.getElementById("otp");
const verifyOtpButton = document.getElementById("verifyOtpButton");

const namePattern = /^[A-Za-z\s.]+$/;
const nicPattern = /^(\d{9}[vV]|\d{12})$/;
const phonePattern = /^0\d{9}$/;

const displayError = (element, message) => {
  document.getElementById(element + "Error").innerText = message;
};

const clearError = (element) => {
  document.getElementById(element + "Error").innerText = "";
};

fullName.addEventListener("input", () => {
  if (!namePattern.test(fullName.value)) {
    displayError(
      "fullName",
      "Full Name can only contain letters, spaces, and dots."
    );
  } else {
    clearError("fullName");
  }
});

initialsName.addEventListener("input", () => {
  if (!namePattern.test(initialsName.value)) {
    displayError(
      "initialsName",
      "Name with Initials can only contain letters, spaces, and dots."
    );
  } else {
    clearError("initialsName");
  }
});

nic.addEventListener("input", () => {
  if (!nicPattern.test(nic.value)) {
    displayError(
      "nic",
      'NIC must be 12 digits or 10 digits ending with "v" or "V".'
    );
  } else {
    clearError("nic");
  }
});

email.addEventListener("input", () => {
  if (!email.checkValidity()) {
    displayError("email", "Invalid email address.");
  } else {
    clearError("email");
  }
});

whatsapp.addEventListener("input", () => {
  if (!phonePattern.test(whatsapp.value)) {
    displayError(
      "whatsapp",
      "WhatsApp Number must be 10 digits starting with 0."
    );
  } else {
    clearError("whatsapp");
  }
});

mobile.addEventListener("input", () => {
  if (!phonePattern.test(mobile.value)) {
    displayError("mobile", "Mobile Number must be 10 digits starting with 0.");
  } else {
    clearError("mobile");
  }
});

workingPlace.addEventListener("change", () => {
  clearError("workingPlace");
  if (workingPlace.value === "School") {
    schoolDetails.classList.remove("hidden");
    officeDetails.classList.add("hidden");
  } else if (
    workingPlace.value === "Provincial Office" ||
    workingPlace.value === "Zonal Office" ||
    workingPlace.value === "Divisional Office"
  ) {
    schoolDetails.classList.add("hidden");
    officeDetails.classList.remove("hidden");
  } else {
    schoolDetails.classList.add("hidden");
    officeDetails.classList.add("hidden");
  }
});

form.addEventListener("submit", function (event) {
  event.preventDefault();
  // Additional form submission handling here
  alert("Form submitted successfully!");
});

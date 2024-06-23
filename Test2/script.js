document.addEventListener("DOMContentLoaded", () => {
  const requestOtpButton = document.getElementById("requestOtp");
  const verifyOtpButton = document.getElementById("verifyOtp");
  const otpSection = document.getElementById("otpSection");
  const otpMessage = document.getElementById("otpMessage");
  let canRequestOtp = true;

  requestOtpButton.addEventListener("click", () => {
    if (canRequestOtp) {
      const email = document.getElementById("email").value;
      if (/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        fetch("request_otp.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ email: email }),
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              otpMessage.textContent = "OTP sent to your email.";
              otpMessage.className = "message success";
              otpSection.style.display = "block";
              otpMessage.style.display = "block";
              canRequestOtp = false;
              setTimeout(() => (canRequestOtp = true), 60000); // 1 minute timeout
            } else {
              otpMessage.textContent = "Error sending OTP: " + data.message;
              otpMessage.className = "message error";
              otpMessage.style.display = "block";
            }
          });
      } else {
        otpMessage.textContent = "Please enter a valid email address.";
        otpMessage.className = "message error";
        otpMessage.style.display = "block";
      }
    } else {
      otpMessage.textContent =
        "You must wait 1 minute before requesting another OTP.";
      otpMessage.className = "message error";
      otpMessage.style.display = "block";
    }
  });

  verifyOtpButton.addEventListener("click", () => {
    const otp = document.getElementById("otp").value;
    const email = document.getElementById("email").value;

    fetch("verify_otp.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ email: email, otp: otp }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          otpMessage.textContent = "OTP verified successfully.";
          otpMessage.className = "message success";
          otpMessage.style.display = "block";
        } else {
          otpMessage.textContent = "Invalid OTP or OTP expired.";
          otpMessage.className = "message error";
          otpMessage.style.display = "block";
        }
      });
  });

  const detailsForm = document.getElementById("detailsForm");
  const currentWorkplace = document.getElementById("currentWorkplace");
  const schoolDetails = document.getElementById("schoolDetails");
  const officeDetails = document.getElementById("officeDetails");

  const fullName = document.getElementById("fullName");
  const initialsName = document.getElementById("initialsName");
  const nic = document.getElementById("nic");
  const email = document.getElementById("email");
  const whatsappNumber = document.getElementById("whatsappNumber");
  const mobileNumber = document.getElementById("mobileNumber");

  const principleName = document.getElementById("principleName");
  const principleContact = document.getElementById("principleContact");
  const instituteName = document.getElementById("instituteName");
  const headOfInstitute = document.getElementById("headOfInstitute");
  const headContact = document.getElementById("headContact");

  const errorMessages = {
    fullName: "Full Name can only contain letters, spaces, and dots.",
    initialsName:
      "Name with Initials can only contain letters, spaces, and dots.",
    nic: "NIC must be 10 digits ending with 'v' or 'V', or 12 digits of only numbers.",
    email: "Invalid email address.",
    whatsappNumber: "WhatsApp Number must be 10 digits starting with 0.",
    mobileNumber: "Mobile Number must be 10 digits starting with 0.",
    principleName: "Principal Name can only contain letters, spaces, and dots.",
    principleContact: "Principal Contact No must be 10 digits starting with 0.",
    headOfInstitute:
      "Head of Institute Name can only contain letters, spaces, and dots.",
    headContact:
      "Head of Institute Contact No must be 10 digits starting with 0.",
  };

  function showError(input, message) {
    const errorDiv = input.nextElementSibling;
    errorDiv.textContent = message;
    errorDiv.style.display = "block";
    input.style.borderColor = "red";
  }

  function hideError(input) {
    const errorDiv = input.nextElementSibling;
    errorDiv.style.display = "none";
    input.style.borderColor = "";
  }

  function validateInput(input, regex, errorMessage) {
    input.addEventListener("input", () => {
      if (!regex.test(input.value)) {
        showError(input, errorMessage);
      } else {
        hideError(input);
      }
    });
  }

  validateInput(fullName, /^[A-Za-z\s.]+$/, errorMessages.fullName);
  validateInput(initialsName, /^[A-Za-z\s.]+$/, errorMessages.initialsName);
  validateInput(nic, /^(\d{9}[vV]|\d{12})$/, errorMessages.nic);
  validateInput(email, /^[^\s@]+@[^\s@]+\.[^\s@]+$/, errorMessages.email);
  validateInput(whatsappNumber, /^0\d{9}$/, errorMessages.whatsappNumber);
  validateInput(mobileNumber, /^0\d{9}$/, errorMessages.mobileNumber);
  validateInput(principleName, /^[A-Za-z\s.]+$/, errorMessages.principleName);
  validateInput(principleContact, /^0\d{9}$/, errorMessages.principleContact);
  validateInput(instituteName, /^[A-Za-z\s.]+$/, errorMessages.headOfInstitute);
  validateInput(
    headOfInstitute,
    /^[A-Za-z\s.]+$/,
    errorMessages.headOfInstitute
  );
  validateInput(headContact, /^0\d{9}$/, errorMessages.headContact);

  currentWorkplace.addEventListener("change", () => {
    const selectedValue = currentWorkplace.value;
    if (selectedValue === "school") {
      schoolDetails.classList.add("show");
      officeDetails.classList.remove("show");
    } else if (
      selectedValue === "provincialOffice" ||
      selectedValue === "zonalOffice" ||
      selectedValue === "divisionalOffice"
    ) {
      schoolDetails.classList.remove("show");
      officeDetails.classList.add("show");
    } else {
      schoolDetails.classList.remove("show");
      officeDetails.classList.remove("show");
    }
  });

  detailsForm.addEventListener("submit", (event) => {
    let isValid = true;

    // Validate Full Name
    if (!/^[A-Za-z\s.]+$/.test(fullName.value)) {
      showError(fullName, errorMessages.fullName);
      isValid = false;
    }

    // Validate Name with Initials
    if (!/^[A-Za-z\s.]+$/.test(initialsName.value)) {
      showError(initialsName, errorMessages.initialsName);
      isValid = false;
    }

    // Validate NIC
    if (!/^(\d{9}[vV]|\d{12})$/.test(nic.value)) {
      showError(nic, errorMessages.nic);
      isValid = false;
    }

    // Validate Email
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
      showError(email, errorMessages.email);
      isValid = false;
    }

    // Validate WhatsApp Number
    if (!/^0\d{9}$/.test(whatsappNumber.value)) {
      showError(whatsappNumber, errorMessages.whatsappNumber);
      isValid = false;
    }

    // Validate Mobile Number
    if (!/^0\d{9}$/.test(mobileNumber.value)) {
      showError(mobileNumber, errorMessages.mobileNumber);
      isValid = false;
    }

    // Validate Principal Name if School is selected
    if (
      currentWorkplace.value === "school" &&
      !/^[A-Za-z\s.]+$/.test(principleName.value)
    ) {
      showError(principleName, errorMessages.principleName);
      isValid = false;
    }

    // Validate Principal Contact No if School is selected
    if (
      currentWorkplace.value === "school" &&
      !/^0\d{9}$/.test(principleContact.value)
    ) {
      showError(principleContact, errorMessages.principleContact);
      isValid = false;
    }

    // Validate Head of Institute Name if Office is selected
    if (
      (currentWorkplace.value === "provincialOffice" ||
        currentWorkplace.value === "zonalOffice" ||
        currentWorkplace.value === "divisionalOffice") &&
      !/^[A-Za-z\s.]+$/.test(headOfInstitute.value)
    ) {
      showError(headOfInstitute, errorMessages.headOfInstitute);
      isValid = false;
    }

    // Validate Head of Institute Contact No if Office is selected
    if (
      (currentWorkplace.value === "provincialOffice" ||
        currentWorkplace.value === "zonalOffice" ||
        currentWorkplace.value === "divisionalOffice") &&
      !/^0\d{9}$/.test(headContact.value)
    ) {
      showError(headContact, errorMessages.headContact);
      isValid = false;
    }

    if (!isValid) {
      event.preventDefault();
    }
  });
});

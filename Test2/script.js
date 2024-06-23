document.addEventListener("DOMContentLoaded", () => {
  /*
  ======================
  Auto Complete Area
  ======================
  */
  const currentWorkingPlace = document.getElementById("currentWorkingPlace");
  const schoolDetails = document.getElementById("schoolDetails");
  const provincialDetails = document.getElementById("provincialDetails");
  const zonalDetails = document.getElementById("zonalDetails");
  const divisionalDetails = document.getElementById("divisionalDetails");
  const schoolNameInput = document.getElementById("schoolName");
  const selectedSchoolCencode = document.getElementById(
    "selectedSchoolCencode"
  );
  const autocompleteSuggestions = document.getElementById(
    "autocompleteSuggestions"
  );
  const schoolNameError = document.getElementById("schoolNameError");
  const provincialNameInput = document.getElementById("provincialName");
  const autocompleteSuggestionsProvincial = document.getElementById(
    "autocompleteSuggestionsProvincial"
  );
  const provincialNameError = document.getElementById("provincialNameError");
  const zonalNameInput = document.getElementById("zonalName");
  const autocompleteSuggestionsZonal = document.getElementById(
    "autocompleteSuggestionsZonal"
  );
  const zonalNameError = document.getElementById("zonalNameError");
  const divisionalNameInput = document.getElementById("divisionalName");
  const autocompleteSuggestionsDivisional = document.getElementById(
    "autocompleteSuggestionsDivisional"
  );
  const divisionalNameError = document.getElementById("divisionalNameError");
  let selectedSchool = null;
  let selectedProvincial = null;
  let selectedZonal = null;
  let selectedDivisional = null;

  currentWorkingPlace.addEventListener("change", () => {
    // Remove 'required' attribute from all inputs initially
    const inputs = document.querySelectorAll(
      '.workplaceDetails input[type="text"]'
    );
    inputs.forEach((input) => input.removeAttribute("required"));

    // Hide all details sections initially
    schoolDetails.classList.remove("show");
    provincialDetails.classList.remove("show");
    zonalDetails.classList.remove("show");
    divisionalDetails.classList.remove("show");

    // Show details section based on selected value and add 'required' attribute to relevant inputs
    const value = currentWorkingPlace.value;
    if (value === "school") {
      schoolDetails.classList.add("show");
      document
        .getElementById("schoolName")
        .setAttribute("required", "required");
      document
        .getElementById("principleName")
        .setAttribute("required", "required");
      document
        .getElementById("principleContact")
        .setAttribute("required", "required");
    } else if (value === "provincialOffice") {
      provincialDetails.classList.add("show");
      document
        .getElementById("provincialName")
        .setAttribute("required", "required");
      document
        .getElementById("headOfInstituteNameProvincial")
        .setAttribute("required", "required");
      document
        .getElementById("headOfInstituteContactProvincial")
        .setAttribute("required", "required");
    } else if (value === "zonalOffice") {
      zonalDetails.classList.add("show");
      document.getElementById("zonalName").setAttribute("required", "required");
      document
        .getElementById("headOfInstituteNameZonal")
        .setAttribute("required", "required");
      document
        .getElementById("headOfInstituteContactZonal")
        .setAttribute("required", "required");
    } else if (value === "divisionalOffice") {
      divisionalDetails.classList.add("show");
      document
        .getElementById("divisionalName")
        .setAttribute("required", "required");
      document
        .getElementById("headOfInstituteNameDivisional")
        .setAttribute("required", "required");
      document
        .getElementById("headOfInstituteContactDivisional")
        .setAttribute("required", "required");
    }
  });

  const autocompleteHandler = (
    input,
    suggestionsContainer,
    errorContainer,
    type
  ) => {
    input.addEventListener("input", () => {
      const query = input.value;
      if (query.length > 0) {
        fetch("autocomplete.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ query: query, type: type }),
        })
          .then((response) => response.json())
          .then((data) => {
            suggestionsContainer.innerHTML = "";
            data.forEach((item) => {
              const div = document.createElement("div");
              div.classList.add("autocomplete-suggestion");
              div.textContent = `${item.cencode || ""} ${item.institutionname}`;
              div.addEventListener("click", () => {
                input.value = item.institutionname;
                if (type === "school") selectedSchool = item;
                if (type === "provincial") selectedProvincial = item;
                if (type === "zonal") selectedZonal = item;
                if (type === "divisional") selectedDivisional = item;
                suggestionsContainer.innerHTML = "";
              });
              suggestionsContainer.appendChild(div);
            });
            suggestionsContainer.style.display = "block";
          });
      } else {
        suggestionsContainer.innerHTML = "";
        suggestionsContainer.style.display = "none";
      }
    });

    input.addEventListener("blur", () => {
      setTimeout(() => {
        if (
          (type === "school" &&
            (!selectedSchool ||
              input.value !== selectedSchool.institutionname)) ||
          (type === "provincial" &&
            (!selectedProvincial ||
              input.value !== selectedProvincial.institutionname)) ||
          (type === "zonal" &&
            (!selectedZonal ||
              input.value !== selectedZonal.institutionname)) ||
          (type === "divisional" &&
            (!selectedDivisional ||
              input.value !== selectedDivisional.institutionname))
        ) {
          errorContainer.textContent =
            "Please select a valid option from the suggestions.";
          errorContainer.style.display = "block";
          if (type === "school") selectedSchoolCencode.value = "";
        } else {
          errorContainer.textContent = "";
          errorContainer.style.display = "none";
        }
        suggestionsContainer.style.display = "none";
      }, 200);
    });
  };

  autocompleteHandler(
    schoolNameInput,
    autocompleteSuggestions,
    schoolNameError,
    "school"
  );
  autocompleteHandler(
    provincialNameInput,
    autocompleteSuggestionsProvincial,
    provincialNameError,
    "provincial"
  );
  autocompleteHandler(
    zonalNameInput,
    autocompleteSuggestionsZonal,
    zonalNameError,
    "zonal"
  );
  autocompleteHandler(
    divisionalNameInput,
    autocompleteSuggestionsDivisional,
    divisionalNameError,
    "divisional"
  );

  document.getElementById("detailsForm").addEventListener("submit", (event) => {
    if (currentWorkingPlace.value === "school" && !selectedSchool) {
      event.preventDefault();
      schoolNameError.textContent =
        "Please select a valid school from the suggestions.";
      schoolNameError.style.display = "block";
    } else if (
      currentWorkingPlace.value === "provincialOffice" &&
      !selectedProvincial
    ) {
      event.preventDefault();
      provincialNameError.textContent =
        "Please select a valid institute from the suggestions.";
      provincialNameError.style.display = "block";
    } else if (currentWorkingPlace.value === "zonalOffice" && !selectedZonal) {
      event.preventDefault();
      zonalNameError.textContent =
        "Please select a valid institute from the suggestions.";
      zonalNameError.style.display = "block";
    } else if (
      currentWorkingPlace.value === "divisionalOffice" &&
      !selectedDivisional
    ) {
      event.preventDefault();
      divisionalNameError.textContent =
        "Please select a valid institute from the suggestions.";
      divisionalNameError.style.display = "block";
    }
  });

  /*
  ======================
  OTP Verification area
  ======================
  */
  const requestOtpButton = document.getElementById("sendOtp");
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
              otpSection.style.display = "block"; // Display the OTP section
              otpMessage.style.display = "block";
              canRequestOtp = false;
              setTimeout(() => (canRequestOtp = true), 60000); // 1 minute timeout
            } else {
              otpMessage.textContent = "Error sending OTP: " + data.message;
              otpMessage.className = "message error";
              otpMessage.style.display = "block";
              otpSection.style.display = "none"; // Ensure OTP section is hidden on error
            }
          });
      } else {
        otpMessage.textContent = "Please enter a valid email address.";
        otpMessage.className = "message error";
        otpMessage.style.display = "block";
        otpSection.style.display = "none"; // Ensure OTP section is hidden on invalid email
      }
    } else {
      otpMessage.textContent =
        "You must wait 1 minute before requesting another OTP.";
      otpMessage.className = "message error";
      otpMessage.style.display = "block";
      otpSection.style.display = "none"; // Ensure OTP section is hidden if waiting period
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

  /*
  ======================
   Form Validation Area
  ======================
  */

  const detailsForm = document.getElementById("detailsForm");
  // const currentWorkingPlace = document.getElementById("currentWorkingPlace");
  // const schoolDetails = document.getElementById("schoolDetails");
  // const provincialDetails = document.getElementById("provincialDetails");
  // const zonalDetails = document.getElementById("zonalDetails");
  // const divisionalDetails = document.getElementById("divisionalDetails");

  const fullName = document.getElementById("fullName");
  const nameWithInitials = document.getElementById("nameWithInitials");
  const nic = document.getElementById("nic");
  const email = document.getElementById("email");
  const whatsappNumber = document.getElementById("whatsappNumber");
  const mobileNumber = document.getElementById("mobileNumber");

  const principleName = document.getElementById("principleName");
  const principleContact = document.getElementById("principleContact");
  const provincialName = document.getElementById("provincialName");
  const zonalName = document.getElementById("zonalName");
  const divisionalName = document.getElementById("divisionalName");
  const headOfInstituteName = document.getElementById("headOfInstituteName");
  const headOfInstituteContact = document.getElementById(
    "headOfInstituteContact"
  );

  const errorMessages = {
    fullName: "Full Name can only contain letters, spaces, and dots.",
    nameWithInitials:
      "Name with Initials can only contain letters, spaces, and dots.",
    nic: "NIC must be 10 digits ending with 'v' or 'V', or 12 digits of only numbers.",
    email: "Invalid email address.",
    whatsappNumber: "WhatsApp Number must be 10 digits starting with 0.",
    mobileNumber: "Mobile Number must be 10 digits starting with 0.",
    principleName: "Principal Name can only contain letters, spaces, and dots.",
    principleContact: "Principal Contact No must be 10 digits starting with 0.",
    headOfInstituteName:
      "Head of Institute Name can only contain letters, spaces, and dots.",
    headOfInstituteContact:
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
  validateInput(
    nameWithInitials,
    /^[A-Za-z\s.]+$/,
    errorMessages.nameWithInitials
  );
  validateInput(nic, /^(\d{9}[vV]|\d{12})$/, errorMessages.nic);
  validateInput(email, /^[^\s@]+@[^\s@]+\.[^\s@]+$/, errorMessages.email);
  validateInput(whatsappNumber, /^0\d{9}$/, errorMessages.whatsappNumber);
  validateInput(mobileNumber, /^0\d{9}$/, errorMessages.mobileNumber);
  validateInput(principleName, /^[A-Za-z\s.]+$/, errorMessages.principleName);
  validateInput(principleContact, /^0\d{9}$/, errorMessages.principleContact);
  validateInput(
    provincialName,
    /^[A-Za-z\s.]+$/,
    errorMessages.headOfInstituteName
  );
  validateInput(zonalName, /^[A-Za-z\s.]+$/, errorMessages.headOfInstituteName);
  validateInput(
    divisionalName,
    /^[A-Za-z\s.]+$/,
    errorMessages.headOfInstituteName
  );
  validateInput(
    headOfInstituteName,
    /^[A-Za-z\s.]+$/,
    errorMessages.headOfInstituteName
  );
  validateInput(
    headOfInstituteContact,
    /^0\d{9}$/,
    errorMessages.headOfInstituteContact
  );

  function toggleDetails() {
    const selectedValue = currentWorkingPlace.value;
    if (selectedValue === "school") {
      schoolDetails.classList.add("show");
      provincialDetails.classList.remove("show");
      zonalDetails.classList.remove("show");
      divisionalDetails.classList.remove("show");
    } else if (selectedValue === "provincialOffice") {
      schoolDetails.classList.remove("show");
      provincialDetails.classList.add("show");
      zonalDetails.classList.remove("show");
      divisionalDetails.classList.remove("show");
    } else if (selectedValue === "zonalOffice") {
      schoolDetails.classList.remove("show");
      provincialDetails.classList.remove("show");
      zonalDetails.classList.add("show");
      divisionalDetails.classList.remove("show");
    } else if (selectedValue === "divisionalOffice") {
      schoolDetails.classList.remove("show");
      provincialDetails.classList.remove("show");
      zonalDetails.classList.remove("show");
      divisionalDetails.classList.add("show");
    } else {
      schoolDetails.classList.remove("show");
      provincialDetails.classList.remove("show");
      zonalDetails.classList.remove("show");
      divisionalDetails.classList.remove("show");
    }
  }

  currentWorkingPlace.addEventListener("change", toggleDetails);

  detailsForm.addEventListener("submit", (event) => {
    let isValid = true;

    // Validate Full Name
    if (!/^[A-Za-z\s.]+$/.test(fullName.value)) {
      showError(fullName, errorMessages.fullName);
      isValid = false;
    }

    // Validate Name with Initials
    if (!/^[A-Za-z\s.]+$/.test(nameWithInitials.value)) {
      showError(nameWithInitials, errorMessages.nameWithInitials);
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
      currentWorkingPlace.value === "school" &&
      !/^[A-Za-z\s.]+$/.test(principleName.value)
    ) {
      showError(principleName, errorMessages.principleName);
      isValid = false;
    }

    // Validate Principal Contact No if School is selected
    if (
      currentWorkingPlace.value === "school" &&
      !/^0\d{9}$/.test(principleContact.value)
    ) {
      showError(principleContact, errorMessages.principleContact);
      isValid = false;
    }

    // Validate Head of Institute Name if Office is selected
    if (
      (currentWorkingPlace.value === "provincialOffice" ||
        currentWorkingPlace.value === "zonalOffice" ||
        currentWorkingPlace.value === "divisionalOffice") &&
      !/^[A-Za-z\s.]+$/.test(headOfInstituteName.value)
    ) {
      showError(headOfInstituteName, errorMessages.headOfInstituteName);
      isValid = false;
    }

    // Validate Head of Institute Contact No if Office is selected
    if (
      (currentWorkingPlace.value === "provincialOffice" ||
        currentWorkingPlace.value === "zonalOffice" ||
        currentWorkingPlace.value === "divisionalOffice") &&
      !/^0\d{9}$/.test(headOfInstituteContact.value)
    ) {
      showError(headOfInstituteContact, errorMessages.headOfInstituteContact);
      isValid = false;
    }

    if (!isValid) {
      event.preventDefault();
    }
  });

  toggleDetails(); // Initialize on page load
});

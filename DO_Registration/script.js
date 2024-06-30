function showPopup(message, type) {
  const popup = document.getElementById("popup");
  const popupMessage = document.getElementById("popupMessage");
  const popupBox = document.querySelector(".popup-box");
  popupBox.classList.add(type);
  popupMessage.innerText = message;
  popup.classList.add("show");
}

document.addEventListener("DOMContentLoaded", () => {
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
    clearInputs(); // Clear all input fields

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
      schoolNameInput.setAttribute("required", "required");
      document
        .getElementById("principleName")
        .setAttribute("required", "required");
      document
        .getElementById("principleContact")
        .setAttribute("required", "required");
    } else if (value === "provincialOffice") {
      provincialDetails.classList.add("show");
      provincialNameInput.setAttribute("required", "required");
      document
        .getElementById("provincialHeadOfInstituteName")
        .setAttribute("required", "required");
      document
        .getElementById("provincialHeadOfInstituteContact")
        .setAttribute("required", "required");
    } else if (value === "zonalOffice") {
      zonalDetails.classList.add("show");
      zonalNameInput.setAttribute("required", "required");
      document
        .getElementById("zonalHeadOfInstituteName")
        .setAttribute("required", "required");
      document
        .getElementById("zonalHeadOfInstituteContact")
        .setAttribute("required", "required");
    } else if (value === "divisionalOffice") {
      divisionalDetails.classList.add("show");
      divisionalNameInput.setAttribute("required", "required");
      document
        .getElementById("divisionalHeadOfInstituteName")
        .setAttribute("required", "required");
      document
        .getElementById("divisionalHeadOfInstituteContact")
        .setAttribute("required", "required");
    }
  });

  const clearInputs = () => {
    const inputs = document.querySelectorAll(
      '.workplaceDetails input[type="text"]'
    );
    inputs.forEach((input) => (input.value = ""));
  };

  const highlightMatch = (text, query) => {
    const index = text.toLowerCase().indexOf(query.toLowerCase());
    if (index >= 0) {
      return (
        text.substring(0, index) +
        '<span class="highlight">' +
        text.substring(index, index + query.length) +
        "</span>" +
        text.substring(index + query.length)
      );
    }
    return text;
  };

  const fetchAutocompleteData = async (query, type) => {
    try {
      const response = await fetch("autocomplete.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ query, type }),
      });

      if (!response.ok) {
        throw new Error("Network response was not ok");
      }

      const data = await response.json();
      return data;
    } catch (error) {
      console.error("There was a problem with the fetch operation:", error);
      return [];
    }
  };

  const autocompleteHandler = (
    input,
    suggestionsContainer,
    errorContainer,
    type
  ) => {
    input.addEventListener("input", async () => {
      const query = input.value;
      if (query.length > 0) {
        const data = await fetchAutocompleteData(query, type);
        suggestionsContainer.innerHTML = "";
        if (data.length === 0) {
          const noResultsDiv = document.createElement("div");
          noResultsDiv.classList.add("autocomplete-no-results");
          noResultsDiv.textContent = "No institution found with this name.";
          suggestionsContainer.appendChild(noResultsDiv);
        } else {
          data.forEach((item) => {
            const div = document.createElement("div");
            div.classList.add("autocomplete-suggestion");
            div.innerHTML = highlightMatch(
              `${item.New_CenCode || ""} - ${item.New_InstitutionName}`,

              query
            );
            div.addEventListener("click", () => {
              input.value = `${item.New_CenCode || ""} ${
                item.New_InstitutionName
              }`;
              if (type === "school") selectedSchool = item;
              if (type === "provincial") selectedProvincial = item;
              if (type === "zonal") selectedZonal = item;
              if (type === "divisional") selectedDivisional = item;
              suggestionsContainer.innerHTML = "";
            });
            suggestionsContainer.appendChild(div);
          });
        }
        suggestionsContainer.style.display = "block";
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
              input.value !==
                `${selectedSchool.New_CenCode || ""} ${
                  selectedSchool.New_InstitutionName
                }`)) ||
          (type === "provincial" &&
            (!selectedProvincial ||
              input.value !==
                `${selectedProvincial.New_CenCode || ""} ${
                  selectedProvincial.New_InstitutionName
                }`)) ||
          (type === "zonal" &&
            (!selectedZonal ||
              input.value !==
                `${selectedZonal.New_CenCode || ""} ${
                  selectedZonal.New_InstitutionName
                }`)) ||
          (type === "divisional" &&
            (!selectedDivisional ||
              input.value !==
                `${selectedDivisional.New_CenCode || ""} ${
                  selectedDivisional.New_InstitutionName
                }`))
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

  /*
  ======================
  OTP Verification area
  ======================
  */
  const requestOtpButton = document.getElementById("sendOtp");
  const verifyOtpButton = document.getElementById("verifyOtp");
  const otpSection = document.getElementById("otpSection");
  const otpMessage = document.getElementById("otpMessage");
  const otpVerifiedInput = document.getElementById("otpVerified");
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
              otpVerifiedInput.value = "false"; // Reset OTP verification status
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
          otpVerifiedInput.value = "true"; // Set OTP verification status
        } else {
          otpMessage.textContent = "Invalid OTP or OTP expired.";
          otpMessage.className = "message error";
          otpMessage.style.display = "block";
          otpVerifiedInput.value = "false"; // Reset OTP verification status
        }
      });
  });

  document.querySelector("form").addEventListener("submit", (event) => {
    if (otpVerifiedInput.value !== "true") {
      event.preventDefault();
      otpMessage.textContent =
        "Please verify your OTP before submitting the form.";
      otpMessage.className = "message error";
      otpMessage.style.display = "block";
    }
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
  const provincialHeadOfInstituteName = document.getElementById(
    "provincialHeadOfInstituteName"
  );
  const provincialHeadOfInstituteContact = document.getElementById(
    "provincialHeadOfInstituteContact"
  );
  const zonalHeadOfInstituteName = document.getElementById(
    "zonalHeadOfInstituteName"
  );
  const zonalHeadOfInstituteContact = document.getElementById(
    "zonalHeadOfInstituteContact"
  );
  const divisionalHeadOfInstituteName = document.getElementById(
    "divisionalHeadOfInstituteName"
  );
  const divisionalHeadOfInstituteContact = document.getElementById(
    "divisionalHeadOfInstituteContact"
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
    provincialHeadOfInstituteName:
      "Head of Institute Name can only contain letters, spaces, and dots.",
    provincialHeadOfInstituteContact:
      "Head of Institute Contact No must be 10 digits starting with 0.",
    zonalHeadOfInstituteName:
      "Head of Institute Name can only contain letters, spaces, and dots.",
    zonalHeadOfInstituteContact:
      "Head of Institute Contact No must be 10 digits starting with 0.",
    divisionalHeadOfInstituteName:
      "Head of Institute Name can only contain letters, spaces, and dots.",
    divisionalHeadOfInstituteContact:
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
    errorMessages.provincialHeadOfInstituteName
  );
  validateInput(
    zonalName,
    /^[A-Za-z\s.]+$/,
    errorMessages.zonalHeadOfInstituteName
  );
  validateInput(
    divisionalName,
    /^[A-Za-z\s.]+$/,
    errorMessages.divisionalHeadOfInstituteName
  );
  validateInput(
    provincialHeadOfInstituteName,
    /^[A-Za-z\s.]+$/,
    errorMessages.provincialHeadOfInstituteName
  );
  validateInput(
    provincialHeadOfInstituteContact,
    /^0\d{9}$/,
    errorMessages.provincialHeadOfInstituteContact
  );
  validateInput(
    zonalHeadOfInstituteName,
    /^[A-Za-z\s.]+$/,
    errorMessages.zonalHeadOfInstituteName
  );
  validateInput(
    zonalHeadOfInstituteContact,
    /^0\d{9}$/,
    errorMessages.zonalHeadOfInstituteContact
  );
  validateInput(
    divisionalHeadOfInstituteName,
    /^[A-Za-z\s.]+$/,
    errorMessages.divisionalHeadOfInstituteName
  );
  validateInput(
    divisionalHeadOfInstituteContact,
    /^0\d{9}$/,
    errorMessages.divisionalHeadOfInstituteContact
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

    // Validate Head of Institute Name if Provincial Office is selected
    if (
      currentWorkingPlace.value === "provincialOffice" &&
      !/^[A-Za-z\s.]+$/.test(provincialHeadOfInstituteName.value)
    ) {
      showError(
        provincialHeadOfInstituteName,
        errorMessages.provincialHeadOfInstituteName
      );
      isValid = false;
    }

    // Validate Head of Institute Contact No if Provincial Office is selected
    if (
      currentWorkingPlace.value === "provincialOffice" &&
      !/^0\d{9}$/.test(provincialHeadOfInstituteContact.value)
    ) {
      showError(
        provincialHeadOfInstituteContact,
        errorMessages.provincialHeadOfInstituteContact
      );
      isValid = false;
    }

    // Validate Head of Institute Name if Zonal Office is selected
    if (
      currentWorkingPlace.value === "zonalOffice" &&
      !/^[A-Za-z\s.]+$/.test(zonalHeadOfInstituteName.value)
    ) {
      showError(
        zonalHeadOfInstituteName,
        errorMessages.zonalHeadOfInstituteName
      );
      isValid = false;
    }

    // Validate Head of Institute Contact No if Zonal Office is selected
    if (
      currentWorkingPlace.value === "zonalOffice" &&
      !/^0\d{9}$/.test(zonalHeadOfInstituteContact.value)
    ) {
      showError(
        zonalHeadOfInstituteContact,
        errorMessages.zonalHeadOfInstituteContact
      );
      isValid = false;
    }

    // Validate Head of Institute Name if Divisional Office is selected
    if (
      currentWorkingPlace.value === "divisionalOffice" &&
      !/^[A-Za-z\s.]+$/.test(divisionalHeadOfInstituteName.value)
    ) {
      showError(
        divisionalHeadOfInstituteName,
        errorMessages.divisionalHeadOfInstituteName
      );
      isValid = false;
    }

    // Validate Head of Institute Contact No if Divisional Office is selected
    if (
      currentWorkingPlace.value === "divisionalOffice" &&
      !/^0\d{9}$/.test(divisionalHeadOfInstituteContact.value)
    ) {
      showError(
        divisionalHeadOfInstituteContact,
        errorMessages.divisionalHeadOfInstituteContact
      );
      isValid = false;
    }

    if (!isValid) {
      event.preventDefault();
    }
  });

  toggleDetails();
});

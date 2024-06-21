let otpRequestedTime = null;

function handleWorkplaceChange() {
  var workplace = document.getElementById("workplace").value;
  var schoolFields = document.getElementById("schoolFields");
  var ProvincesFields = document.getElementById("ProvincesFields");
  var ZonalFields = document.getElementById("ZonalFields");
  var DivisionalFields = document.getElementById("DivisionalFields");

  // Hide all fields and remove required attributes
  hideFields([schoolFields, ProvincesFields, ZonalFields, DivisionalFields]);

  // Clear all input fields
  clearFields(schoolFields);
  clearFields(ProvincesFields);
  clearFields(ZonalFields);
  clearFields(DivisionalFields);

  var fieldsToMakeRequired = [];
  switch (workplace) {
    case "school":
      schoolFields.classList.remove("hidden");
      fieldsToMakeRequired = ["schoolName"];
      break;
    case "provincial":
      ProvincesFields.classList.remove("hidden");
      fieldsToMakeRequired = ["provinceName"];
      break;
    case "zonal":
      ZonalFields.classList.remove("hidden");
      fieldsToMakeRequired = ["zone"];
      break;
    case "divisional":
      DivisionalFields.classList.remove("hidden");
      fieldsToMakeRequired = ["division"];
      break;
    default:
      break;
  }

  // Add required attributes to visible fields and remove from hidden fields
  toggleRequiredFields(fieldsToMakeRequired);
}

function hideFields(fields) {
  fields.forEach(function (field) {
    field.classList.add("hidden");
  });
}

function clearFields(container) {
  var inputs = container.querySelectorAll("input");
  inputs.forEach(function (input) {
    input.value = "";
  });
}

function toggleRequiredFields(requiredIds) {
  var allInputs = document.querySelectorAll(
    "#schoolFields input, #ProvincesFields input, #ZonalFields input, #DivisionalFields input"
  );

  allInputs.forEach(function (input) {
    if (requiredIds.includes(input.id)) {
      input.setAttribute("required", "required");
    } else {
      input.removeAttribute("required");
    }
  });
}

function sendOtp() {
  var email = document.getElementById("email").value;
  var now = new Date();

  if (otpRequestedTime && now - otpRequestedTime < 60000) {
    showMessage("OTP can only be requested once every minute.", "error");
    return;
  }

  otpRequestedTime = now;

  var xhr = new XMLHttpRequest();
  xhr.open("POST", "send_otp.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        try {
          var response = JSON.parse(xhr.responseText);
          if (response.success) {
            showMessage("OTP sent successfully.", "success");
            document.getElementById("otpSection").classList.remove("hidden");
            document.getElementById("submitBtn").disabled = true;
          } else {
            showMessage("Failed to send OTP.", "error");
          }
        } catch (e) {
          console.error("Error parsing JSON response:", e);
          showMessage("Unexpected server response.", "error");
        }
      } else {
        console.error("Request failed. Status:", xhr.status);
        showMessage("Request failed. Please try again.", "error");
      }
    }
  };

  xhr.send("email=" + encodeURIComponent(email));
}

function verifyOtp() {
  var email = document.getElementById("email").value;
  var otp = document.getElementById("otp").value;
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "verify_otp.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      try {
        var response = JSON.parse(xhr.responseText);
        if (response.success) {
          showMessage("OTP verified successfully.", "success");
          document.getElementById("submitBtn").disabled = false;
        } else {
          showMessage("Invalid OTP. Please try again.", "error");
          document.getElementById("submitBtn").disabled = true;
        }
      } catch (e) {
        console.error("Error parsing JSON response:", e);
        showMessage("Unexpected server response.", "error");
      }
    }
  };
  xhr.send(
    "email=" + encodeURIComponent(email) + "&otp=" + encodeURIComponent(otp)
  );
}

function submitForm(event) {
  event.preventDefault();
  var form = document.getElementById("registrationForm");
  var formData = new FormData(form);

  var workplace = document.getElementById("workplace").value;

  if (workplace !== "school") {
    formData.set("schoolName", null);
    formData.set("principleName", null);
    formData.set("principleContactNo", null);
  }

  if (workplace !== "provincial") {
    formData.set("provinceName", null);
    formData.set("headOfInstituteName", null);
    formData.set("headOfInstituteContactNo", null);
  }

  if (workplace !== "zonal") {
    formData.set("zone", null);
    formData.set("headOfInstituteName", null);
    formData.set("headOfInstituteContactNo", null);
  }

  if (workplace !== "divisional") {
    formData.set("division", null);
    formData.set("headOfInstituteName", null);
    formData.set("headOfInstituteContactNo", null);
  }

  var xhr = new XMLHttpRequest();
  xhr.open("POST", "submit_form.php", true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        try {
          var response = JSON.parse(xhr.responseText);
          if (response.success) {
            showMessage("Form submitted successfully!", "success");
            form.reset();
            document.getElementById("otpSection").classList.add("hidden");
            document.getElementById("submitBtn").disabled = true;
          } else {
            showMessage(
              "Failed to submit the form. Please try again.",
              "error"
            );
          }
        } catch (e) {
          console.error("Error parsing JSON response:", e);
          showMessage("Unexpected server response.", "error");
        }
      } else {
        console.error("Request failed. Status:", xhr.status);
        showMessage("Request failed. Please try again.", "error");
      }
    }
  };
  xhr.send(formData);
}

function showMessage(message, type) {
  var otpMessage = document.getElementById("otpMessage");
  otpMessage.innerText = message;
  otpMessage.className = "message " + type;
  otpMessage.style.display = "block";
}

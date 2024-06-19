let otpRequestedTime = null;

function handleWorkplaceChange() {
  var workplace = document.getElementById("workplace").value;
  var schoolFields = document.getElementById("schoolFields");
  var ProvincesFields = document.getElementById("ProvincesFields");
  var ZonalFields = document.getElementById("ZonalFields");
  var DivisionalFields = document.getElementById("DivisionalFields");

  // Hide all fields and remove required attributes
  schoolFields.classList.add("hidden");
  ProvincesFields.classList.add("hidden");
  ZonalFields.classList.add("hidden");
  DivisionalFields.classList.add("hidden");

  // Clear all input fields
  clearFields(schoolFields);
  clearFields(ProvincesFields);
  clearFields(ZonalFields);
  clearFields(DivisionalFields);

  var fieldsToMakeRequired = [];
  if (workplace === "school") {
    schoolFields.classList.remove("hidden");
    fieldsToMakeRequired = ["schoolName"];
  } else if (workplace === "provincial") {
    ProvincesFields.classList.remove("hidden");
    fieldsToMakeRequired = ["provinceName"];
  } else if (workplace === "zonal") {
    ZonalFields.classList.remove("hidden");
    fieldsToMakeRequired = ["zone"];
  } else if (workplace === "divisional") {
    DivisionalFields.classList.remove("hidden");
    fieldsToMakeRequired = ["division"];
  }

  // Add required attributes to visible fields and remove from hidden fields
  document
    .querySelectorAll(
      "#schoolFields input, #ProvincesFields input, #ZonalFields input, #DivisionalFields input"
    )
    .forEach(function (input) {
      if (fieldsToMakeRequired.includes(input.id)) {
        input.setAttribute("required", "required");
      } else {
        input.removeAttribute("required");
      }
    });
}

function clearFields(container) {
  var inputs = container.querySelectorAll("input");
  inputs.forEach(function (input) {
    input.value = "";
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
    if (xhr.readyState === 4 && xhr.status === 200) {
      var response = JSON.parse(xhr.responseText);
      if (response.success) {
        showMessage("OTP sent successfully.", "success");
        document.getElementById("otpSection").classList.remove("hidden");
        document.getElementById("submitBtn").disabled = true;
      } else {
        showMessage("Failed to send OTP.", "error");
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
      var response = JSON.parse(xhr.responseText);
      if (response.success) {
        showMessage("OTP verified successfully.", "success");
        document.getElementById("submitBtn").disabled = false;
      } else {
        showMessage("Invalid OTP. Please try again.", "error");
        document.getElementById("submitBtn").disabled = true;
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
    if (xhr.readyState === 4 && xhr.status === 200) {
      var response = JSON.parse(xhr.responseText);
      if (response.success) {
        alert("Form submitted successfully!");
        form.reset();
        document.getElementById("otpSection").classList.add("hidden");
        document.getElementById("otpMessage").style.display = "none";
        document.getElementById("submitBtn").disabled = true;
      } else {
        alert("Failed to submit the form. Please try again.");
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

// Debugging to check form submission
document
  .getElementById("registrationForm")
  .addEventListener("submit", function (event) {
    console.log("Form submitted");
    submitForm(event);
  });

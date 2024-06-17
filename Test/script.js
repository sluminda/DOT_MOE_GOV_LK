let selectedSchool = false;
let otpSent = false;

function fetchSuggestions(query) {
  if (query.length == 0) {
    document.getElementById("suggestions").style.display = "none";
    document.getElementById("submitBtn").disabled = true;
    document.getElementById("error-message").style.display = "none";
    selectedSchool = false;
    return;
  }

  var xhr = new XMLHttpRequest();
  xhr.open("GET", "fetch_suggestions.php?q=" + encodeURIComponent(query), true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      var response = JSON.parse(xhr.responseText);
      var suggestions = document.getElementById("suggestions");
      suggestions.innerHTML = "";
      selectedSchool = false;
      if (response.length > 0) {
        response.forEach(function (item) {
          var div = document.createElement("div");
          div.innerHTML =
            highlightMatch(item.cencode, query) +
            " - " +
            highlightMatch(item.institutionname, query);
          div.onclick = function () {
            document.getElementById("school").value =
              item.cencode + " - " + item.institutionname;
            suggestions.style.display = "none";
            selectedSchool = true;
            if (otpSent) {
              document.getElementById("submitBtn").disabled = false;
            }
            document.getElementById("error-message").style.display = "none";
          };
          suggestions.appendChild(div);
        });
        suggestions.style.display = "block";
      } else {
        suggestions.style.display = "none";
        document.getElementById("submitBtn").disabled = true;
        showErrorMessage();
      }
    }
  };
  xhr.send();
}

function highlightMatch(text, query) {
  var regex = new RegExp("(" + query + ")", "gi");
  return text.replace(regex, "<span class='highlight'>$1</span>");
}

document.getElementById("school").addEventListener("input", function () {
  if (!selectedSchool) {
    document.getElementById("submitBtn").disabled = true;
    showErrorMessage();
  }
});

document.getElementById("school").addEventListener("blur", function () {
  document.getElementById("suggestions").style.display = "none";
});

function showErrorMessage() {
  var errorMessage = document.getElementById("error-message");
  errorMessage.innerText = "Please select a valid school from the suggestions.";
  errorMessage.style.display = "block";
}

function handleWorkplaceChange() {
  var workplace = document.getElementById("workplace").value;
  var schoolFields = document.getElementById("schoolFields");
  var officeFields = document.getElementById("officeFields");

  schoolFields.classList.add("hidden");
  officeFields.classList.add("hidden");

  if (workplace === "school") {
    schoolFields.classList.remove("hidden");
  } else if (
    workplace === "provincial" ||
    workplace === "divisional" ||
    workplace === "zonal"
  ) {
    officeFields.classList.remove("hidden");
  }
}

function sendOtp() {
  var email = document.getElementById("email").value;
  if (validateEmail(email)) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "send_otp.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
        var response = JSON.parse(xhr.responseText);
        if (response.success) {
          document.getElementById("otpSection").classList.remove("hidden");
          otpSent = true;
        } else {
          showErrorMessage(
            "otp-error",
            "Failed to send OTP. Please try again."
          );
        }
      }
    };
    xhr.send("email=" + encodeURIComponent(email));
  } else {
    showErrorMessage("otp-error", "Invalid email address.");
  }
}

function verifyOtp() {
  var otp = document.getElementById("otp").value;
  if (otp.length === 6 && /^[0-9]+$/.test(otp)) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "verify_otp.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
        var response = JSON.parse(xhr.responseText);
        if (response.success) {
          document.getElementById("otpSection").classList.add("hidden");
          if (selectedSchool) {
            document.getElementById("submitBtn").disabled = false;
          }
        } else {
          showErrorMessage("otp-error", "Invalid OTP. Please try again.");
        }
      }
    };
    xhr.send("otp=" + encodeURIComponent(otp));
  } else {
    showErrorMessage("otp-error", "OTP should be 6 digits.");
  }
}

function showErrorMessage(elementId, message) {
  var errorMessage = document.getElementById(elementId);
  errorMessage.innerText = message;
  errorMessage.style.display = "block";
}

document
  .getElementById("registrationForm")
  .addEventListener("input", function () {
    var fullName = document.getElementById("fullName").value;
    var initials = document.getElementById("initials").value;
    var nic = document.getElementById("nic").value;
    var email = document.getElementById("email").value;
    var whatsapp = document.getElementById("whatsapp").value;
    var phone = document.getElementById("phone").value;

    if (
      fullName &&
      initials &&
      validateNic(nic) &&
      validateEmail(email) &&
      validatePhone(whatsapp) &&
      validatePhone(phone) &&
      selectedSchool &&
      otpSent
    ) {
      document.getElementById("submitBtn").disabled = false;
    } else {
      document.getElementById("submitBtn").disabled = true;
    }
  });

function validateEmail(email) {
  var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return re.test(email);
}

function validateNic(nic) {
  var re = /^([0-9]{9}[Vv]|[0-9]{12})$/;
  return re.test(nic);
}

function validatePhone(phone) {
  var re = /^0[0-9]{9}$/;
  return re.test(phone);
}

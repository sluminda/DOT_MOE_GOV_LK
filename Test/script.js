let selectedSchool = false;
let otpRequestedTime = null;

function fetchSuggestions(query) {
  if (query.length === 0) {
    document.getElementById("suggestions").style.display = "none";
    document.getElementById("submitBtn").disabled = true;
    document.getElementById("error-message").style.display = "none";
    selectedSchool = false;
    return;
  }

  var xhr = new XMLHttpRequest();
  xhr.open("GET", "fetch_suggestions.php?q=" + encodeURIComponent(query), true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
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
            document.getElementById("submitBtn").disabled = false;
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
  var regex = new RegExp(`(${query})`, "gi");
  return text.replace(regex, "<span class='highlight'>$1</span>");
}

document.getElementById("school").addEventListener("input", function () {
  if (!selectedSchool) {
    document.getElementById("submitBtn").disabled = true;
    showErrorMessage();
  }
});

document.addEventListener("click", function (event) {
  var suggestions = document.getElementById("suggestions");
  var schoolInput = document.getElementById("school");
  if (
    !schoolInput.contains(event.target) &&
    !suggestions.contains(event.target)
  ) {
    suggestions.style.display = "none";
  }
});

function showErrorMessage() {
  var errorMessage = document.getElementById("error-message");
  errorMessage.innerText = "Please select a valid school from the suggestions.";
  errorMessage.style.display = "block";
}

function handleWorkplaceChange() {
  var workplace = document.getElementById("workplace").value;
  var schoolFields = document.getElementById("schoolFields");
  var ProvincesFields = document.getElementById("ProvincesFields");
  var ZonalFields = document.getElementById("ZonalFields");
  var DivisionalFields = document.getElementById("DivisionalFields");

  schoolFields.classList.add("hidden");
  ProvincesFields.classList.add("hidden");
  ZonalFields.classList.add("hidden");
  DivisionalFields.classList.add("hidden");

  if (workplace === "school") {
    schoolFields.classList.remove("hidden");
  } else if (workplace === "provincial") {
    ProvincesFields.classList.remove("hidden");
  } else if (workplace === "divisional") {
    DivisionalFields.classList.remove("hidden");
  } else if (workplace === "zonal") {
    ZonalFields.classList.remove("hidden");
  }
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

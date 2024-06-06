// Province and District mapping
const provinceDistrictMap = {
  "Central Province": ["Kandy", "Matale", "Nuwara Eliya"],
  "Eastern Province": ["Ampara", "Batticaloa", "Trincomalee"],
  "Northern Province": [
    "Jaffna",
    "Kilinochchi",
    "Mannar",
    "Mullaitivu",
    "Vavuniya",
  ],
  "Southern Province": ["Galle", "Hambantota", "Matara"],
  "Western Province": ["Colombo", "Gampaha", "Kalutara"],
  "North Western Province": ["Kurunegala", "Puttalam"],
  "North Central Province": ["Anuradhapura", "Polonnaruwa"],
  "Uva Province": ["Badulla", "Monaragala"],
  "Sabaragamuwa Province": ["Kegalle", "Ratnapura"],
};

document.getElementById("province").addEventListener("change", function () {
  const province = this.value;
  const districtSelect = document.getElementById("district");

  // Clear previous options
  districtSelect.innerHTML =
    '<option value="" disabled selected>Select District</option>';

  if (province) {
    // Enable the district dropdown
    districtSelect.disabled = false;

    // Populate district options based on selected province
    provinceDistrictMap[province].forEach((district) => {
      const option = document.createElement("option");
      option.value = district;
      option.textContent = district;
      districtSelect.appendChild(option);
    });
  } else {
    // Disable the district dropdown if no province is selected
    districtSelect.disabled = true;
  }
});

function validateForm() {
  let valid = true;

  // Input elements
  let fullName = document.getElementById("fullName");
  let nameWithInitials = document.getElementById("nameWithInitials");
  let nic = document.getElementById("nic");
  let schoolSensusNo = document.getElementById("schoolSensusNo");
  let contactNo = document.getElementById("contactNo");

  // Error message elements
  let fullNameError = document.getElementById("fullName-error");
  let nameWithInitialsError = document.getElementById("nameWithInitials-error");
  let nicError = document.getElementById("nic-error");
  let schoolSensusNoError = document.getElementById("schoolSensusNo-error");
  let contactNoError = document.getElementById("contactNo-error");

  // Reset error messages
  fullNameError.style.display = "none";
  nameWithInitialsError.style.display = "none";
  nicError.style.display = "none";
  schoolSensusNoError.style.display = "none";
  contactNoError.style.display = "none";

  // Reset error styles
  fullName.classList.remove("input-error");
  nameWithInitials.classList.remove("input-error");
  nic.classList.remove("input-error");
  schoolSensusNo.classList.remove("input-error");
  contactNo.classList.remove("input-error");

  // Validate fullName
  if (!/^[a-zA-Z ]*$/.test(fullName.value.trim())) {
    fullNameError.style.display = "block";
    fullNameError.textContent = "Only letters allowed";
    fullName.classList.add("input-error");
    valid = false;
  }

  // Validate nameWithInitials
  if (!/^[a-zA-Z. ]*$/.test(nameWithInitials.value.trim())) {
    nameWithInitialsError.style.display = "block";
    nameWithInitialsError.textContent = "Only letters & dots allowed";
    nameWithInitials.classList.add("input-error");
    valid = false;
  }

  // Validate nic
  if (!/^[0-9A-Za-z]{9,12}$/.test(nic.value.trim())) {
    nicError.style.display = "block";
    nicError.textContent = "NIC must be 9-12 letters and numbers.";
    nic.classList.add("input-error");
    valid = false;
  }

  // Validate schoolSensusNo
  if (!/^[0-9A-Za-z]{1,7}$/.test(schoolSensusNo.value.trim())) {
    schoolSensusNoError.style.display = "block";
    schoolSensusNoError.textContent = " Number must be a maximum of 7 letters.";
    schoolSensusNo.classList.add("input-error");
    valid = false;
  }

  // Validate contactNo
  if (!/^0[0-9]{9}$/.test(contactNo.value.trim())) {
    contactNoError.style.display = "block";
    contactNoError.textContent = "Number must be 10 digits and start with 0.";
    contactNo.classList.add("input-error");
    valid = false;
  }

  return valid;
}

document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector(".login-form");

  // Load data from local storage if available
  const formData = JSON.parse(localStorage.getItem("formData"));
  if (formData) {
    for (const key in formData) {
      if (formData.hasOwnProperty(key) && form[key]) {
        form[key].value = formData[key];
      }
    }
  }

  // Save data to local storage on form input
  form.addEventListener("input", function () {
    const data = {};
    new FormData(form).forEach((value, key) => (data[key] = value));
    localStorage.setItem("formData", JSON.stringify(data));
  });

  // Clear local storage on form submit
  form.addEventListener("submit", function () {
    localStorage.removeItem("formData");
  });
});

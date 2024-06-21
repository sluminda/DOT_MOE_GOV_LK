document.addEventListener("DOMContentLoaded", function () {
  // Get all input elements
  const inputs = document.querySelectorAll(
    "#registrationForm input, #registrationForm select"
  );

  // Load saved data from LocalStorage
  inputs.forEach((input) => {
    const savedValue = localStorage.getItem(input.id);
    if (savedValue) {
      input.value = savedValue;
    }
  });

  // Save data to LocalStorage on input change
  inputs.forEach((input) => {
    input.addEventListener("input", () => {
      localStorage.setItem(input.id, input.value);
    });
  });

  // Clear LocalStorage on form submission
  document.getElementById("registrationForm").addEventListener("submit", () => {
    inputs.forEach((input) => {
      localStorage.removeItem(input.id);
    });
  });
});

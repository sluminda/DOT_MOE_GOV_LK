$(document).ready(function () {
  $("#login-form").on("submit", function (event) {
    event.preventDefault(); // Prevent the default form submission

    var formData = $(this).serialize(); // Serialize the form data

    $.ajax({
      type: "POST",
      url: "login.php", // Ensure this path is correct
      data: formData,
      dataType: "json",
      success: function (response) {
        console.log(response); // Debugging line to check response
        if (response.status === "success") {
          console.log("Redirecting to: " + response.redirect);
          window.location.href = response.redirect; // Redirect on successful login
        } else {
          $("#error-message").text(response.message); // Show error message
        }
      },
      error: function (xhr, status, error) {
        console.error(xhr.responseText); // Debugging line to check error response
        $("#error-message").text("An error occurred. Please try again."); // Handle AJAX errors
      },
    });
  });
});

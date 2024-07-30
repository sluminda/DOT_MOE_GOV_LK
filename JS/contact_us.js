document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("contactForm");
  form.addEventListener("submit", function (event) {
    event.preventDefault();

    grecaptcha.ready(function () {
      grecaptcha
        .execute("6LeuTxsqAAAAAMK3lncv_yQ2_lpFguZ0fnRGQssx", {
          action: "submit",
        })
        .then(function (token) {
          document.getElementById("g-recaptcha-response").value = token;

          const formData = new FormData(form);

          fetch("./send_inquiry.php", {
            method: "POST",
            body: formData,
          })
            .then((response) => response.json())
            .then((data) => {
              if (data.success) {
                showPopup(
                  "Your inquiry has been received and a confirmation email has been sent to your email.",
                  "success"
                );
              } else {
                showPopup(
                  "There was an error submitting your inquiry. Please try again.",
                  "error"
                );
              }
            })
            .catch((error) => {
              showPopup(
                "There was an error submitting your inquiry. Please try again.",
                "error"
              );
            });
        });
    });
  });
});

function showPopup(message, type) {
  const popup = document.getElementById("popup");
  const popupMessage = document.getElementById("popupMessage");
  const popupBox = document.querySelector(".popup-box");
  popupBox.classList.add(type);
  popupMessage.innerText = message;
  popup.classList.add("show");
}

function closePopup() {
  const popup = document.getElementById("popup");
  popup.classList.remove("show");
  setTimeout(() => {
    window.location.href = "index.html";
  }, 500);
}

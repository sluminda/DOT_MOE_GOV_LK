$(document).ready(function () {
  $("#send-otp").click(function () {
    const email = $("#email").val();
    if (email) {
      $.post("send_otp.php", { email: email }, function (data) {
        const response = JSON.parse(data);
        if (response.success) {
          alert("OTP sent successfully.");
        } else {
          alert(response.message);
        }
      });
    } else {
      alert("Please enter your email.");
    }
  });

  $("#verify-otp").click(function () {
    const otp = $("#otp").val();
    if (otp) {
      $.post("verify_otp.php", { otp: otp }, function (data) {
        const response = JSON.parse(data);
        if (response.success) {
          $("#otp-status")
            .text("OTP verified successfully")
            .css("color", "green");
        } else {
          $("#otp-status").text(response.message).css("color", "red");
        }
      });
    } else {
      alert("Please enter the OTP.");
    }
  });

  $("#working_place").change(function () {
    const value = $(this).val();
    if (value === "School") {
      $("#school-section").removeClass("hidden");
      $("#office-section").addClass("hidden");
    } else if (
      value === "Provincial Office" ||
      value === "Divisional Office" ||
      value === "Zonal Office"
    ) {
      $("#office-section").removeClass("hidden");
      $("#school-section").addClass("hidden");
    } else {
      $("#school-section").addClass("hidden");
      $("#office-section").addClass("hidden");
    }
  });

  $("#school_search").on("input", function () {
    const query = $(this).val();
    if (query.length > 1) {
      $.post("fetch_schools.php", { query: query }, function (data) {
        const schools = JSON.parse(data);
        let list = "";
        const regex = new RegExp(`(${query})`, "gi");
        schools.forEach((school) => {
          const institutionname = school.institutionname.replace(
            regex,
            '<span class="highlight">$1</span>'
          );
          list += `<li data-cencode="${school.cencode}" data-institutionname="${school.institutionname}">${school.cencode} - ${institutionname}</li>`;
        });
        $("#autocomplete-results").html(list).show();
      });
    } else {
      $("#autocomplete-results").hide();
    }
  });

  $(document).on("click", "#autocomplete-results li", function () {
    const cencode = $(this).data("cencode");
    const institutionname = $(this).data("institutionname");
    $("#school_search").val(`${cencode} - ${institutionname}`);
    $("#autocomplete-results").hide();
  });

  $(document).on("click", function (e) {
    if (!$(e.target).closest("#school_search, #autocomplete-results").length) {
      $("#autocomplete-results").hide();
    }
  });

  $("#registration-form").on("submit", function (e) {
    e.preventDefault();
    const form = $(this);
    const formData = form.serialize();
    $.post("register.php", formData, function (data) {
      const response = JSON.parse(data);
      if (response.success) {
        alert("Registration successful.");
      } else {
        alert(response.message);
      }
    });
  });
});

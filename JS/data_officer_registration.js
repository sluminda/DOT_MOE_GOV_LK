$(document).ready(function () {
  $("#workingPlace").change(function () {
    if ($(this).val() == "School") {
      $("#schoolDetails").show();
    } else {
      $("#schoolDetails").hide();
    }
  });

  $("#schoolName").on("input", function () {
    let query = $(this).val();
    if (query.length >= 3) {
      $.ajax({
        url: "search_school.php",
        method: "GET",
        data: { query: query },
        success: function (data) {
          // Handle suggestion logic here (e.g., showing a dropdown list)
          console.log(data);
        },
      });
    }
  });

  $("#division").on("change", function () {
    let division = $(this).val();
    $.ajax({
      url: "get_zone_province.php",
      method: "GET",
      data: { division: division },
      success: function (data) {
        data = JSON.parse(data);
        $("#zone").val(data.zone);
        $("#province").val(data.province);
      },
    });
  });
});

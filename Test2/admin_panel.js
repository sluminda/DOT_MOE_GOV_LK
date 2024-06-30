$(document).ready(function () {
  let currentTable = "workplace_details";

  function loadTable(data) {
    let columns = [
      { data: "fullName", title: "Full Name" },
      { data: "nic", title: "NIC" },
      { data: "email", title: "Email" },
      { data: "whatsappNumber", title: "WhatsApp" },
      { data: "mobileNumber", title: "Mobile" },
      { data: "headOfInstituteName", title: "Head of Institute" },
      { data: "headOfInstituteContactNo", title: "Institute Contact" },
      { data: "currentWorkingPlace", title: "Working Place" },
      { data: "selectedInstituteCode", title: "Institute Code" },
      { data: "selectedInstituteName", title: "Institute Name" },
      { data: "Province", title: "Province" },
      { data: "District", title: "District" },
      { data: "Zone", title: "Zone" },
      { data: "Division", title: "Division" },
      { data: "submittedAt", title: "Submitted At" },
    ];

    $("#tableContainer").html(
      '<table id="resultTable" class="table table-striped table-bordered"></table>'
    );
    $("#resultTable").DataTable({
      data: data,
      columns: columns,
      destroy: true,
    });
  }

  $("#searchBtn").click(function () {
    $.post(
      "admin_panel.php",
      {
        action: "search",
        name: $("#searchName").val(),
        nic: $("#searchNIC").val(),
        from_date: $("#searchFromDate").val(),
        to_date: $("#searchToDate").val(),
        working_place: $("#searchWorkingPlace").val(),
        institute_code: $("#searchInstituteCode").val(),
        institute_name: $("#searchInstituteName").val(),
        table: currentTable,
      },
      function (response) {
        let data = JSON.parse(response);
        loadTable(data);
      }
    );
  });

  $("#resetBtn").click(function () {
    $("#searchForm")[0].reset();
  });

  $("#switchTableBtn").click(function () {
    currentTable =
      currentTable === "workplace_details"
        ? "workplace_details_history"
        : "workplace_details";
    $("#searchBtn").click(); // Re-trigger search to load the new table
  });

  $("#exportBtn").click(function () {
    $.post("admin_panel.php", {
      action: "export",
      table: currentTable,
    });
  });

  $(".toggle-column").change(function () {
    let column = $("#resultTable").DataTable().column($(this).data("column"));
    column.visible(!column.visible());
  });
});

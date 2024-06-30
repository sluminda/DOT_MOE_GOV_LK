$(document).ready(function () {
  let currentPage = 1;

  function getVisibleColumns() {
    return $(".columnToggle:checked")
      .map(function () {
        return $(this).val();
      })
      .get();
  }

  function fetchData(page = 1) {
    const filters = {
      name: $("#name").val(),
      nic: $("#nic").val(),
      submittedAt_start: $("#submittedAt_start").val(),
      submittedAt_end: $("#submittedAt_end").val(),
      currentWorkingPlace: $("#currentWorkingPlace").val(),
      selectedInstituteName: $("#selectedInstituteName").val(),
      page: page,
      table: $("#tableSelect").val() === "history" ? "history" : "current",
    };

    $.get("fetch_data.php", filters, function (response) {
      try {
        const data = JSON.parse(response);
        currentPage = data.page;
        $("#currentPage").text(currentPage);

        const tbody = $("#dataTable tbody");
        tbody.empty();

        data.data.forEach((row) => {
          let rowHtml = "<tr>";
          getVisibleColumns().forEach((column) => {
            rowHtml += `<td class="${column}">${row[column]}</td>`;
          });
          rowHtml += "</tr>";
          tbody.append(rowHtml);
        });
      } catch (e) {
        console.error("Error parsing JSON response: ", response);
      }
    }).fail(function (jqXHR, textStatus, errorThrown) {
      console.error("Request failed: ", textStatus, errorThrown);
    });
  }

  $("#filterBtn").click(function () {
    fetchData();
  });

  $("#prevPage").click(function () {
    if (currentPage > 1) {
      fetchData(currentPage - 1);
    }
  });

  $("#nextPage").click(function () {
    fetchData(currentPage + 1);
  });

  $("#exportBtn").click(function () {
    const filters = {
      name: $("#name").val(),
      nic: $("#nic").val(),
      submittedAt_start: $("#submittedAt_start").val(),
      submittedAt_end: $("#submittedAt_end").val(),
      currentWorkingPlace: $("#currentWorkingPlace").val(),
      selectedInstituteName: $("#selectedInstituteName").val(),
      columns: getVisibleColumns().join(","),
      table: $("#tableSelect").val() === "history" ? "history" : "current",
    };

    let queryString = $.param(filters);
    window.location.href = "export_csv.php?" + queryString;
  });

  $(".columnToggle").change(function () {
    const column = $(this).val();
    if ($(this).is(":checked")) {
      $(`.${column}`).show();
    } else {
      $(`.${column}`).hide();
    }
  });

  // Initial fetch
  fetchData();
});

$(document).ready(function () {
  let currentPage = 1;
  let totalPages = 1;

  // Helper function to format date to ISO string with time set to 00:00:00
  function formatDateStart(date) {
    return date ? new Date(date).toISOString().split("T")[0] + " 00:00:00" : "";
  }

  // Helper function to format date to ISO string with time set to 23:59:59
  function formatDateEnd(date) {
    return date ? new Date(date).toISOString().split("T")[0] + " 23:59:59" : "";
  }

  // Function to get visible columns based on checkboxes
  function getVisibleColumns() {
    return $(".columnToggle:checked")
      .map(function () {
        return $(this).val();
      })
      .get();
  }

  // Function to fetch data based on current filters and pagination
  function fetchData(page = 1) {
    const filters = {
      name: $("#name").val(),
      nic: $("#nic").val(),
      submittedAt_start: formatDateStart($("#submittedAt_start").val()),
      submittedAt_end: formatDateEnd($("#submittedAt_end").val()),
      currentWorkingPlace: $("#currentWorkingPlace").val(),
      selectedInstituteCode: $("#selectedInstituteCode").val(),
      selectedInstituteName: $("#selectedInstituteName").val(),
      province: $("#province").val(),
      district: $("#district").val(),
      zone: $("#zone").val(),
      division: $("#division").val(),
      page: page,
      table: $("#tableSelect").val() === "history" ? "history" : "current",
    };

    $.get("fetch_data.php", filters, function (response) {
      try {
        const data = JSON.parse(response);
        currentPage = parseInt(data.page);
        totalPages = parseInt(data.totalPages);
        updatePaginationUI();

        const tbody = $("#dataTable tbody");
        tbody.empty();

        data.data.forEach((row) => {
          let rowHtml = "<tr>";
          getVisibleColumns().forEach((column) => {
            rowHtml += `<td class="${column}">${row[column]}</td>`;
          });
          if ($("#tableSelect").val() !== "history") {
            rowHtml += `<td class="actions">
                          <button class="btn btn-danger btn-sm deleteBtn" data-id="${row.id}">Delete</button>
                        </td>`;
          }
          rowHtml += "</tr>";
          tbody.append(rowHtml);
        });

        // Re-bind delete button click event after updating table rows
        bindDeleteButtonEvent();
      } catch (e) {
        console.error("Error parsing JSON response: ", response);
      }
    }).fail(function (jqXHR, textStatus, errorThrown) {
      console.error("Request failed: ", textStatus, errorThrown);
    });
  }

  // Function to bind delete button click event
  function bindDeleteButtonEvent() {
    $(".deleteBtn")
      .off("click")
      .on("click", function () {
        const id = $(this).data("id");
        if (confirm("Are you sure you want to delete this row?")) {
          $.post("delete_row.php", { id: id }, function (response) {
            fetchData(currentPage);
          });
        }
      });
  }

  // Function to update pagination UI with current page and total pages
  function updatePaginationUI() {
    $("#currentPage").text(`${currentPage}/${totalPages}`);
  }

  // Function to toggle visibility of "Actions" column based on table selection
  function toggleActionsColumn() {
    if ($("#tableSelect").val() === "history") {
      $(".actions").hide();
    } else {
      $(".actions").show();
    }
  }

  // Event listener for filter button click
  $("#filterBtn").click(function () {
    currentPage = 1; // Reset current page when applying new filters
    fetchData();
  });

  // Event listener for first page button click
  $("#firstPage").click(function () {
    if (currentPage > 1) {
      currentPage = 1;
      fetchData(currentPage);
    }
  });

  // Event listener for last page button click
  $("#lastPage").click(function () {
    if (currentPage < totalPages) {
      currentPage = totalPages;
      fetchData(currentPage);
    }
  });

  // Event listener for previous page button click
  $("#prevPage").click(function () {
    if (currentPage > 1) {
      fetchData(currentPage - 1);
    }
  });

  // Event listener for next page button click
  $("#nextPage").click(function () {
    if (currentPage < totalPages) {
      fetchData(currentPage + 1);
    }
  });

  // Event listener for export button click
  $("#exportBtn").click(function () {
    const filters = {
      name: $("#name").val(),
      nic: $("#nic").val(),
      submittedAt_start: formatDateStart($("#submittedAt_start").val()),
      submittedAt_end: formatDateEnd($("#submittedAt_end").val()),
      currentWorkingPlace: $("#currentWorkingPlace").val(),
      selectedInstituteCode: $("#selectedInstituteCode").val(),
      selectedInstituteName: $("#selectedInstituteName").val(),
      province: $("#province").val(),
      district: $("#district").val(),
      zone: $("#zone").val(),
      division: $("#division").val(),
      columns: getVisibleColumns().join(","),
      table: $("#tableSelect").val() === "history" ? "history" : "current",
    };

    let queryString = $.param(filters);
    window.location.href = "export_csv.php?" + queryString;
  });

  // Event listener for column toggle change
  $(".columnToggle").change(function () {
    const column = $(this).val();
    if ($(this).is(":checked")) {
      $(`.${column}`).show();
    } else {
      $(`.${column}`).hide();
    }
  });

  // Event listener for real-time filtering on input change
  $(".filter-input").on("input", function () {
    currentPage = 1; // Reset current page when applying new filters
    fetchData();
  });

  // Event listener for table selection change
  $("#tableSelect").change(function () {
    fetchData();
    toggleActionsColumn();
  });

  // Initial fetch of data and setup
  fetchData();
  toggleActionsColumn();
});

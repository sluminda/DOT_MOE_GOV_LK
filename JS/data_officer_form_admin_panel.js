$(document).ready(function () {
  let currentPage = 1;
  let totalPages = 1;

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
      // Debug output
      console.log("Fetch Data Response:", response);
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
      } catch (e) {
        console.error("Error parsing JSON response: ", response);
      }
    }).fail(function (jqXHR, textStatus, errorThrown) {
      console.error("Request failed: ", textStatus, errorThrown);
    });
  }

  $("#filterBtn").click(function () {
    currentPage = 1; // Reset current page when applying new filters
    fetchData();
  });

  $("#exportBtn").click(function () {
    const filters = {
      name: $("#name").val(),
      nic: $("#nic").val(),
      submittedAt_start: $("#submittedAt_start").val(),
      submittedAt_end: $("#submittedAt_end").val(),
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

  $(".columnToggle").change(function () {
    const column = $(this).val();
    if ($(this).is(":checked")) {
      $(`.${column}`).show();
    } else {
      $(`.${column}`).hide();
    }
  });

  $(document).on("click", ".deleteBtn", function () {
    const id = $(this).data("id");
    if (confirm("Are you sure you want to delete this row?")) {
      $.post("delete_row.php", { id: id }, function (response) {
        fetchData(currentPage);
      });
    }
  });

  function updatePaginationUI() {
    $("#currentPage").text(`${currentPage}/${totalPages}`);
  }

  $("#firstPage").click(function () {
    if (currentPage > 1) {
      currentPage = 1;
      fetchData(currentPage);
    }
  });

  $("#lastPage").click(function () {
    if (currentPage < totalPages) {
      currentPage = totalPages;
      fetchData(currentPage);
    }
  });

  function toggleActionsColumn() {
    if ($("#tableSelect").val() === "history") {
      $(".actions").hide();
    } else {
      $(".actions").show();
    }
  }

  $(".filter-input").on("input", function () {
    currentPage = 1; // Reset current page when applying new filters
    fetchData();
  });

  fetchData();
  toggleActionsColumn();

  $("#tableSelect").change(function () {
    fetchData();
    toggleActionsColumn();
  });
});

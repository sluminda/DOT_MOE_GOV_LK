let selectedSchool = false;

function fetchSuggestions(query) {
  if (query.length == 0) {
    document.getElementById("suggestions").style.display = "none";
    document.getElementById("submitBtn").disabled = true;
    document.getElementById("error-message").style.display = "none";
    selectedSchool = false;
    return;
  }

  var xhr = new XMLHttpRequest();
  xhr.open("GET", "fetch_suggestions.php?q=" + encodeURIComponent(query), true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      var response = JSON.parse(xhr.responseText);
      var suggestions = document.getElementById("suggestions");
      suggestions.innerHTML = "";
      selectedSchool = false;
      if (response.length > 0) {
        response.forEach(function (item) {
          var div = document.createElement("div");
          div.innerHTML =
            highlightMatch(item.cencode, query) +
            " - " +
            highlightMatch(item.institutionname, query);
          div.onclick = function () {
            document.getElementById("school").value =
              item.cencode + " - " + item.institutionname;
            suggestions.style.display = "none";
            selectedSchool = true;
            document.getElementById("submitBtn").disabled = false;
            document.getElementById("error-message").style.display = "none";
          };
          suggestions.appendChild(div);
        });
        suggestions.style.display = "block";
      } else {
        suggestions.style.display = "none";
        document.getElementById("submitBtn").disabled = true;
        showErrorMessage();
      }
    }
  };
  xhr.send();
}

function highlightMatch(text, query) {
  var regex = new RegExp(`(${query})`, "gi");
  return text.replace(regex, "<span class='highlight'>$1</span>");
}

document.getElementById("school").addEventListener("input", function () {
  if (!selectedSchool) {
    document.getElementById("submitBtn").disabled = true;
    showErrorMessage();
  }
});

document.addEventListener("click", function (event) {
  var suggestions = document.getElementById("suggestions");
  var schoolInput = document.getElementById("school");
  if (
    !schoolInput.contains(event.target) &&
    !suggestions.contains(event.target)
  ) {
    suggestions.style.display = "none";
  }
});

function showErrorMessage() {
  var errorMessage = document.getElementById("error-message");
  errorMessage.innerText = "Please select a valid school from the suggestions.";
  errorMessage.style.display = "block";
}

function handleWorkplaceChange() {
  var workplace = document.getElementById("workplace").value;
  var schoolFields = document.getElementById("schoolFields");
  var officeFields = document.getElementById("officeFields");

  schoolFields.classList.add("hidden");
  officeFields.classList.add("hidden");

  if (workplace === "school") {
    schoolFields.classList.remove("hidden");
  } else if (
    workplace === "provincial" ||
    workplace === "divisional" ||
    workplace === "zonal"
  ) {
    officeFields.classList.remove("hidden");
  }
}

let selectedDivision = false;

function fetchSuggestions_Division(query) {
  if (query.length === 0) {
    document.getElementById("divisional-suggestions").style.display = "none";
    document.getElementById("submitBtn").disabled = true;
    document.getElementById("error-message-division").style.display = "none";
    selectedDivision = false;
    return;
  }

  var xhr = new XMLHttpRequest();
  xhr.open(
    "GET",
    "fetch_suggestions_division.php?q=" + encodeURIComponent(query),
    true
  );
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var response = JSON.parse(xhr.responseText);
      var suggestions = document.getElementById("divisional-suggestions");
      suggestions.innerHTML = "";
      selectedDivision = false;
      if (response.length > 0) {
        response.forEach(function (item) {
          var div = document.createElement("div");
          div.innerHTML = highlightMatch(item, query);
          div.onclick = function () {
            document.getElementById("division").value = item;
            suggestions.style.display = "none";
            selectedDivision = true;
            document.getElementById("submitBtn").disabled = false;
            document.getElementById("error-message-division").style.display =
              "none";
          };
          suggestions.appendChild(div);
        });
        suggestions.style.display = "block";
      } else {
        suggestions.style.display = "none";
        document.getElementById("submitBtn").disabled = true;
        showDivisionErrorMessage();
      }
    }
  };
  xhr.send();
}

function highlightMatch(text, query) {
  var regex = new RegExp(`(${query})`, "gi");
  return text.replace(regex, "<span class='highlight'>$1</span>");
}

document.getElementById("division").addEventListener("input", function () {
  if (!selectedDivision) {
    document.getElementById("submitBtn").disabled = true;
    showDivisionErrorMessage();
  }
});

document.addEventListener("click", function (event) {
  var suggestions = document.getElementById("divisional-suggestions");
  var divisionInput = document.getElementById("division");
  if (
    !divisionInput.contains(event.target) &&
    !suggestions.contains(event.target)
  ) {
    suggestions.style.display = "none";
  }
});

function showDivisionErrorMessage() {
  var errorMessage = document.getElementById("error-message-division");
  errorMessage.innerText =
    "Please select a valid Divisional Office from the suggestions.";
  errorMessage.style.display = "block";
}

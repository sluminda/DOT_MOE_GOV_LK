let selectedZone = false;

function fetchSuggestions_Zone(query) {
  if (query.length === 0) {
    document.getElementById("zonal-suggestions").style.display = "none";
    document.getElementById("submitBtn").disabled = true;
    document.getElementById("error-message-zone").style.display = "none";
    selectedZone = false;
    return;
  }

  var xhr = new XMLHttpRequest();
  xhr.open(
    "GET",
    "fetch_suggestions_zone.php?q=" + encodeURIComponent(query),
    true
  );
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var response = JSON.parse(xhr.responseText);
      var suggestions = document.getElementById("zonal-suggestions");
      suggestions.innerHTML = "";
      selectedZone = false;
      if (response.length > 0) {
        response.forEach(function (item) {
          var div = document.createElement("div");
          div.innerHTML = highlightMatch(item, query);
          div.onclick = function () {
            document.getElementById("zone").value = item;
            suggestions.style.display = "none";
            selectedZone = true;
            document.getElementById("submitBtn").disabled = false;
            document.getElementById("error-message-zone").style.display =
              "none";
          };
          suggestions.appendChild(div);
        });
        suggestions.style.display = "block";
      } else {
        suggestions.style.display = "none";
        document.getElementById("submitBtn").disabled = true;
        showZoneErrorMessage();
      }
    }
  };
  xhr.send();
}

function highlightMatch(text, query) {
  var regex = new RegExp(`(${query})`, "gi");
  return text.replace(regex, "<span class='highlight'>$1</span>");
}

document.getElementById("zone").addEventListener("input", function () {
  if (!selectedZone) {
    document.getElementById("submitBtn").disabled = true;
    showZoneErrorMessage();
  }
});

document.addEventListener("click", function (event) {
  var suggestions = document.getElementById("zonal-suggestions");
  var zoneInput = document.getElementById("zone");
  if (
    !zoneInput.contains(event.target) &&
    !suggestions.contains(event.target)
  ) {
    suggestions.style.display = "none";
  }
});

function showZoneErrorMessage() {
  var errorMessage = document.getElementById("error-message-zone");
  errorMessage.innerText =
    "Please select a valid Zonal Office from the suggestions.";
  errorMessage.style.display = "block";
}

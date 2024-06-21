let selectedProvince = false;

function fetchSuggestions_Province(query) {
  if (query.length === 0) {
    document.getElementById("provincial-suggestions").style.display = "none";
    document.getElementById("submitBtn").disabled = true;
    document.getElementById("error-message-province").style.display = "none";
    selectedProvince = false;
    return;
  }

  var xhr = new XMLHttpRequest();
  xhr.open(
    "GET",
    "fetch_suggestions_province.php?q=" + encodeURIComponent(query),
    true
  );
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var response = JSON.parse(xhr.responseText);
      var suggestions = document.getElementById("provincial-suggestions");
      suggestions.innerHTML = "";
      selectedProvince = false;
      if (response.length > 0) {
        response.forEach(function (item) {
          var div = document.createElement("div");
          div.innerHTML = highlightMatch(item, query);
          div.onclick = function () {
            document.getElementById("provinceName").value = item;
            suggestions.style.display = "none";
            selectedProvince = true;
            document.getElementById("submitBtn").disabled = false;
            document.getElementById("error-message-province").style.display =
              "none";
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

document.getElementById("provinceName").addEventListener("input", function () {
  fetchSuggestions_Province(this.value); // Fetch suggestions on input change
  if (!selectedProvince) {
    document.getElementById("submitBtn").disabled = true;
    showErrorMessage();
  }
});

document.addEventListener("click", function (event) {
  var suggestions = document.getElementById("provincial-suggestions");
  var provinceInput = document.getElementById("provinceName");
  if (
    !provinceInput.contains(event.target) &&
    !suggestions.contains(event.target)
  ) {
    suggestions.style.display = "none";
  }
});

function showErrorMessage() {
  var errorMessage = document.getElementById("error-message-province");
  errorMessage.innerText =
    "Please select a valid Province from the suggestions.";
  errorMessage.style.display = "block";
}

function fetchSuggestions(query) {
  if (query.length == 0) {
    document.getElementById("suggestions").style.display = "none";
    return;
  }

  var xhr = new XMLHttpRequest();
  xhr.open("GET", "fetch_suggestions.php?q=" + encodeURIComponent(query), true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      var response = JSON.parse(xhr.responseText);
      var suggestions = document.getElementById("suggestions");
      suggestions.innerHTML = "";
      if (response.length > 0) {
        response.forEach(function (item) {
          var div = document.createElement("div");
          div.innerHTML = highlightMatch(item, query);
          div.onclick = function () {
            document.getElementById("school").value = item;
            suggestions.style.display = "none";
          };
          suggestions.appendChild(div);
        });
        suggestions.style.display = "block";
      } else {
        suggestions.style.display = "none";
      }
    }
  };
  xhr.send();
}

function highlightMatch(text, query) {
  var regex = new RegExp(`(${query})`, "gi");
  return text.replace(regex, "<span class='highlight'>$1</span>");
}

function removeUser(username) {
  if (confirm("Are you sure you want to remove this user?")) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "remove_user.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
        if (response.success) {
          document.getElementById("user-" + username).remove();
        } else {
          alert("Failed to remove user.");
        }
      }
    };
    xhr.send("username=" + encodeURIComponent(username));
  }
}

document.getElementById("year2023").addEventListener("click", function () {
  document
    .querySelector(".census_btns_container.CC")
    .classList.remove("hidden");
  document.querySelector(".census_btns_container.DD").classList.add("hidden");
});

document.getElementById("year2022").addEventListener("click", function () {
  document.querySelector(".census_btns_container.CC").classList.add("hidden");
  document
    .querySelector(".census_btns_container.DD")
    .classList.remove("hidden");
});

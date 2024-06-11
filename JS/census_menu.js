document.addEventListener("DOMContentLoaded", () => {
  const year2023 = document.getElementById("year2023");
  const year2022 = document.getElementById("year2022");
  const census2023 = document.querySelector(".census_btns_container.CC");
  const census2022 = document.querySelector(".census_btns_container.DD");

  year2023.addEventListener("click", function () {
    year2023.classList.add("selected");
    year2022.classList.remove("selected");
    census2023.classList.remove("hidden");
    census2022.classList.add("hidden");
  });

  year2022.addEventListener("click", function () {
    year2022.classList.add("selected");
    year2023.classList.remove("selected");
    census2022.classList.remove("hidden");
    census2023.classList.add("hidden");
  });
});

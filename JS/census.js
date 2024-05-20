const headerOne = document.querySelector(".header_1");
const headerTwo = document.querySelector(".header_2");

const navOne = document.querySelector(".nav_1");
const navTwo = document.querySelector(".nav_2");

headerOne.addEventListener("click", (e) => {
  if (navOne.classList.contains("hidden_transition")) {
    navOne.classList.remove("hidden_transition");
    navOne.classList.add("show_transition");
  } else {
    navOne.classList.add("hidden_transition");
    navOne.classList.remove("show_transition");
  }

  navTwo.classList.add("hidden_transition");
});

headerTwo.addEventListener("click", (e) => {
  if (navTwo.classList.contains("hidden_transition")) {
    navTwo.classList.remove("hidden_transition");
    navTwo.classList.remove("hidden_transition");
  } else {
    navTwo.classList.add("hidden_transition");
  }

  navOne.classList.add("hidden_transition");
  navOne.classList.remove("show_transition");
});

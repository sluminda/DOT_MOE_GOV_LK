let mobile_nav_open = document.querySelector(".open");
let mobile_nav_close = document.querySelector(".close");
let mobile_nav = document.querySelector(".mobile-nav");

let logo1_white = document.querySelector(".mbglc1");
let logo1_dark = document.querySelector(".mbglc2");

let logo2_white = document.querySelector(".dolc1");
let logo2_dark = document.querySelector(".dolc2");

mobile_nav_open.addEventListener("click", () => {
  mobile_nav_open.classList.add("hidden");
  mobile_nav_close.classList.remove("hidden");
  mobile_nav.classList.remove("hidden-effect");
});

mobile_nav_close.addEventListener("click", () => {
  mobile_nav_open.classList.remove("hidden");
  mobile_nav_close.classList.add("hidden");
  mobile_nav.classList.add("hidden-effect");
});

// Dark Mode
const toggleSwitch = document.querySelector(
  '.theme-switch input[type="checkbox"]'
);

function switchTheme(e) {
  if (e.target.checked) {
    document.documentElement.setAttribute("data-theme", "dark");
    logo1_white.classList.add("hidden");
    logo1_dark.classList.remove("hidden");

    logo2_white.classList.add("hidden");
    logo2_dark.classList.remove("hidden");
  } else {
    document.documentElement.setAttribute("data-theme", "light");
    logo1_white.classList.remove("hidden");
    logo1_dark.classList.add("hidden");

    logo2_white.classList.remove("hidden");
    logo2_dark.classList.add("hidden");
  }
}

toggleSwitch.addEventListener("change", switchTheme, false);

let mobile_nav_open = document.querySelector(".open");
let mobile_nav_close = document.querySelector(".close");
let mobile_nav = document.querySelector(".mobile-nav");

let logo1_white = document.querySelector(".mbglc1");
let logo1_dark = document.querySelector(".mbglc2");

let logo2_white = document.querySelector(".dolc1");
let logo2_dark = document.querySelector(".dolc2");

let dark_mode = document.querySelector(".mode1");
let white_mode = document.querySelector(".mode2");

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

const toggleSwitch = document.querySelector(
  '.theme-switch input[type="checkbox"]'
);

function switchTheme(e) {
  const darkModeEnabled = e.target.checked;
  if (darkModeEnabled) {
    enableDarkMode();
  } else {
    enableLightMode();
  }
}

function enableDarkMode() {
  document.documentElement.setAttribute("data-theme", "dark");
  toggleSwitch.checked = true;
  logo1_white.classList.add("hidden");
  logo1_dark.classList.remove("hidden");
  logo2_white.classList.add("hidden");
  logo2_dark.classList.remove("hidden");

  localStorage.setItem("theme", "dark");
}

function enableLightMode() {
  document.documentElement.setAttribute("data-theme", "light");
  toggleSwitch.checked = false;
  logo1_white.classList.remove("hidden");
  logo1_dark.classList.add("hidden");
  logo2_white.classList.remove("hidden");
  logo2_dark.classList.add("hidden");

  localStorage.setItem("theme", "light");
}

// Check for saved theme preference in localStorage
const currentTheme = localStorage.getItem("theme");
if (currentTheme) {
  if (currentTheme === "dark") {
    enableDarkMode();
  } else {
    enableLightMode();
  }
} else {
  // Check if user's system prefers dark mode
  if (
    window.matchMedia &&
    window.matchMedia("(prefers-color-scheme: dark)").matches
  ) {
    enableDarkMode();
  }
}

toggleSwitch.addEventListener("change", switchTheme, false);

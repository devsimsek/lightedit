const sidebar_open = document.querySelector("#ld_sidebar_open")
const sidebar_close = document.querySelector("#ld_sidebar_close")
const sidebar = document.querySelector("#ld_sidebar")
const themeToggler = document.querySelector("#ld_toggle_theme")
const fullscreenToggler = document.querySelector("#ld_fullscreen")
const date = document.querySelector("#ft_date")
const clock = document.querySelector("#ft_clock")

let current_date = new Date()
date.innerText = current_date.toDateString()

sidebar_open.addEventListener("click", () => {
  sidebar.style.display = "block"
  sidebar.style.animationName = "fade-in"
})
sidebar_close.addEventListener("click", () => {
  sidebar.style.animationName = "fade-out"
  setTimeout(() => {
    sidebar.style.display = "none"
  }, 200)
})
themeToggler.addEventListener("click", () => {
  if (getActiveTheme() === "light") {
    setActiveTheme("dark")
    document.querySelector("html").dataset.bsTheme = "dark"
    themeToggler.innerHTML = `<button class="btn rounded"><i class="bi bi-sun"></i></button>`
    if (!document.body.classList.contains("dark-theme")) {
      document.body.classList.toggle("dark-theme");
    }
  } else {
    setActiveTheme("light")
    themeToggler.innerHTML = `<button class="btn rounded"><i class="bi bi-moon"></i></button>`
    document.querySelector("html").dataset.bsTheme = "light"
    if (document.body.classList.contains("dark-theme")) {
      document.body.classList.remove("dark-theme");
    }
  }
})
fullscreenToggler.addEventListener("click", () => {
  if (document.fullscreenElement) {
    if (document.exitFullscreen) {
      document.exitFullscreen();
    } else if (document.mozCancelFullScreen) {
      document.mozCancelFullScreen();
    } else if (document.webkitExitFullscreen) {
      document.webkitExitFullscreen();
    } else if (document.msExitFullscreen) {
      document.msExitFullscreen();
    }
  } else {
    const elem = document.documentElement;
    if (elem.requestFullscreen) {
      elem.requestFullscreen();
    } else if (elem.mozRequestFullScreen) {
      elem.mozRequestFullScreen();
    } else if (elem.webkitRequestFullscreen) {
      elem.webkitRequestFullscreen();
    } else if (elem.msRequestFullscreen) {
      elem.msRequestFullscreen();
    }
  }
})

function initTables() {
  const tables = document.querySelectorAll("table")
  tables.forEach(table => {
    const dataTable = new simpleDatatables.DataTable(table, {
      searchable: true,
      fixedHeight: true,
    });
  })
}

function initTheme() {
  if (getActiveTheme() === "light") {
    themeToggler.innerHTML = `<button class="btn rounded"><i class="bi bi-moon"></i></button>`
    if (document.body.classList.contains("dark-theme")) {
      document.body.classList.remove("dark-theme");
      document.querySelector("html").dataset.bsTheme = "light"
    }
  } else {
    themeToggler.innerHTML = `<button class="btn rounded"><i class="bi bi-sun"></i></button>`
    if (!document.body.classList.contains("dark-theme")) {
      document.body.classList.toggle("dark-theme");
      document.querySelector("html").dataset.bsTheme = "dark"
    }
  }
}

function setActiveTheme(theme) {
  localStorage.setItem("theme", theme);
  return theme
}

function getActiveTheme() {
  return localStorage.getItem("theme") ?? setActiveTheme("light");
}

function displayClock() {
  const date = new Date();
  const hours = date.getHours();
  const minutes = date.getMinutes();
  clock.textContent = `${hours}:${minutes}`;
}

setInterval(displayClock, 1000);

initTheme();
initTables();

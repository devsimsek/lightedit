let themeToggler = document.querySelector("#ld_toggle_theme")

themeToggler.addEventListener("click", () => {
  if (getActiveTheme() === "light") {
    setActiveTheme("dark")
    document.body.dataset.bsTheme = 'dark'
    themeToggler.innerHTML = `<i class="bi bi-sun"></i>`
    window.location.reload()
  } else {
    setActiveTheme("light")
    themeToggler.innerHTML = `<i class="bi bi-moon"></i>`
    document.body.dataset.bsTheme = 'light'
    window.location.reload()
  }
})

let canvas = document.querySelector('.ld_background');
if (canvas) {
  canvas.width = window.innerWidth;
  canvas.height = window.innerHeight;
  let ctx = canvas.getContext('2d');
  for (let i = 0; i < 120; i++) {
    let rad = Math.floor(Math.random() * (20 - 3 + 1) + 3);
    let x = Math.random() * canvas.width;
    let y = Math.random() * canvas.height;
    let r = Math.floor(Math.random() * 256);
    let g = Math.floor(Math.random() * 256);
    let b = Math.floor(Math.random() * 256);
    ctx.beginPath();
    ctx.arc(x, y, rad, 0, 2 * Math.PI);
    ctx.fillStyle = 'rgb(' + r + ', ' + g + ', ' + b + ')';
    ctx.fill();
  }
}


function initTheme() {
  if (getActiveTheme() === "light") {
    themeToggler.innerHTML = `<i class="bi bi-moon"></i>`
    document.body.classList.remove("dark-theme");
    document.body.dataset.bsTheme = 'light'
  } else {
    themeToggler.innerHTML = `<i class="bi bi-sun"></i>`
    document.body.classList.toggle("dark-theme");
    document.body.dataset.bsTheme = 'dark'
  }
}

function setActiveTheme(theme) {
  localStorage.setItem("theme", theme);
  return theme
}

function getActiveTheme() {
  return localStorage.getItem("theme") ?? setActiveTheme("light");
}

function updatePreview() {
  if ((document.querySelector("#username").value).length >= 1)
    document.getElementById("namepreview").innerText = " @" + document.querySelector("#username").value
  else
    document.getElementById("namepreview").innerText = ""
}

if (document.getElementById("username")) {
  document.getElementById("username").addEventListener("input", updatePreview);
}

initTheme();

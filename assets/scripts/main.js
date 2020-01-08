const settingsButton = document.querySelector(".settingsButton");
const settings = document.querySelector(".settings");
const followButton = document.querySelector(".followButton");

settingsButton.addEventListener("click", event => {
  settings.classList.toggle("change");
});

settingsButton.addEventListener("click", event => {
  settingsButton.classList.toggle("rotate");
});




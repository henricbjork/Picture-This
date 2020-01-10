const settingsButton = document.querySelector(".settingsButton");
const settings = document.querySelector(".settings");
const followButton = document.querySelector(".followButton");

if (settingsButton != null) {
  settingsButton.addEventListener("click", event => {
    settings.classList.toggle("change");
  });
}
if (settingsButton != null) {
  settingsButton.addEventListener("click", event => {
    settingsButton.classList.toggle("rotate");
  });
}

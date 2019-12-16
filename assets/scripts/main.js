const settingsButton = document.querySelector('.settingsButton');
const settings = document.querySelector('.settings');

settingsButton.addEventListener('click', event => {
    settings.classList.toggle('change')
});
settingsButton.addEventListener("click", event => {
  settingsButton.classList.toggle("rotate");
});

const settingsButton = document.querySelector('.settingsButton');
const settings = document.querySelector('.settings');
const likeButtons = document.querySelectorAll('.like')

settingsButton.addEventListener('click', event => {
    settings.classList.toggle('change')
});
settingsButton.addEventListener('click', event => {
  settingsButton.classList.toggle("rotate");
});
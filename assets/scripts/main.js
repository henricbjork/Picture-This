const settingsButton = document.querySelector(".settingsButton");
const settings = document.querySelector(".settings");
const followButton = document.querySelector(".followButton");

console.log(settingsButton)
followButton.textContent = 'Follow';

followButton.addEventListener("click", event => {
  followButton.textContent = "Unfollow";
});

if (settingsButton !== null) {

settingsButton.addEventListener("click", event => {
  settings.classList.toggle("change");
});

}

settingsButton.addEventListener("click", event => {
  settingsButton.classList.toggle("rotate");
});




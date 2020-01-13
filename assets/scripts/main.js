const settingsButton = document.querySelector(".settingsButton");
const settings = document.querySelector(".settings");
const followButton = document.querySelector(".followButton");
const likeForms = document.querySelectorAll(".likeForm");

likeForms.forEach(likeForm => {
  likeForm.addEventListener("submit", event => {
    event.preventDefault();
    const likeButton = likeForm.childNodes[3];
    //Toggle between filled or unfilled icon on click
    if (likeButton.classList.contains("likeButton--unliked")) {
      likeButton.classList.toggle("likeButton--unliked");
      likeButton.classList.toggle("likeButton--liked");
    } else if (likeButton.classList.contains("likeButton--liked")) {
      likeButton.classList.toggle("likeButton--unliked");
      likeButton.classList.toggle("likeButton--liked");
    }
    const formData = new FormData(likeForm);
    fetch("/app/posts/like.php", {
      method: "POST",
      body: formData
    })
      .then(response => response.json())
      .then(likes => {
        //Update likes
        let currentLikes = likeForm.lastElementChild;
        if (likes[0] > 0) {
          currentLikes.textContent = `${likes[0]} likes this`;
        } else {
          currentLikes.textContent = "";
        }
      });
  });
});
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

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

const commentForms = document.querySelectorAll(".commentFormComment");

if (commentForms) {
  commentForms.forEach(form => {
    form.addEventListener("submit", event => {
      event.preventDefault();

      const formData = new FormData(form);

      fetch("/app/posts/comment.php", {
        method: "POST",
        body: formData
      })
        .then(response => response.json())
        .then(json => {
          const parent = form.parentNode;
          const template = `
              <div class="avatarCommentEditDeleteContainer">
              <div>
              <a href="profile.php?id=${json.userId}">${json.username}</a>
              <p class="comment-string">${json.comment}</p>
              </div>
              <form class="commentFormDelete" action="#">
              <input type="hidden" name="id" value="${json.commentId}">
              <button class="commentButton" type="submit">Delete</button>
              </form>
              </div>`;

          parent.querySelector(".commentInnerContainer").innerHTML += template;

          form.querySelector(".commentTextarea").value = "";
          activateEditComments();
          editComment();
          deleteComment();
        })
        .catch(console.error);
    });
  });
}

function deleteComment() {
  const forms = document.querySelectorAll(".commentFormDelete");
  forms.forEach(form => {
    form.addEventListener("submit", event => {
      event.preventDefault();

      const formData = new FormData(form);

      fetch("/app/posts/deleteComment.php", {
        method: "POST",
        body: formData
      })
        .then(response => response.json())
        .then(json => {
          const parent = form.parentNode;
          parent.remove();
        });
    });
  });
}

deleteComment();

function editComment() {
  const forms = document.querySelectorAll(".commentFormEdit");
  forms.forEach(form => {
    form.addEventListener("submit", event => {
      event.preventDefault();

      const formData = new FormData(form);

      fetch("/app/posts/editComment.php", {
        method: "POST",
        body: formData
      })
        .then(response => response.json())
        .then(json => {
          const parent = form.parentNode;
          parent.querySelector(".commentString").innerHTML = json.comment;
          form.querySelector(".commentEditInput").remove();
          form.querySelector(".commentButton").remove();

          const template = `
          <button class="commentButtonEdit">Edit</button>
          `;
          parent.innerHTML += template;
          activateEditComments();
        });
    });
  });
}

function activateEditComments() {
  const editcomments = document.querySelectorAll(".commentButtonEdit");
  editcomments.forEach(comment => {
    comment.addEventListener("click", event => {
      const parent = comment.parentNode;

      const template = `
      <input class="commentEditInput" type="type" name="comment">
      <button class="commentButton" type="submit">Edit</button>
      `;

      parent.querySelector(".commentFormEdit").innerHTML += template;

      comment.remove();

      editComment();
    });
  });
}
activateEditComments();

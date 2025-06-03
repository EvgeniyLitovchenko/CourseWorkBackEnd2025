function previewAvatar(event) {
  const input = event.target;
  const preview = document.getElementById("new-avatar-preview");
  const container = document.getElementById("new-avatar-container");
  container.classList.remove("d-none");

  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function (e) {
      preview.src = e.target.result;
      preview.classList.remove("d-none");
    };
    reader.readAsDataURL(input.files[0]);
  } else {
    preview.src = "#";
    preview.classList.add("d-none");
  }
}
function removeAvatar() {
  const preview = document.getElementById("new-avatar-preview");
  const container = document.getElementById("new-avatar-container");
  const input = document.getElementById("avatar");

  preview.src = "#";
  preview.classList.add("d-none");
  container.classList.add("d-none");
  input.value = "";
}

const initialState = {
  username: "",
  email: "",
};

window.addEventListener("DOMContentLoaded", () => {
  initialState.username = document.getElementById("username").value;
  initialState.email = document.getElementById("email").value;
});

function enableEditing() {
  const usernameInput = document.getElementById("username");
  const emailInput = document.getElementById("email");
  const avatarInput = document.getElementById("avatar");

  [usernameInput, emailInput, avatarInput].forEach(
    (input) => (input.disabled = false)
  );

  document.getElementById("saveBtn").disabled = false;
  document.getElementById("editBtn").disabled = true;
  document.getElementById("cancelBtn").classList.remove("d-none");

  [usernameInput, emailInput].forEach((input) => {
    input.addEventListener("input", () =>
      input.classList.add("input-highlight")
    );
  });
  avatarInput.addEventListener("change", () =>
    avatarInput.classList.add("input-highlight")
  );
}

function cancelEditing() {
  const usernameInput = document.getElementById("username");
  const emailInput = document.getElementById("email");
  const avatarInput = document.getElementById("avatar");

  usernameInput.value = initialState.username;
  emailInput.value = initialState.email;
  avatarInput.value = "";
  document.getElementById("new-avatar-container")?.classList.add("d-none");
  document.getElementById("new-avatar-preview")?.classList.add("d-none");

  [usernameInput, emailInput, avatarInput].forEach((input) => {
    input.disabled = true;
    input.classList.remove("input-highlight");
  });

  document.getElementById("saveBtn").disabled = true;
  document.getElementById("editBtn").disabled = false;
  document.getElementById("cancelBtn").classList.add("d-none");
}

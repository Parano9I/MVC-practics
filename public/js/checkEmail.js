const emailIFieldWrapper = document.querySelector("#email-field");
emailInput = emailIFieldWrapper.querySelector(".input-field");

emailInput.addEventListener("focusout", function (event) {
  const email = event.target.value;
  const errorElem = document.querySelector(".email-field-msg");

  if (errorElem) errorElem.remove();
  if (!email) {
    renderErrorMsg("Empty field");
  } else {
    fetch("/user/check-email", {
      method: "POST",
      headers: {
        "Content-Type": "application/json;charset=utf-8",
      },
      body: JSON.stringify({ email: email }),
    })
      .then((data) => {
        if (data.status === 403) {
          return data.json();
        } else return false;
      })
      .then((data) => {
        if (data) {
          renderErrorMsg(data.error, errorElem);
        }
      });
  }
});

function renderErrorMsg(msg, errorElem) {
  if (!errorElem) {
    const div = document.createElement("div");
    div.classList.add("error-msg");
    div.classList.add("email-field-msg");
    div.innerHTML = msg;
    emailIFieldWrapper.after(div);
  } else errorElem.innerHTML = msg;
}

const _serialize = ($form, id = null) => {
  let res = "";
  const $el = $form.querySelectorAll("input, textarea");

  if ($el.length)
    for (let i = 0; i < $el.length; i++) {
      const name = $el[i].getAttribute("name");
      const val = encodeURI($el[i].value);
      res += i === 0 ? `${name}=${val}` : `&${name}=${val}`;
    }

  if (id) res += `&id=${id}`;

  return res;
};

const _printErrors = (block, errors) => {
  block.innerHTML = "";

  errors &&
    errors.length &&
    errors.forEach((error) => {
      block.innerHTML += `<li>${error}</li>`;
    });
};

const _clear = ($form) => {
  const $el = $form.querySelectorAll("input, textarea");

  if ($el.length)
    for (let i = 0; i < $el.length; i++) {
      $el[i].value = "";
    }
};

const formSender = () => {
  const forms = document.querySelectorAll(".jsForm");

  forms &&
    forms.forEach((form) => {

      form.addEventListener("submit", async function (e) {

        e.preventDefault();

        const id = this.getAttribute("id");
        const method = this.getAttribute("method");
        const url = this.getAttribute("action");

        const body = this.method === "post" ? _serialize(this, id) : {};

        const res = await fetch(url, {
          method,
          headers: {
            "Content-Type": "application/x-www-form-urlencoded; charset=utf-8",
          },
          body,
          credentials: "same-origin",
        });

        const resJson = await res.json();
        if (resJson && resJson.type && resJson.type === "auth") {

          if (resJson.success) {
            if (resJson.id === "forgot_pass") {
              const popup = document.querySelector(".alertMsg");

              popup.classList.add("act");
            } else if (resJson.id === "restore_pass") {
              location.href = "/login";
            } else {
              const RegPopup = document.getElementById("popup-success-register");
              if (typeof(RegPopup) != 'undefined' && RegPopup != null)
              {
                function WaitReg() {
                  location.href = resJson.route;
                }
                setTimeout(WaitReg, 1000);
                RegPopup.classList.add("act");
              } else {
                location.href = resJson.route;
              }

            }

          }

          const errorBlock = document.querySelector(".errorBlock");
          const errorList = document.querySelector(".errorList");

          errorBlock && errorBlock.removeAttribute("hidden");

          _printErrors(errorList, resJson.errors);
        }

        if (resJson && resJson.id === "order") {
          if (resJson.success) {
            document.querySelector(".orderId").textContent = resJson.orderId;
            document.querySelector(".popupSuccess").classList.add("act");
          } else {
            document.querySelector(".popupErrorCart").classList.add("act");
          }
        }

        if (resJson && resJson.popup) {
          _clear(this);
          const actPopup = document.querySelector(`[data-form="${id}"]`);
          actPopup && actPopup.classList.remove("act");
          const popup = document.querySelector(`.${resJson.popup}`);
          if (popup) {
            const title = popup.querySelector(".popupTitle");
            const msgTitle = popup.querySelector(".msgTitle");
            const msgDesc = popup.querySelector(".msgDesc");

            title && (title.textContent = resJson.title);
            msgTitle && (msgTitle.textContent = resJson.msg.title);
            msgDesc && (msgDesc.textContent = resJson.msg.desc);

            popup.classList.add("act");
          }
        }

        if (resJson && resJson.redirect) {
          location.href = resJson.redirect;
        }

        if (resJson && resJson.id === "add_to_cart") {
          const basketCount = document.querySelectorAll(".basketCount");

          basketCount &&
            basketCount.forEach((bI) => {
              let basketValue = bI.dataset.basketValue || 0;
              ++basketValue;

              bI.dataset.basketValue = basketValue;
            });

          const popup = document.querySelector(".popupInfo");
          if (popup) {
            popup.querySelector(".popupInfoMsg").textContent = resJson.msg;
            popup.classList.add("act");
          }
        }
      });
      return;
    });
};

export default formSender;

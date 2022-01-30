import {enableScroll} from "./stopScroll";

const popup = () => {
  const openBtn = document.querySelectorAll("[data-popup-trigger]");
  const closeBtn = document.querySelectorAll(".popup__close");
  const ANIMATION_SPEED = 500 - 50;
  let activePopup = document.querySelector(".popup.act");
  let lock = false;

  const closePopup = () => {
    // lock = true;
    activePopup = document.querySelectorAll(".popup.act");
    activePopup.forEach((item) => {
      item.classList.remove("act");
      // item.classList.add("closing");
    });
    // setTimeout(() => {
    //     activePopup.forEach(item => {
    //         item.classList.remove('act');
    //         item.classList.remove('closing');
    //     });
    //     lock = false;
    //     if (activePopup.querySelector('iframe')) {
    //         activePopup.querySelector('iframe').remove();
    //     }
    // }, ANIMATION_SPEED);
  };

  openBtn.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.preventDefault();
      closePopup();

      //   if (!lock) {
      //   if (e.target) e.preventDefault();
      //   if (activePopup) activePopup.classList.remove("act");

      const currentPopupClass =
        e && e.currentTarget
          ? e.currentTarget.getAttribute("data-popup-trigger")
          : null;

      activePopup = currentPopupClass
        ? document.querySelector(`[data-popup-content="${currentPopupClass}"]`)
        : null;
      if (!!activePopup) activePopup.classList.add("act");
      //   }
    });
  });

  //
  closeBtn.forEach((btn) => {
    btn.addEventListener("click", () => {
      closePopup();
      var VideoPopup = document.querySelector('.popup-video__iframe');
      VideoPopup.remove();
      enableScroll();
    });
  });

  document.addEventListener("click", (e) => {
    let activePopup = document.querySelector(".popup.act");
    if (e.target === activePopup) {
      closePopup();
    }
  });
  return;
};

export default popup;

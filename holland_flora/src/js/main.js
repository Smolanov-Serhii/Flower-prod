import svg4everybody from "../../node_modules/svg4everybody";
import smoothScroll from "smoothscroll-polyfill";
import cssVars from "css-vars-ponyfill";
import hamburger from "./modules/hamburger";
import dropdown from "./modules/dropdown";
import profileCheckOrderCounter from "./modules/profileCheckOrderCounter";
import accordion from "./modules/accordion";
import tabs from "./modules/tabs";
import profileEditInfo from "./modules/profileEditInfo";
import counter from "./modules/counter";
import mainServicesSwiper from "./modules/Swipers/mainAdvantages";
import mainGallerySwiper from "./modules/Swipers/mainGallery";
import mainReviewsSwiper from "./modules/Swipers/mainReviews";
import calcHeight from "./modules/calcHeight";
import youTubeVideo from "./modules/youTubeVideo";
import popup from "./modules/popup";
import textContent from "./modules/textContent";
import stickyHeader from "./modules/stickyHeader";
import chat from "./modules/chat";
import registerPolicy from "./modules/register";
import mask from "./modules/mask";
import productPopup from "./modules/productPopup";
import formSender from "./modules/formSender";
import addToCart from "./modules/addToCart";
import addRemoveCount from "./modules/addRemoveCount";
import scrolltocontent from "./modules/scrolltocontent";

window.addEventListener("DOMContentLoaded", () => {
  "use strict";
  svg4everybody();
  smoothScroll.polyfill();
  cssVars({ rootElement: document });
  hamburger(".header__wrap");
  dropdown(
    ".auth-dropdown",
    ".auth-dropdown__current-wrap",
    ".auth-dropdown__item"
  );
  dropdown(
    ".products-filter-dropdown",
    ".products-filter-dropdown__current-wrap",
    ".products-filter-dropdown__item"
  );
  dropdown(
    ".products-inside-view",
    ".products-inside-view__current-wrap",
    ".products-inside-view__list"
  );
  dropdown(".lang", ".lang__current-wrap", ".lang__item");
  profileCheckOrderCounter();
  accordion(".profile-order__row", ".profile-order__content");
  tabs();
  profileEditInfo();
  counter();
  calcHeight(".main-advantages-swiper__content", "890px");
  accordion(".faq__header", ".faq__content");
  youTubeVideo();
  popup();
  accordion(".products-aside-accord__btn", ".products-aside-accord__list");
  textContent(
    ".products-inside__btn",
    "1024px",
    "В корзину",
    "Добавить в корзину"
  );
  stickyHeader();
  chat();
  registerPolicy();
  mask();

  // Sliders
  mainServicesSwiper();
  mainGallerySwiper();
  mainReviewsSwiper();

  productPopup();
  formSender();
  addToCart();

  addRemoveCount();

  scrolltocontent();
});

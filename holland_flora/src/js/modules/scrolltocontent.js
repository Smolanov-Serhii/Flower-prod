const scrolltocontent = () => {
  const actFilter = document.querySelector('*[data-act-filters="1"]');
  const clearFilters = document.querySelector(".clearFilters");

  if (actFilter && detectMob()) {
    const el = document.querySelector(".productsList");
    el && el.scrollIntoView({ behavior: "smooth" });
  }

  if (clearFilters) {
    clearFilters.addEventListener("click", function (e) {
      const { url } = this.dataset;
      location.href = url;
    });
  }
};

function detectMob() {
  const toMatch = [
    /Android/i,
    /webOS/i,
    /iPhone/i,
    /iPad/i,
    /iPod/i,
    /BlackBerry/i,
    /Windows Phone/i,
  ];

  return toMatch.some((toMatchItem) => {
    return navigator.userAgent.match(toMatchItem);
  });
}

export default scrolltocontent;

// JS
import "./js/main";

// SCSS
import "./scss/main.scss";

// SVG
requireMultiple(
  require.context("./images/svg", true, /\.svg$|\.png$|\.ico$|\.jpg$|\.jpe?g$/)
);

function requireMultiple(r) {
  r.keys().forEach(r);
}

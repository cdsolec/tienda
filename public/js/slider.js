/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************!*\
  !*** ./resources/js/slider.js ***!
  \********************************/
var mySlider = document.querySelectorAll(".mySlider");
var counter = 1;
var timer = setInterval(autoslide, 10000);
slideFun(counter);

function autoslide() {
  counter += 1;
  slideFun(counter);
}

function resetTimer() {
  if (typeof timer !== "undefined") {
    clearInterval(timer);
  }

  timer = setInterval(autoslide, 10000);
}

function plusSlides(n) {
  counter += n;
  slideFun(counter);
  resetTimer();
}

function currentSlide(n) {
  counter = n;
  slideFun(counter);
  resetTimer();
}

function slideFun(n) {
  var i;

  for (i = 0; i < mySlider.length; i++) {
    mySlider[i].style.display = "none";
    mySlider[i].classList.add("hidden");
  }

  if (n > mySlider.length) {
    counter = 1;
  }

  if (n < 1) {
    counter = mySlider.length;
  }

  if (mySlider[counter - 1].style.removeProperty) {
    mySlider[counter - 1].style.removeProperty("display");
  } else {
    mySlider[counter - 1].style.removeAttribute("display");
  }

  mySlider[counter - 1].classList.remove("hidden");
}
/******/ })()
;
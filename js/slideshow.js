const youtubeEnable = document.querySelector(".youtubeEnable");
const slideshowEnable = document.querySelector(".slideshowEnable");
const slides = document.getElementsByClassName("slide");
let slide = 0;

function changeSlide() {
    slides[slide].classList.remove("visibleSlide");
    // Tenary if statement
    slide == slides.length-1 ? slide=0 : slide += 1;
    slides[slide].classList.add("visibleSlide");
}

// Change slides every 2.5 seconds
setInterval(changeSlide, 2.5*1000);

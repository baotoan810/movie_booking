// note: SLIDER------------------------------------
let slideIndex = 0;

function showSlides() {
     let slides = document.getElementsByClassName("slide");
     for (let i = 0; i < slides.length; i++) {
          slides[i].style.display = "none";
     }
     slideIndex++;
     if (slideIndex > slides.length) {
          slideIndex = 1;
     }
     slides[slideIndex - 1].style.display = "block";
     setTimeout(showSlides, 3000); // Chuyển ảnh sau 3 giây
}

function changeSlide(n) {
     slideIndex += n - 1;
     let slides = document.getElementsByClassName("slide");
     if (slideIndex >= slides.length) {
          slideIndex = 0;
     } else if (slideIndex < 0) {
          slideIndex = slides.length - 1;
     }
     for (let i = 0; i < slides.length; i++) {
          slides[i].style.display = "none";
     }
     slides[slideIndex].style.display = "block";
}
// Bắt đầu slider khi trang tải xong
document.addEventListener("DOMContentLoaded", showSlides);

// NOTE: AJAX TÌM KIẾM MOVIE

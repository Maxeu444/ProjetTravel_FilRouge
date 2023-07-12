const titreSpans = document.querySelectorAll('h1 span');
const logo = document.querySelector('.logoHeader');
const l1 = document.querySelector('.l1');
const l2 = document.querySelector('.l2');


window.addEventListener('load', () => {
  const TL = gsap.timeline({ paused: true });
  TL
    .staggerFrom(titreSpans, 1, { top: -50, opacity: 0, ease: "power2.out" }, 0.3)
    .from(l1, 1, { width: 0, ease: "power2.out" }, '-=0.8')
    .from(l2, 1, { width: 0, ease: "power2.out" }, '-=0.8')
    .from(logo, 0.4, { transform: "scale(0)", ease: "power2.out" }, '-=0.8')

  TL.play();

})




const title = document.getElementById("homepageSubtitle");
const words = title.innerText.split(' ');

title.innerHTML = '';

words.forEach((word, index) => {
  const span = document.createElement('span');
  span.innerText = word + ' ';

  const delay = index * 0.5;

  gsap.to(span, { opacity: 1, duration: 0.5, delay: delay });
  title.appendChild(span);
});


function scrollToDiv() {
  setTimeout(function () {

    document.body.style.scrollBehavior = "smooth";
    let div = document.getElementById("navBar");
    div.scrollIntoView({
      behavior: "smooth",
      easing: "ease-in-out",
      block: "start",
      inline: "nearest",
      duration: 10000
    },
    );
    div.animate(
      [
        { transform: 'translateY(-50px)' },
        { transform: 'translateY(0px)' },
        { transform: 'translateY(-15px)' },
        { transform: 'translateY(0px)' }
      ],
      {
        duration: 800,
        iterations: 1
      }
    );
  }, 3000);
}


window.onload = function () {
  scrollToDiv();
};

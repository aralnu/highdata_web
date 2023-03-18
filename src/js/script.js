"use strict";

//selectors

const btnScrollTo = document.querySelector(".btn--scroll-to");
const section1 = document.querySelector("#sobre-nosotros");
const navCheckbox = document.querySelector(".nav__checkbox");
const navLinks = document.querySelector(".nav__links");
const navLink = document.querySelector(".nav__link");
const footerLinks = document.querySelector(".footer__links");

//Smooth scrolling navbar

navLinks.addEventListener("click", function (e) {
  e.preventDefault();
  //Matching strategy
  if (e.target.classList.contains("nav__link")) {
    const id = e.target.getAttribute("href");
    document.querySelector(id).scrollIntoView({ behavior: "smooth" });
  }
});

//smooth scrolling footer

footerLinks.addEventListener("click", function (e) {
  if (e.target.classList.contains("footer__terms")) {
    return true;
  } // this removes the prevent default line for the "terms and conditions" link in the footer nav, cause preventdefault breaks the popup opening
  e.preventDefault();
  //Matching strategy
  if (e.target.classList.contains("footer__link")) {
    const id = e.target.getAttribute("href");
    document.querySelector(id).scrollIntoView({ behavior: "smooth" });
  }
});

//Smooth scrolling button

btnScrollTo.addEventListener("click", function (e) {
  const s1coords = section1.getBoundingClientRect();
  console.log(s1coords);

  section1.scrollIntoView({ behavior: "smooth" });
});

//Uncheck mobile navbar checkbox to hide mobile navbar and show section

navLinks.addEventListener("click", function (e) {
  e.preventDefault();
  //Matching strategy
  if (e.target.classList.contains("nav__link")) {
    navCheckbox.checked = false;
  }
});

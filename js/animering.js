
/* Navbarens skrollningsanimering */

// Utförs endast vid förstagångsladdning av sidan
if (document.body.scrollTop < 20){
  Transparent();
}

function Transparent(){
  document.getElementById("nav_a").style.color = "rgba(1, 1, 1, 1)";
  document.getElementById("nav_a2").style.color = "rgba(1, 1, 1, 1)";
  document.getElementById("nav_a3").style.color = "rgba(1, 1, 1, 1)";
  document.getElementById("nav_a4").style.color = "rgba(1, 1, 1, 1)";
  document.getElementById("nav_a5").style.color = "rgba(1, 1, 1, 1)"; 
  document.getElementById("nav_a6").style.color = "rgba(1, 1, 1, 1)"; 
  document.getElementById("prenav-links").style.backgroundColor = "rgb(255, 255, 255)";
 
  document.getElementById("prenav-links").style.marginTop = "40px"; 
  document.getElementById("navbar").style.backgroundColor = "transparent";
  document.getElementById("navbar").style.padding = "35px 15px";
}

// Utgås ifrån först efter användaren börjar skrolla
window.onscroll = function() {scrollFunction()};

function scrollFunction(){
  if (document.body.scrollTop > 150 || document.documentElement.scrollTop > 150) {  
    document.getElementById("nav_a").style.color = "rgba(255, 255, 255, 1)";
    document.getElementById("nav_a2").style.color = "rgba(255, 255, 255, 1)";
    document.getElementById("nav_a3").style.color = "rgba(255, 255, 255, 1)";
    document.getElementById("nav_a4").style.color = "rgba(255, 255, 255, 1)";
    document.getElementById("nav_a5").style.color = "rgba(255, 255, 255, 1)";
    document.getElementById("nav_a6").style.color = "rgba(255, 255, 255, 1)";
    document.getElementById("prenav-links").style.backgroundColor = "rgb(26, 26, 26)";
   
    document.getElementById("prenav-links").style.marginTop = "20px";
    document.getElementById("navbar").style.backgroundColor = "rgb(31, 31, 31)";
    document.getElementById("navbar").style.padding = "15px 5px";
  } 
  else{
    Transparent();
  }
}

const bg = document.getElementById('headsec');

window.addEventListener('scroll', function(){

  let scale;
  let screenWidth = window.innerWidth;

  if (screenWidth > 1000){
    scale = 130;
  }
  else if (screenWidth > 740 && screenWidth < 1000){
    scale = 200;
  }
  else if (screenWidth > 500 && screenWidth < 740){
    scale = 300;
  }
  else{
    scale = 400;
  }

  bg.style.backgroundSize =  scale + (+bg.style.width) + (window.pageYOffset/12) + '%';
  bg.style.opacity = 1 - +window.pageYOffset / 800 + '';
})

window.addEventListener('resize', function(){
  let scale;
  let screenWidth = window.innerWidth;

  if (screenWidth > 1000){
    scale = 130;
  }
  else if (screenWidth > 740 && screenWidth < 1000){
    scale = 200;
  }
  else if (screenWidth > 500 && screenWidth < 740){
    scale = 300;
  }
  else{
    scale = 400;
  }

  bg.style.backgroundSize =  scale + (+bg.style.width) + (window.pageYOffset/12) + '%';
})

/* Hamburgeranimering */

function navSlide(){

    const burger = document.querySelector('.burger');
    const nav = document.querySelector('.nav-links');
    const navLinks = document.querySelectorAll('.nav-links li');
    
    burger.addEventListener('click', () =>{

        //Burger animation
        burger.classList.toggle('toggle');

        //Toggla nav
        nav.classList.toggle('nav-active');

        //Animera länkar
        navLinks.forEach((link, index) => {
            if (link.style.animation == true)
            {
                link.style.animation = '';
            }
            else{
                link.style.animation = `navLinkFade 0.3s ease-in-out`;
            }
        });  
    });  
}

navSlide();





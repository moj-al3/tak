
const profileBtn = document.querySelector('.img-ava');
const menuMobileBtn = document.querySelector('.menu-btn');
const profileContainer = document.querySelector('.av');
const navbar = document.querySelector('nav');

profileBtn.addEventListener('click', e=> {
   profileContainer.classList.toggle('active');
});

menuMobileBtn.addEventListener('click', e=> {
   menuMobileBtn.classList.toggle('active');
   navbar.classList.toggle('collaps');
});
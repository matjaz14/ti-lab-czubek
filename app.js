const przycisk = document.querySelector('.menu-toggle');
const menu = document.querySelector('.menu');

przycisk.addEventListener('click', function (){
    const otwarte = menu.classList.toggle('menu--open');
    przycisk.setAttribute('aria-expanded', otwarte);
});

menu.querySelectorAll('a').forEach(function (link){
    link.addEventListener('click', function () {
        menu.classList.remove('menu--open');
        przycisk.setAttribute('aria-expanded', false);
    });
});

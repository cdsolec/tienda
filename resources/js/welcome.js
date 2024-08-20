(function() {
    'use strict';

    //------------------------  Brands  --------------------------
    const screen_position = window.innerHeight / 1.2;
    let brands = document.querySelectorAll('.brand');

    window.addEventListener('scroll', function() {
        //------------------------  Brands  ------------------------
        let brands_positions = [];
        for (let i = 0; i < brands.length; i++) {
            brands_positions[i] = brands[i].getBoundingClientRect().top;

            if (brands_positions[i] < screen_position) {
                brands[i].classList.remove('opacity-0');
                brands[i].classList.add('opacity-100');
                brands[i].classList.remove('scale-0');
                brands[i].classList.add('scale-100');
            }
        }
    });
    //------------------------------------------------------------

    //------------------------  Splide  --------------------------
    new Splide.default('.splide').mount();
    //------------------------------------------------------------
})();

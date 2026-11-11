/**
 * Sharji Press - Sliders (Swiper)
 * Clean initializations for all Swiper instances across templates
 */

document.addEventListener('DOMContentLoaded', function() {
    if (typeof Swiper === 'undefined') return;

    // 1. Homepage Mobile Slider
    if (document.querySelector('.swiper-mobile')) {
        new Swiper('.swiper-mobile', {
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true
            }
        });
    }

    // 2. Sport Category Hero Slider
    if (document.querySelector('.hero-swiper')) {
        new Swiper('.hero-swiper', {
            loop: true,
            autoplay: {
                delay: 4500,
                disableOnInteraction: false
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            }
        });
    }

    // 3. Sport Category Mobile Slider
    if (document.querySelector('.sport-mobile-slider')) {
        new Swiper('.sport-mobile-slider', {
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true
            }
        });
    }

    // 4. Sport Fixtures Ticker Swiper
    if (document.querySelector('.fixture-swiper')) {
        new Swiper('.fixture-swiper', {
            slidesPerView: 'auto',
            spaceBetween: 12,
            freeMode: true,
            mousewheel: true
        });
    }

    // 5. Single Post Related News Swiper
    if (document.querySelector('.related-swiper')) {
        new Swiper('.related-swiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            navigation: {
                nextEl: '.rel-next',
                prevEl: '.rel-prev'
            },
            loop: false,
            breakpoints: {
                640: {
                    slidesPerView: 2
                },
                1024: {
                    slidesPerView: 3
                }
            }
        });
    }
});

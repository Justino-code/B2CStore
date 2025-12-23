// resources/js/config/swiper.js

/**
 * Configuração do Swiper
 */
window.swiperConfig = {
    defaults: {
        slidesPerView: 1,
        spaceBetween: 10,
        loop: true,
        speed: 500,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    },
    
    // Presets para diferentes tipos de sliders
    presets: {
        hero: {
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
        },
        product: {
            slidesPerView: 4,
            spaceBetween: 20,
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 10
                },
                640: {
                    slidesPerView: 2,
                    spaceBetween: 15
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 20
                },
                1280: {
                    slidesPerView: 4,
                    spaceBetween: 20
                }
            }
        },
        category: {
            slidesPerView: 6,
            spaceBetween: 15,
            breakpoints: {
                320: {
                    slidesPerView: 2
                },
                640: {
                    slidesPerView: 4
                },
                1024: {
                    slidesPerView: 6
                }
            }
        }
    }
};
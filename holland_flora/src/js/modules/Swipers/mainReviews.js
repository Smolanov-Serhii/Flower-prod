import Swiper, {Pagination, Navigation} from 'swiper';

Swiper.use([Navigation, Pagination]);

const mainReviewsSwiper = () => {
    if (document.querySelector('.main-gallery-swiper')) {
        const mainReviewsSwiper = new Swiper('.main-reviews-swiper', {
            loop: true,
            slidesPerView: 1,
            spaceBetween: 37,
            speed: 800,
            breakpoints: {
                768: {
                    slidesPerView: 2,
                },
                1400: {
                    slidesPerView: 3,
                }
            },
            navigation: {
                nextEl: '.main-reviews__btn.next',
                prevEl: '.main-reviews__btn.prev',
            },
            pagination: {
                el: '.main-reviews__pagination',
                type: 'bullets',
                clickable: true
            },
        });
    }
};

export default mainReviewsSwiper;
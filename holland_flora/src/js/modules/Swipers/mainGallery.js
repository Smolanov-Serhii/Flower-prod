import Swiper, {Pagination, Navigation} from 'swiper';

Swiper.use([Navigation, Pagination]);

const mainGallerySwiper = () => {
    if (document.querySelector('.main-gallery-swiper')) {
        const mainGallerySwiper = new Swiper('.main-gallery-swiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            speed: 800,
            navigation: {
                nextEl: '.main-gallery-swiper__btn.next',
                prevEl: '.main-gallery-swiper__btn.prev',
            },
            pagination: {
                el: '.main-gallery__pagination',
                type: 'bullets',
                clickable: true
            },
        });
    }
};

export default mainGallerySwiper;
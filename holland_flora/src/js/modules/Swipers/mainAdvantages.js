import Swiper, {Pagination, Navigation} from 'swiper';

Swiper.use([Navigation, Pagination]);

const mainServicesSwiper = () => {
    if (document.querySelector('.main-advantages-swiper')) {
        const breakpoint = window.matchMedia('(min-width:1024px)');
        let mainAdvantageSwiper;

        const breakpointChecker = function () {
            if (breakpoint.matches === true) {
                if (mainAdvantageSwiper !== undefined) mainAdvantageSwiper.destroy(true, true);
                return;
            } else if (breakpoint.matches === false) {
                return enableSwiper();
            }
        };

        const enableSwiper = function () {
            mainAdvantageSwiper = new Swiper('.main-advantages-swiper', {
                slidesPerView: 1,
                spaceBetween: 25,
                speed: 800,
                breakpoints: {
                    890: {
                        slidesPerView: 2,
                    }
                },
                navigation: {
                    nextEl: '.main-advantages-swiper__btn.next',
                    prevEl: '.main-advantages-swiper__btn.prev',
                },
                pagination: {
                    el: '.main-advantages-swiper__pagination',
                    type: 'bullets',
                    clickable: true
                },
            });

        };
        breakpoint.addListener(breakpointChecker);
        breakpointChecker();
    }
};

export default mainServicesSwiper;
import {disabledScroll, enableScroll} from './stopScroll';

const youTubeVideo = () => {
    const trigger = document.querySelectorAll('[data-youtube-src]');


    const youtubeImg = (function () {
        let video, results;

        const getThumb = function (url) {
            if (url === null) {
                return '';
            }
            results = url.match('[\\?&]v=([^&#]*)');
            video = (results === null) ? url : results[1];
            return 'http://img.youtube.com/vi/' + video + '/maxresdefault.jpg';
        };

        return {
            thumb: getThumb
        };
    }());

    function generateURL(id) {
        let query = '?rel=0&showinfo=0&autoplay=1';

        return 'https://www.youtube.com/embed/' + id + query;
    }

    function createIframe(id) {
        let iframe = document.createElement('iframe');

        iframe.setAttribute('allowfullscreen', '');
        iframe.setAttribute('allow', 'autoplay');
        iframe.setAttribute('src', generateURL(id));
        iframe.classList.add('popup-video__iframe');

        return iframe;
    }

    function parseMediaURL(media) {
        let regexp = /http:\/\/img\.youtube\.com\/vi\/([a-zA-Z0-9_-]+)\/maxresdefault\.jpg/i;
        let url = media.src;
        let match = url.match(regexp);

        return match[1];
    }

    trigger.forEach(item => {
        const url = item.getAttribute('data-youtube-src');
        item.querySelector('img').src = youtubeImg.thumb(url);

        item.addEventListener('click', () => {
            const popupVideo = document.querySelector('[data-popup-content="popupVideo"]');
            let id = parseMediaURL(item.querySelector('img'));
            let iframe = createIframe(id);
            popupVideo.querySelector('.popup-video__container').appendChild(iframe);

            popupVideo.classList.add('act');
            disabledScroll();
        });
    });
};

export default youTubeVideo;

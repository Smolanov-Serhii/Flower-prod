import {enableScroll, disabledScroll} from './stopScroll';

const hamburger = (menuSelector, burgerSelector = '.hamburger') => {
    const burgerElem = document.querySelectorAll(burgerSelector),
        menuElem = document.querySelector(menuSelector),
        body = document.body;

    if (burgerElem) {
        burgerElem.forEach(item => {
            item.addEventListener('click', () => {
                burgerElem.forEach(item => {
                    item.classList.toggle('act');
                });
                menuElem.classList.toggle('act');
            });
        });
    }

};

export default hamburger;
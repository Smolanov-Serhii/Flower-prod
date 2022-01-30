const profileCheckOrderCounter = () => {
    if (document.querySelector('[data-order-number]')) {
        const number = document.querySelector('[data-order-number]');

        if (number.getAttribute('data-order-number') >= 100) {
            number.classList.add('small');
        }

    }

};

export default profileCheckOrderCounter;
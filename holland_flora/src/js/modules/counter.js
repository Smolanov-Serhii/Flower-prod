const counter = () => {

    let btns = document.querySelectorAll('[data-counter-trigger]');
    btns.forEach(function (item) {
        item.addEventListener('click', counterState);
    });

    function counterState() {
        let dir = this.dataset.counterTrigger,
            inputEl = this.parentElement.querySelector('input'),
            currentValue = inputEl.value;

        dir === 'plus' ? counterPlus(inputEl, currentValue) : counterMinus(inputEl, currentValue);
    }

    const counterPlus = (el, val) => {
        if (el.closest('[data-min-value]')) {
            const minValue = +el.closest('[data-min-value]').getAttribute('data-min-value');
            el.value = +val + minValue;
        } else {
            el.value = +val + 1;
        }
    };

    const counterMinus = (el, val) => {
        if (el.closest('[data-min-value]')) {
            const minValue = +el.closest('[data-min-value]').getAttribute('data-min-value');
            el.value = +val - minValue;
            if (val <= minValue) el.value = minValue;
        } else {
            if (val - 1) el.value = +val - 1;
        }
    };
};

export default counter;
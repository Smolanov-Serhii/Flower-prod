export const disabledScroll = () => {
    let paddingOffset = window.innerWidth - document.body.offsetWidth + 'px';
    let fix = document.querySelectorAll('.fix-block');
    document.body.style.paddingRight = paddingOffset;
    fix.forEach(el => {
        el.style.paddingRight = paddingOffset;
    });
    let pagePosition = window.scrollY;
    document.body.classList.add('blocked');
    document.body.dataset.position = pagePosition;
    document.body.style.top = -pagePosition + 'px';
};

export const enableScroll = () => {
    let pagePosition = parseInt(document.body.dataset.position, 10);
    let fix = document.querySelectorAll('.fix-block');
    document.body.style.top = '';
    document.body.classList.remove('blocked');
    fix.forEach(el => {
        el.style.paddingRight = '';
    });
    document.body.style.paddingRight = '';
    window.scroll({top: pagePosition, left: 0});
    document.body.removeAttribute('data-position');
};
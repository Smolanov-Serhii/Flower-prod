const stickyHeader = (stickySelector= '.header') => {
    const stickyElem = document.querySelector(stickySelector);
    const stickyElemOffset = stickyElem.offsetTop;

    document.addEventListener('scroll', () => {
        if (window.pageYOffset > stickyElemOffset) {
            stickyElem.classList.add('sticky');
        } else {
            stickyElem.classList.remove('sticky');
        }
    });
};

export default stickyHeader;
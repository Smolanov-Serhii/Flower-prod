const textContent = (elemSelector, widthSize, before, after) => {
    if (!document.querySelector(elemSelector)) return;

    const elem = document.querySelectorAll(elemSelector);
    const width = window.matchMedia(`(min-width: ${widthSize})`);
    const textWatcher = () => {
        if (width.matches) {
            elem.forEach(item => {
                item.textContent = after;
            });
        } else {
            elem.forEach(item => {
                item.textContent = before;
            });
        }
    };
    textWatcher();
    window.addEventListener('resize', function () {
        textWatcher();
    });
};

export default textContent;
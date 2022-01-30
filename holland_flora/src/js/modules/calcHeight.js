const calcHeight = (element, mediaNumber = 0) => {
    let item = document.querySelectorAll(element);
    let max_col_height = 0;
    let media = window.matchMedia(`(min-width: ${mediaNumber})`);

    function calcHeightInit() {
        if (media.matches) {
            for (let i = item.length - 1; i >= 0; i--) {
                if (item[i].offsetHeight > max_col_height) {
                    max_col_height = item[i].offsetHeight;
                }
            }
            for (let p = item.length - 1; p >= 0; p--) {
                item[p].style.height = max_col_height + 'px';
            }
        } else {
            for (let p = item.length - 1; p >= 0; p--) {
                item[p].style.height = 'auto';
            }
        }
    }

    calcHeightInit();
    window.addEventListener('resize', calcHeightInit);
};

export default calcHeight;
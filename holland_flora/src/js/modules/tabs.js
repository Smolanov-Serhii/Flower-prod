const tabs = () => {
    const tabBtns = document.querySelectorAll('[data-tab-trigger]');

    tabBtns.forEach(item => {
        item.addEventListener('click', function () {
            let tabActive = item.closest('.tabs').querySelectorAll('[data-tab-content]');
            const tabContent = this.getAttribute('data-tab-trigger');
            this.closest('.tabs').querySelectorAll('[data-tab-trigger]').forEach(item => {
                item.classList.remove('act');
            });
            this.classList.add('act');
            tabActive.forEach(item => {
                if (item.classList.contains('act')) {
                    item.classList.remove('act');
                }
            });
            tabActive = document.querySelector(`[data-tab-content='${tabContent}']`);
            tabActive.classList.add('act');
        });
    });
};

export default tabs;
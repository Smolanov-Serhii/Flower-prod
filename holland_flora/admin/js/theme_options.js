document.addEventListener('DOMContentLoaded', function () {
    const navTabs = document.querySelectorAll('.nav-tab');
    const tabContents = document.querySelectorAll('.tab_content');

    if (tabContents.length) show(tabContents[0]);

    if (navTabs.length) {
        navTabs.forEach(function (navTab) {
            navTab.addEventListener('click', function (e) {
                e.preventDefault();

                const tab = this.dataset.tab;
                const actNavTabs = document.querySelectorAll('.nav-tab.nav-tab-active');

                if (actNavTabs.length) {
                    actNavTabs.forEach(function (aNavTab) {
                        aNavTab.classList.remove('nav-tab-active');
                    });
                }

                if (tabContents.length) {
                    tabContents.forEach(function (tabContent) {
                        hide(tabContent);
                    });
                }

                this.classList.add('nav-tab-active');
                const section = document.getElementById(tab);

                if (section) {
                    show(section);
                }
            });
        });
    }
});


function show(el) {
    el.style.display = 'block';
}

function hide(el) {
    el.style.display = 'none';
}
document.addEventListener('DOMContentLoaded', () => {
    var tabHeaders = document.getElementsByClassName('tab-header');
    var tabs = document.getElementsByClassName('tab');

    for (let i = 0; i < tabHeaders.length; i++) {
        tabHeaders[i].addEventListener('click', function() {
            for (let j = 0; j < tabHeaders.length; j++) {
                tabHeaders[j].classList.remove('is-active');
                tabs[j].classList.remove('is-active');
            }
            
            this.classList.add('is-active');

            let selectedTabContents = document.querySelectorAll('[data-content="' + this.dataset.tab + '"]');

            selectedTabContents.forEach(function(selectedTabContent) {
                selectedTabContent.classList.add('is-active');
            });
        });
    }

    const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);
    if ($navbarBurgers.length > 0) {
        $navbarBurgers.forEach( el => {
            el.addEventListener('click', () => {
                let dashboardNav = document.getElementById('dashboard-nav');
                dashboardNav.classList.toggle('dashboard-nav-active');
                el.classList.toggle('is-active');
            });
        });
    }
});
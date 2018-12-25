var addLocationBtn = document.getElementById('add-area-btn');

addLocationBtn.addEventListener('click', (e) => {
    document.getElementById('location-box').classList.toggle('is-hidden');
    document.getElementById('btn-icon').classList.toggle('fa-chevron-down');
    document.getElementById('btn-icon').classList.toggle('fa-chevron-up');
});
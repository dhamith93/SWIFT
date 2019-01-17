var modals = getAll('.modal');
var modalCloses = getAll('.modal-background, .modal-close, .modal-card-head .delete, .modal-card-foot .button');
var images = getAll('.incident-media');
var imgUrl = document.getElementById('img-url');
var copyBtn = document.getElementById('copy-btn');

var editor = CKEDITOR.replace('editor', {
    height: 600,
    toolbarGroups : [
        { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
        { name: 'links', groups: [ 'links' ] },
        { name: 'insert', groups: [ 'insert' ] },
        { name: 'forms', groups: [ 'forms' ] },
        { name: 'tools', groups: [ 'tools' ] },
        { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
        { name: 'others', groups: [ 'others' ] },
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
        { name: 'styles', groups: [ 'styles' ] },
        { name: 'colors', groups: [ 'colors' ] },
        { name: 'about', groups: [ 'about' ] }
    ],
    removeButtons : 'Subscript,Superscript,Source,SpecialChar,About,Styles'
});

document.getElementById('save-btn').addEventListener('click', (e) => {
    let title = document.getElementById('title').value;
    let content = CKEDITOR.instances.editor.getData();
    
    if (title && content) {
        let params = 'title=' + title + '&content=' + encodeURIComponent(content) + '&incidentId=' + id + '&articleId=' + articleId;
        sendXhr(
            'http://localhost/SWIFT/api/article_save/',
            'POST',
            (r) => {
                alert('Press release saved!');
                articleId = r['articleId'];
            },
            () => {
                alert('Failed to save the press release!\nPlease try again.');
            },
            params
        );
    }
});

document.getElementById('publish-btn').addEventListener('click', (e) => {
    let title = document.getElementById('title').value;
    let content = CKEDITOR.instances.editor.getData();

    if (title && content) {
        let params = 'title=' + title + '&content=' + encodeURIComponent(content) + '&incidentId=' + id + '&articleId=' + articleId;
        sendXhr(
            'http://localhost/SWIFT/api/article_save/',
            'POST',
            (r) => {
                articleId = r['articleId'];
                sendXhr(
                    'http://localhost/SWIFT/api/article_publish/',
                    'POST',
                    (r) => {
                        articleId = r['articleId'];
                        alert('Press release published!');
                    },
                    () => {
                        alert('Failed to publish the press release!\nPlease try again.');
                    },
                    'articleId=' + articleId
                );
            },
            () => {
                alert('Failed to save the press release!\nPlease try again.');
            },
            params
        );
    }
    
});

document.getElementById('img-btn').addEventListener('click', (e) => {
    openModal('modal');
});

if (copyBtn) {
    copyBtn.addEventListener('click', (e) => {
        imgUrl.select();
        document.execCommand('copy');
        alert('URL copied to the clipboard');
    });
}


images.forEach((el) => {
    el.addEventListener('click', (e) => {
        imgUrl.value = el.dataset.src;
    });
});

function sendXhr(url, method, successCallback, failureCallback, params) {
    let xhr = new XMLHttpRequest();
    xhr.open(method, url, true);
    xhr.setRequestHeader('Content-Length', params.length);
    xhr.setRequestHeader('Connection', 'close');

    xhr.onload = () => {
        let response = JSON.parse(xhr.responseText);
        if (response['status'] === 'OK') {
            successCallback(response);
        } else {
            failureCallback(response);
        }
    };

    xhr.onerror = () => {
        alert('Error sending request! Please try again.');
    };   

    if (params)
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.send(params); 
}


function openModal(t) {
    let target = document.getElementById(t);
    let rootEl = document.documentElement;
    rootEl.classList.add('is-clipped');
    target.classList.add('is-active');
}

function closeModals() {
    let rootEl = document.documentElement;
    rootEl.classList.remove('is-clipped');
    modals.forEach(function (el) {
        el.classList.remove('is-active');
    });
}

document.addEventListener('keydown', function (event) {
        let e = event || window.event;
        if (e.keyCode === 27) {
        closeModals();
        // closeDropdowns();
    }
});

if (modalCloses.length > 0) {
    modalCloses.forEach(function (el) {
        el.addEventListener('click', function () {
            closeModals();
        });
    });
}

function getAll(selector) {
    return Array.prototype.slice.call(document.querySelectorAll(selector), 0);
}
document.addEventListener('DOMContentLoaded', (e) => {



    sendXhr(
        'http://localhost/swift/api/public_alert/',
        'GET',
        (r) => {
            let target = document.querySelector('.section-one__alerts');
            let keys = Object.keys(r).reverse();
            console.log(r[keys[1]].date);


            for (let i = 1; i < keys.length; i++) {

                let span = document.createElement('span');
                span.classList.add('section-one__alert-box-date');
                let date = (r[keys[i]].date).split(' ');
                span.innerHTML = ' - ' + date[0];


                let p = document.createElement('p');
                p.innerHTML = r[keys[i]].content;
                p.appendChild(span);

                let div = document.createElement('div');
                div.classList.add('section-one__alert-box');
                div.appendChild(p);

                let fragment = document.createDocumentFragment();
                fragment.appendChild(div);

                target.appendChild(fragment);

            }

        },
        (r) => {
            alert('Faild to get alerts!');
        }

    );


    function sendXhr(url, method, successCallback, failureCallback) {
        let xhr = new XMLHttpRequest();
        xhr.open(method, url, true);

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

        xhr.send();

    }


}, false);
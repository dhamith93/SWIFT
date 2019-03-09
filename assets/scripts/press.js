document.addEventListener('DOMContentLoaded', (e) => {

    sendXhr(
        'http://localhost/swift/api/public_posts_all/',
        'GET',
        (r) => {
            let target = document.querySelector('.press');
            let keys = Object.keys(r).reverse();
            console.log(r);

            for (let i = 1; i < keys.length; i++) {

                let title = document.createElement('div');
                title.classList.add('press__mainSection--title');
                title.innerHTML = r[keys[i]].title;

                let date = document.createElement('div');
                date.classList.add('press__mainSection--date');
                let dateStyle = (r[keys[i]].publish_date).split(' ');
                date.innerHTML = dateStyle[0];

                let mainSection = document.createElement('div');
                mainSection.classList.add('press__mainSection');
                mainSection.appendChild(title);
                mainSection.appendChild(date);

                let para = document.createElement('div');
                para.classList.add('press__para');

                //get base url
                let getUrl = window.location;
                let baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
                para.innerHTML = r[keys[i]].content + "<a href='" + baseUrl + "/press-release/" + r[keys[i]].id + "'><p>Read More..</p>";

                let image = document.createElement('div');
                image.classList.add('press__image');

                let box = document.createElement('div');
                box.classList.add('press__box');
                box.appendChild(image);
                box.appendChild(mainSection);
                box.appendChild(para);

                let fragment = document.createDocumentFragment();
                fragment.appendChild(box);

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
document.addEventListener('DOMContentLoaded', (e) => {

    //get base URL
    let getUrl = window.location;
    let baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];

    sendXhr(
        baseUrl + '/api/public_alert',
        'GET',
        (r) => {
            let target = document.querySelector('.section-one__alerts');
            let keys = Object.keys(r).reverse();
            


            for (let i = 1; i < keys.length; i++) {

                let span = document.createElement('span');
                span.classList.add('section-one__alert-box-date');
                let date = (r[keys[i]].date).split(' ');
                span.innerHTML = date[0];


                let h1 = document.createElement('h1');
                h1.innerHTML = r[keys[i]].content;
                

                let div = document.createElement('div');
                div.classList.add('section-one__alert-box');
                div.appendChild(span);
                div.appendChild(h1);

                let fragment = document.createDocumentFragment();
                fragment.appendChild(div);

                target.appendChild(fragment);

            }

        },
        (r) => {
            alert('Faild to get alerts!');
        }

    );
    sendXhr(
        baseUrl + '/api/public_posts/',
        'GET',
        (r) => {
            let target = document.querySelector('.press');
            let keys = Object.keys(r).reverse();
            console.log(r);

            for(let i = 1; i < keys.length; i++){

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
                para.innerHTML = r[keys[i]].content + "<a href='" + baseUrl + "/press-release/" + r[keys[i]].id + "'><p>Read More..</p></a>";

                let image = document.createElement('div');
                image.classList.add('press__image');

                let box = document.createElement('div');
                box.classList.add('press__box');
                box.appendChild(image);
                box.appendChild(mainSection);
                box.appendChild(para);

                box.addEventListener('click', e => {
                    window.location = baseUrl + "/press-release/" + r[keys[i]].id;
                });

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

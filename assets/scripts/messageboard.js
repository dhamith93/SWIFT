document.addEventListener('DOMContentLoaded', (e) => {
    let lastMsgId = 0;
    let oldMsgId = Number.MAX_SAFE_INTEGER;
    const msgCount = 10;
    const msgSendBtn = document.getElementById('msg-send-btn');
    const msgBox = document.getElementById('msg-box');
    const refreshMillSecs = 5000;
    const messageCheckInterval = window.setInterval(checkForNewMessages, refreshMillSecs);

    if (msgSendBtn) {
        msgSendBtn.addEventListener('click', (e) => {
            let content = document.getElementById('msg-content').value;
            let params = 'incidentId=' + incidentId + '&content=' + content;
            sendXhr(
                'http://localhost/SWIFT/api/add_message/',
                'POST',
                () => {
                    removeMessages();
                    retrieveMessages('down', 0);
                },
                () => {
                    alert('Failed to add the message. Please try again.');
                },
                params
            );
        });
    }

    if (msgBox) {
        msgBox.addEventListener('scroll', (e) => checkScrollPosition(e.target));
    }

    function retrieveMessages(direction, from = null) {
        from = (from === null) ? lastMsgId : from;
        let url = 'http://localhost/SWIFT/api/retrieve_messages/?incidentId=' 
                    + incidentId 
                    +'&from=' + from 
                    +'&count=' + msgCount 
                    + '&direction=' + direction;

        sendXhr(
            url,
            'GET',
            (r) => {
                addMessageElements(r);
            },
            () => {
                alert('Failed to get messages...');
            }
        );
    }

    function sendXhr(url, method, successCallback, failureCallback, params) {
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

        if (params)
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.send(params); 
    }

    function checkScrollPosition(el) {
        if (el.scrollTop === 0) {
            retrieveMessages('down');
        } else if (el.offsetHeight + el.scrollTop === el.scrollHeight) {
            let params = 'incidentId= ' + incidentId;
            sendXhr(
                'http://localhost/SWIFT/api/first_msg_id/?' + params,
                'GET',
                (r) => {
                    console.log(parseInt(r[0]['id']) + ' -- ' + oldMsgId);
                    if (parseInt(r[0]['id']) < oldMsgId) {
                        retrieveMessages('up', oldMsgId);
                    }
                },
                (r) => { }
            );
        }
    }

    function removeMessages() {
        let length = msgBox.childNodes.length - 1;
            for (let i = length; i >= 0; i--)
                msgBox.removeChild(msgBox.childNodes[i]);
    }

    function addMessageElements(r) {
        Object.keys(r).forEach(key => {
            if (key !== 'status') {
                let id = parseInt(r[key]['id']);
                let userId = parseInt(r[key]['user_id']);
                let content = r[key]['content'];
                let name = r[key]['name'];
                let org = r[key]['organization'];
                let dateTime = r[key]['published_date'];

                let msgDiv = document.createElement('div');
                msgDiv.classList.add('msg', 'notification');

                if (currentUserId === userId)
                    msgDiv.classList.add('msg-self', 'is-link');
                
                let msgHeaderPara = document.createElement('p');
                msgHeaderPara.classList.add('msg-header');
                
                let nameSpan = document.createElement('span');
                nameSpan.innerHTML = org + ' : ' + name;
                nameSpan.classList.add('msg-owner-name');
                
                let timeSpan = document.createElement('span');
                timeSpan.innerHTML = '<br>@ ' + dateTime;
                timeSpan.classList.add('msg-date-time');
                
                let contentPara = document.createElement('p');
                contentPara.innerHTML = content;
                contentPara.classList.add('msg-content');

                msgHeaderPara.append(nameSpan);
                msgHeaderPara.append(timeSpan);

                msgDiv.append(msgHeaderPara);
                msgDiv.append(contentPara);

                msgBox.append(msgDiv);

                if (id > lastMsgId) {
                    lastMsgId = id;
                } else if (id < oldMsgId) {
                    oldMsgId = id;
                }
            }
        });
    }

    function checkForNewMessages() {
        let params = 'incidentId= ' + incidentId;
        sendXhr(
            'http://localhost/SWIFT/api/latest_msg_id/?' + params,
            'GET',
            (r) => {
                if (parseInt(r[0]['id']) > lastMsgId) {
                    removeMessages();
                    retrieveMessages('down', 0);
                    beep();
                }
            },
            (r) => { }
        );
    }

    function beep() {
        let snd = new  Audio("data:audio/wav;base64,//uQRAAAAWMSLwUIYAAsYkXgoQwAEaYLWfkWgAI0wWs/ItAAAGDgYtAgAyN+QWaAAihwMWm4G8QQRDiMcCBcH3Cc+CDv/7xA4Tvh9Rz/y8QADBwMWgQAZG/ILNAARQ4GLTcDeIIIhxGOBAuD7hOfBB3/94gcJ3w+o5/5eIAIAAAVwWgQAVQ2ORaIQwEMAJiDg95G4nQL7mQVWI6GwRcfsZAcsKkJvxgxEjzFUgfHoSQ9Qq7KNwqHwuB13MA4a1q/DmBrHgPcmjiGoh//EwC5nGPEmS4RcfkVKOhJf+WOgoxJclFz3kgn//dBA+ya1GhurNn8zb//9NNutNuhz31f////9vt///z+IdAEAAAK4LQIAKobHItEIYCGAExBwe8jcToF9zIKrEdDYIuP2MgOWFSE34wYiR5iqQPj0JIeoVdlG4VD4XA67mAcNa1fhzA1jwHuTRxDUQ//iYBczjHiTJcIuPyKlHQkv/LHQUYkuSi57yQT//uggfZNajQ3Vmz+Zt//+mm3Wm3Q576v////+32///5/EOgAAADVghQAAAAA//uQZAUAB1WI0PZugAAAAAoQwAAAEk3nRd2qAAAAACiDgAAAAAAABCqEEQRLCgwpBGMlJkIz8jKhGvj4k6jzRnqasNKIeoh5gI7BJaC1A1AoNBjJgbyApVS4IDlZgDU5WUAxEKDNmmALHzZp0Fkz1FMTmGFl1FMEyodIavcCAUHDWrKAIA4aa2oCgILEBupZgHvAhEBcZ6joQBxS76AgccrFlczBvKLC0QI2cBoCFvfTDAo7eoOQInqDPBtvrDEZBNYN5xwNwxQRfw8ZQ5wQVLvO8OYU+mHvFLlDh05Mdg7BT6YrRPpCBznMB2r//xKJjyyOh+cImr2/4doscwD6neZjuZR4AgAABYAAAABy1xcdQtxYBYYZdifkUDgzzXaXn98Z0oi9ILU5mBjFANmRwlVJ3/6jYDAmxaiDG3/6xjQQCCKkRb/6kg/wW+kSJ5//rLobkLSiKmqP/0ikJuDaSaSf/6JiLYLEYnW/+kXg1WRVJL/9EmQ1YZIsv/6Qzwy5qk7/+tEU0nkls3/zIUMPKNX/6yZLf+kFgAfgGyLFAUwY//uQZAUABcd5UiNPVXAAAApAAAAAE0VZQKw9ISAAACgAAAAAVQIygIElVrFkBS+Jhi+EAuu+lKAkYUEIsmEAEoMeDmCETMvfSHTGkF5RWH7kz/ESHWPAq/kcCRhqBtMdokPdM7vil7RG98A2sc7zO6ZvTdM7pmOUAZTnJW+NXxqmd41dqJ6mLTXxrPpnV8avaIf5SvL7pndPvPpndJR9Kuu8fePvuiuhorgWjp7Mf/PRjxcFCPDkW31srioCExivv9lcwKEaHsf/7ow2Fl1T/9RkXgEhYElAoCLFtMArxwivDJJ+bR1HTKJdlEoTELCIqgEwVGSQ+hIm0NbK8WXcTEI0UPoa2NbG4y2K00JEWbZavJXkYaqo9CRHS55FcZTjKEk3NKoCYUnSQ0rWxrZbFKbKIhOKPZe1cJKzZSaQrIyULHDZmV5K4xySsDRKWOruanGtjLJXFEmwaIbDLX0hIPBUQPVFVkQkDoUNfSoDgQGKPekoxeGzA4DUvnn4bxzcZrtJyipKfPNy5w+9lnXwgqsiyHNeSVpemw4bWb9psYeq//uQZBoABQt4yMVxYAIAAAkQoAAAHvYpL5m6AAgAACXDAAAAD59jblTirQe9upFsmZbpMudy7Lz1X1DYsxOOSWpfPqNX2WqktK0DMvuGwlbNj44TleLPQ+Gsfb+GOWOKJoIrWb3cIMeeON6lz2umTqMXV8Mj30yWPpjoSa9ujK8SyeJP5y5mOW1D6hvLepeveEAEDo0mgCRClOEgANv3B9a6fikgUSu/DmAMATrGx7nng5p5iimPNZsfQLYB2sDLIkzRKZOHGAaUyDcpFBSLG9MCQALgAIgQs2YunOszLSAyQYPVC2YdGGeHD2dTdJk1pAHGAWDjnkcLKFymS3RQZTInzySoBwMG0QueC3gMsCEYxUqlrcxK6k1LQQcsmyYeQPdC2YfuGPASCBkcVMQQqpVJshui1tkXQJQV0OXGAZMXSOEEBRirXbVRQW7ugq7IM7rPWSZyDlM3IuNEkxzCOJ0ny2ThNkyRai1b6ev//3dzNGzNb//4uAvHT5sURcZCFcuKLhOFs8mLAAEAt4UWAAIABAAAAAB4qbHo0tIjVkUU//uQZAwABfSFz3ZqQAAAAAngwAAAE1HjMp2qAAAAACZDgAAAD5UkTE1UgZEUExqYynN1qZvqIOREEFmBcJQkwdxiFtw0qEOkGYfRDifBui9MQg4QAHAqWtAWHoCxu1Yf4VfWLPIM2mHDFsbQEVGwyqQoQcwnfHeIkNt9YnkiaS1oizycqJrx4KOQjahZxWbcZgztj2c49nKmkId44S71j0c8eV9yDK6uPRzx5X18eDvjvQ6yKo9ZSS6l//8elePK/Lf//IInrOF/FvDoADYAGBMGb7FtErm5MXMlmPAJQVgWta7Zx2go+8xJ0UiCb8LHHdftWyLJE0QIAIsI+UbXu67dZMjmgDGCGl1H+vpF4NSDckSIkk7Vd+sxEhBQMRU8j/12UIRhzSaUdQ+rQU5kGeFxm+hb1oh6pWWmv3uvmReDl0UnvtapVaIzo1jZbf/pD6ElLqSX+rUmOQNpJFa/r+sa4e/pBlAABoAAAAA3CUgShLdGIxsY7AUABPRrgCABdDuQ5GC7DqPQCgbbJUAoRSUj+NIEig0YfyWUho1VBBBA//uQZB4ABZx5zfMakeAAAAmwAAAAF5F3P0w9GtAAACfAAAAAwLhMDmAYWMgVEG1U0FIGCBgXBXAtfMH10000EEEEEECUBYln03TTTdNBDZopopYvrTTdNa325mImNg3TTPV9q3pmY0xoO6bv3r00y+IDGid/9aaaZTGMuj9mpu9Mpio1dXrr5HERTZSmqU36A3CumzN/9Robv/Xx4v9ijkSRSNLQhAWumap82WRSBUqXStV/YcS+XVLnSS+WLDroqArFkMEsAS+eWmrUzrO0oEmE40RlMZ5+ODIkAyKAGUwZ3mVKmcamcJnMW26MRPgUw6j+LkhyHGVGYjSUUKNpuJUQoOIAyDvEyG8S5yfK6dhZc0Tx1KI/gviKL6qvvFs1+bWtaz58uUNnryq6kt5RzOCkPWlVqVX2a/EEBUdU1KrXLf40GoiiFXK///qpoiDXrOgqDR38JB0bw7SoL+ZB9o1RCkQjQ2CBYZKd/+VJxZRRZlqSkKiws0WFxUyCwsKiMy7hUVFhIaCrNQsKkTIsLivwKKigsj8XYlwt/WKi2N4d//uQRCSAAjURNIHpMZBGYiaQPSYyAAABLAAAAAAAACWAAAAApUF/Mg+0aohSIRobBAsMlO//Kk4soosy1JSFRYWaLC4qZBYWFRGZdwqKiwkNBVmoWFSJkWFxX4FFRQWR+LsS4W/rFRb/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////VEFHAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAU291bmRib3kuZGUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMjAwNGh0dHA6Ly93d3cuc291bmRib3kuZGUAAAAAAAAAACU=");  
        snd.play().catch(() => {});
    }

    retrieveMessages('down');
}, false);
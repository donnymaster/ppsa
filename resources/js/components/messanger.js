import Pusher from 'pusher-js';
import Echo from 'laravel-echo';
const PATH_URL_CREATE_EVENTS = '/doctor/ration/events';
const ACTIVE_CLASS_NAME = 'is-active';

class Messanger {

    main = null;
    loader = null;
    activeRoom = null;
    gatewayChats = null;
    userDataAttr = null;

    constructor() {
        this.main = document.querySelector('#messanger');

        if (this.main !== null) {
            this._start();
        }
    }

    _start = () => {
        const leftBar = this.main.querySelector('.bar-items');
        this.loader = this.main.querySelector('.fetch-wrapped');

        const input = this.main.querySelector('#send-message');

        input.addEventListener('click', this.sendMessage);

        document.querySelector('.add-racion')?.addEventListener('click', this.handleClickAddRation);
        document.querySelector('.modal-background')?.addEventListener('click', this._closeForm);
        document.querySelector('#submit-create-event')?.addEventListener('click', this._handleClickSubmitForm);

        this.main.querySelector('#message-body').addEventListener('keydown', (e) => {
            if (e.keyCode == 13) {
                this.sendMessage();
            }
        });

        leftBar.addEventListener('click', this.handleClickLeftBar);
        this.handleChangeInputSearch();

        this.gatewayChats = new Echo({
            broadcaster: 'pusher',
            key: '80d6d8fcfd859ce24a5d',
            cluster: 'ap1',
            encrypted: true,
        });
    }

    _closeForm = (event) => {
        const modal = document.querySelector('.modal[data-id="create-event"]');

        if (modal && event.target.classList.contains('modal-background')) {
            modal.classList.remove('is-active');
        }
    }

    handleChangeInputSearch = () => {
        const searchInput = this.main.querySelector('input.doctor_id');
        const userId = this.main.querySelector('#user-id').value;

        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.type === 'attributes' && mutation.attributeName === 'value') {
                    this.loader.classList.add('is-block');
                    this.loadRoom(userId, searchInput.value);
                }
            });
        });

        observer.observe(searchInput, { attributes: true });
    }

    handleClickAddRation = () => {
        const modal = document.querySelector('.modal[data-id="create-event"]');

        if (modal) {
            modal.querySelector('#user-name').textContent = this.userDataAttr.userFull;
            modal.querySelector('#user-id-owner').value = this.userDataAttr.userId;
            modal.classList.add('is-active');
        }
    }

    handleClickLeftBar = (event) => {
        if (!event.target.classList.contains('user-item')) {
            return;
        }

        const idRoom = event.target.dataset.room;
        this.loader.classList.add('is-block');
        this.fetchRoomMessage(idRoom);
    }

    setUserForCreateRation = (idRoom) => {
        this.userDataAttr = document.querySelector(`.user-item[data-room="${idRoom}"]`).dataset;

        const addRation = document.querySelector('.add-racion');

        if (addRation && addRation.classList.contains('is-hidden')) {
            addRation.classList.remove('is-hidden');
        }
    }

    insertMessages(parent, messages) {
        this._clearChild(parent);

        let html = '';

        if (messages.length === 0) {
            html = `
                <div class="is-size-5 has-text-centered pt-3 empty-messages">Дані відсутні</div>
            `;
        }

        for (let i = 0; i < messages.length; i++) {
            html += `
            <div class="message-item">
                <div class="message-user pb-2">
                    ${messages[i].user}
                </div>
                <div class="message-body">
                    ${messages[i].message}
                </div>
            </div>
            `;
        }
        parent.innerHTML = html;
    }

    _clearChild(parent) {
        while (parent.firstChild) {
            parent.removeChild(parent.lastChild);
        }
    }

    sendMessage = () => {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const body = this.main.querySelector('#message-body').value;
        const userFullName = this.main.querySelector('#user-full-name').value;

        if (body === '' || !this.activeRoom) {
            return;
        }
        this.main.querySelector('#message-body').value = '';

        this.localRenderMessage(body, userFullName);

        const bodyData = {
            chat_name: this.activeRoom,
            body,
        };

        fetch('/messanger/messages', {
            method: 'post',
            headers: {
                'X-CSRF-TOKEN': token,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(bodyData),
        })
    }

    localRenderMessage = (text, userFullName) => {
        const parent = document.createElement('div');
        parent.classList.add('message-item');

        const user = document.createElement('div');
        user.classList.add('message-user', 'pb-2');
        user.innerText = userFullName;

        parent.appendChild(user);

        const messageHtml = document.createElement('div');
        messageHtml.classList.add('message-body');
        messageHtml.innerText = text;

        parent.appendChild(messageHtml);

        const parentMessages = this.main.querySelector('.chat-box');

        const lastChild = parentMessages.lastElementChild;

        if (lastChild.classList.contains('empty-messages')) {
            this._clearChild(parentMessages);
        }

        parentMessages.appendChild(parent);

        parentMessages.scrollTop = parentMessages.scrollHeight;
    }

    loadRoom = (ownerId, interlocutorId) => {
        fetch(`/room?owner_id=${ownerId}&interlocutor_id=${interlocutorId}`)
            .then(data => data.json())
            .then(data => {
                this.showRoom(data.room_name);
            })
            .catch(error => console.log(error));
    }

    showRoom = (id) => {
        const parent = this.main.querySelector('.bar-items');
        const childrens = [...parent.children];

        const isExistsRoom = childrens.some(room => room.dataset.room == id);

        if (isExistsRoom) {
            this.fetchRoom(id);
        } else {
            this.createRoom(id);
        }
    }

    createRoom = (id) => {
        fetch(`/room/${id}`)
            .then(data => data.json())
            .then(data => {
                this.insertRoomInParent(data);
            })
            .catch(error => console.log(error));
    }

    fetchRoom = (id) => {
        fetch(`/room/${id}`)
            .then(data => data.json())
            .then(data => {

                this.fetchRoomMessage(data.room_name);
            })
            .catch(error => console.log(error));
    }

    insertRoomInParent = (room) => {
        const parent = this.main.querySelector('.bar-items');

        const dialog = document.createElement('div');

        dialog.classList.add('user-item', 'is-clickable');
        dialog.dataset.room = room.room_name;
        dialog.dataset.userId = room.collocutor_id;
        dialog.dataset.userFull = room.collocutor;
        dialog.textContent = room.collocutor;

        const lastChild = parent.lastElementChild;

        if (lastChild.classList.contains('empty-dialog')) {
            this._clearChild(parent);
        }

        parent.appendChild(dialog);

        this.fetchRoomMessage(room.room_name);
    }

    fetchRoomMessage = (id) => {
        fetch(`/messanger/messages/${id}`)
            .then(data => data.json())
            .then(data => {
                this.changeChannel(id);
                const parent = this.main.querySelector('.chat-box');
                this.insertMessages(parent, data);
                this.loader.classList.remove('is-block');

                if (document.querySelector('.add-racion')) {
                    this.setUserForCreateRation(id);
                }
            })
            .catch(error => console.log(error));
    }

    changeChannel = (id) => {
        if (this.activeRoom !== null) {
            this.gatewayChats.leave(`chat.${this.activeRoom}`);
        }

        this.activeRoom = id;

        this
            .gatewayChats.private(`chat.${this.activeRoom}`)
            .listen('MessageSent', (e) => {
                const userId = this.main.querySelector('#user-id').value;

                if (e.userId != userId) {
                    this.insertMessage(e);
                }
            });
    }

    insertMessage = ({ message }) => {
        const parent = document.createElement('div');
        parent.classList.add('message-item');

        const user = document.createElement('div');
        user.classList.add('message-user', 'pb-2');
        user.innerText = message.user;

        parent.appendChild(user);

        const messageHtml = document.createElement('div');
        messageHtml.classList.add('message-body');
        messageHtml.innerText = message.message;

        parent.appendChild(messageHtml);

        const parentMessages = this.main.querySelector('.chat-box');

        const lastChild = parentMessages.lastElementChild;

        if (lastChild.classList.contains('empty-messages')) {
            this._clearChild(parentMessages);
        }

        parentMessages.appendChild(parent);

        parentMessages.scrollTop = parentMessages.scrollHeight;
    }

    _handleClickSubmitForm = () => {
        const form = document.querySelector('#form');
        const modal = document.querySelector('.modal[data-id="create-event"]');

        const title = form.querySelector('.ration-name').value;
        const startRationVal = form.querySelector('.start').value;
        const endRationVal = form.querySelector('.end').value;
        const lunch = form.querySelector('.lunch').value;
        const dinner = form.querySelector('.dinner').value;
        const nooning = form.querySelector('.nooning').value;
        const supper = form.querySelector('.supper').value;
        const user_id = form.querySelector('#user-id-owner').value;

        try {
            this
                .checkEmpty(startRationVal, 'початок')
                .checkEmpty(endRationVal, 'кінець')
                .checkEmpty(title, 'раціон')
                .checkEmpty(lunch, 'сніданок')
                .checkEmpty(dinner, 'обід')
                .checkEmpty(supper, 'вечеря');
        } catch (error) {
            console.log(error);
            return;
        }

        const rations = { lunch, dinner, supper };

        nooning ? rations.nooning = nooning : null;

        const start = new Date(startRationVal);
        const end = new Date(endRationVal);

        start.setHours(0, 0, 0);
        end.setHours(0, 0, 0);

        const dateEnd = new Date(end.toString());
        dateEnd.setDate(dateEnd.getDate() + 1);

        this._saveEvent({
            start: this.getFormatDate(start),
            end: this.getFormatDate(dateEnd),
            title,
        }, rations, modal, user_id);
    }

    _saveEvent(values, rations, modal, user_id) {
        const wrappedSpinner = modal.querySelector('.wrapped-spinner');
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        wrappedSpinner.style.display = 'flex';

        fetch(PATH_URL_CREATE_EVENTS, {
            method: 'POST',
            body: JSON.stringify({
                ...values,
                rations,
                user_id,
            }),
            headers: {
                'X-CSRF-TOKEN': token,
                'Content-Type': 'application/json',
            },
        })
            .then(respose => {
                if (respose.status === 403) {
                    wrappedSpinner.style.display = 'none';
                    respose.json()
                        .then(error => alert(error.msg));
                    throw new Error(error);
                } else if (respose.status === 400) {
                    wrappedSpinner.style.display = 'none';
                    respose.json()
                        .then(err => {
                            const keys = Object.keys(err.errors);
                            const res = keys.reduce((acc, cur) => acc + err.errors[cur] + '\n', '');
                            alert(res);
                        });
                    throw new Error(error);
                }
                else {
                    return respose.json();
                }
            })
            .then(data => {
                wrappedSpinner.style.display = 'none';
                modal.classList.remove(ACTIVE_CLASS_NAME);
            })
            .catch(error => console.log(error));
    }


    checkEmpty = (val, name) => {
        if (val === '') {
            const msg = `Поле ${name} порожнє`;
            alert(msg);
            throw new Error(msg);
        }
        return this;
    }

    getFormatDate = (date) => {

        function pad(number) {
            if (number < 10) {
                return '0' + number;
            }
            return number;
        }

        return date.getUTCFullYear() +
            '-' + pad(date.getMonth() + 1) +
            '-' + pad(date.getDate()) +
            ' ' + pad(date.getHours()) +
            ':' + pad(date.getMinutes()) +
            ':' + pad(date.getSeconds());
    }
}

export default Messanger;

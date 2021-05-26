
const SELECTOR_NAME = '#calendar';
const LOCALE = 'uk';
const PATH_URL_LOAD_EVENTS = '/ration/events';
const PATH_URL_CREATE_EVENTS = '/ration/events';
const MODAL_SELECTOR = '.modal';
const ACTIVE_CLASS_NAME = 'is-active';
const CLOSE_BTN_SELECTOR = '.modal-close';
const OVERLAY_CLASS = '.modal-background';

const DELETE_EVENT_URL = '/ration/events/delete';
const UPDATE_EVENT_URL = '/ration/events/update';

class Calendar {

    _calendarEl = null;
    _calendar = null;
    _events = [];
    _calendarSpinner = null;

    constructor(selector = SELECTOR_NAME) {
        this._calendarEl = document.querySelector(selector);

        if (this._calendarEl !== null) {
            this._start();
        }
    }

    _start = () => {
        this._calendar = new FullCalendar.Calendar(this._calendarEl, this._getSettings());
        this._calendarSpinner = document.querySelector('.calendar-spinner');

        document
            .querySelector('#submit-create-event')
            .addEventListener('click', this.handleClickFormBtn);

        document
            .querySelector('#delete-event')
            .addEventListener('click', this._deleteEvent);

        this._calendar.render();
        this._handlersCloseModals();
        this.loadEvents();
    }

    _getSettings = () => ({
        locale: LOCALE,
        initialView: 'dayGridMonth',
        displayEventTime: false,
        eventOverlap: false,
        selectable: true,
        displayEventTime: false,
        defaultAllDay: true,
        headerToolbar: { center: 'dayGridMonth,timeGridWeek,listMonth' },
        editable: true,
        eventDidMount: (event) => {
            if (event.view.type === 'listMonth') {
                document.querySelector('#print').classList.remove('is-hidden');
            } else {
                document.querySelector('#print').classList.add('is-hidden');
            }
        },
        select: (info) => this._handleSelectCells(info),
        eventClick: (info) => this._handleClickEvent(info),
        eventChange: (info) => this._handleChangeEvent(info),
    });

    _handleChangeEvent = (info) => {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        this._calendarSpinner.style.display = 'flex';

        const bodyData = {
            start: this.getFormatDate(info.event.start),
            end: this.getFormatDate(info.event.end),
        };

        fetch(`${UPDATE_EVENT_URL}/${info.event.id}`, {
            method: 'PUT',
            body: JSON.stringify(bodyData),
            headers: {
                'X-CSRF-TOKEN': token,
                'Content-Type': 'application/json',
            },
        })
            .then(respose => {
                if (respose.status === 403) {
                    this._calendarSpinner.style.display = 'none';
                    info.revert();
                    respose.json()
                        .then(error => alert(error.msg));
                } else {
                    return respose.json();
                }

            })
            .then(data => {
                this._calendarSpinner.style.display = 'none';

                const idx = this._events.findIndex(item => item.id == info.event.id);
                this._events[idx] = { ...this._events[idx], ...bodyData };
            })
            .catch(error => console.log(error));
    }

    _handleClickEvent = ({ event }) => {
        const modal = document.querySelector(`${MODAL_SELECTOR}[data-id="show-event"]`);
        modal.classList.add(ACTIVE_CLASS_NAME);
        const { title, startStr: start, endStr: end, id } = event;
        const { recipes } = event.extendedProps;

        modal.querySelector('.title p')
            .textContent = title;

        modal.querySelector('.title i')
            .setAttribute('data-id', id);

        modal.querySelector('.start').value = start.substring(0, 10);

        let currEnd = '';

        if (end === null) {
            currEnd = start.substring(0, 10);
        } else {
            currEnd = end.substring(0, 10);
        }

        modal.querySelector('.end').value = currEnd;

        let recipeHtml = '';

        for (let i = 0; i < recipes.length; i++) {
            recipeHtml += `
                <tr>
                    <td title="${recipes[i].ration_type_part.range}">${recipes[i].ration_type_part.name}</td>
                    <td><a href="/recipe/show/${recipes[i].recipe_id}" target="_blank">${recipes[i].name}</a></td>
                </tr>
            `;
        }

        const tbody = modal.querySelector('.table tbody');

        this._clearChild(tbody);

        tbody.innerHTML = recipeHtml;
    }

    _clearChild(parent) {
        while (parent.firstChild) {
            parent.removeChild(parent.lastChild);
        }
    }

    _deleteOneDay(date) {
        const endDate = new Date(date);
        return new Date(endDate.setDate(endDate.getDate() - 1)).toISOString().substring(0, 10);
    }

    _handleSelectCells = (info) => {
        const { startStr, endStr } = info;

        if (this.checkEvents(startStr, endStr)) {
            alert('Ви не можете додати раціон, так як на цей проміжок часу вже призначений раціон!');
            return;
        }

        this._createEventManyDays(startStr, endStr);
    }

    _isSelectMoreDays = (startVal, endVal) => {
        endVal.setDate(endVal.getDate() - 1);
        const start = startVal.toISOString().substring(0, 10);
        const end = endVal.toISOString().substring(0, 10);
        return start !== end;
    }

    loadEvents = () => {
        fetch(PATH_URL_LOAD_EVENTS)
            .then(data => data.json())
            .then(data => {
                this._events = data;
                this.setEvents(data);
                this._calendarSpinner.style.display = 'none';
            })
            .catch(error => console.log(error));
    }

    _createEventManyDays = (start, end) => {
        const modal = document.querySelector(`${MODAL_SELECTOR}[data-id="create-event"]`);
        modal.classList.add(ACTIVE_CLASS_NAME);

        const startInput = modal.querySelector('.start');
        const endInput = modal.querySelector('.end');

        const endDate = new Date(end);
        const endCurr = new Date(endDate.setDate(endDate.getDate() - 1)).toISOString().substring(0, 10);

        startInput.value = start;
        endInput.value = end;
    }

    setEvents = (events) => {
        if (events.length === 0) {
            alert('Дані відсутні');
            return;
        }

        events.forEach(event => {
            this._calendar.addEvent(event);
        });
    }

    _handlersCloseModals = () => {
        const overlays = document.querySelectorAll(OVERLAY_CLASS);
        const closeBtnModals = document.querySelectorAll(CLOSE_BTN_SELECTOR);

        overlays.forEach(overlay => {
            const modal = overlay.closest(MODAL_SELECTOR);

            overlay.addEventListener('click', (event) => {
                if (event.target.classList.contains('modal-background')) {
                    modal.classList.remove(ACTIVE_CLASS_NAME);
                }
            });
        });

        closeBtnModals.forEach(btn => {
            const modal = btn.closest(MODAL_SELECTOR);

            btn.addEventListener('click', () => {
                modal.classList.remove(ACTIVE_CLASS_NAME);
            });
        });
    }

    handleClickFormBtn = (event) => {
        const modal = event.target.closest(MODAL_SELECTOR);

        const inputStart = modal.querySelector('.start');
        const inputEnd = modal.querySelector('.end');
        const lunch = modal.querySelector('.lunch').value;
        const dinner = modal.querySelector('.dinner').value;
        const nooning = modal.querySelector('.nooning').value;
        const supper = modal.querySelector('.supper').value;

        const startVal = inputStart.value;
        const endVal = inputEnd.value;
        const title = modal.querySelector('.ration_id').value;

        try {
            this
                .checkEmpty(startVal, 'початок')
                .checkEmpty(endVal, 'кінець')
                .checkEmpty(title, 'раціон')
                .checkEmpty(lunch, 'сніданок')
                .checkEmpty(dinner, 'обід')
                .checkEmpty(supper, 'вечеря');
        } catch (error) {
            console.log(error);
            return;
        }

        if (this.checkEvents(startVal, endVal)) {
            alert('Ви не можете додати раціон, так як на цей проміжок часу вже призначений раціон!');
            return;
        }

        const rations = { lunch, dinner, supper };

        nooning ? rations.nooning = nooning : null;

        const start = new Date(startVal);
        const end = new Date(endVal);

        start.setHours(0, 0, 0);
        end.setHours(0, 0, 0);

        this._saveEvent({
            start: this.getFormatDate(start),
            end: this.getFormatDate(end),
            title,
        }, rations, modal);
    }

    _saveEvent(values, rations, modal) {
        const wrappedSpinner = modal.querySelector('.wrapped-spinner');
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        wrappedSpinner.style.display = 'flex';

        fetch(PATH_URL_CREATE_EVENTS, {
            method: 'POST',
            body: JSON.stringify({
                ...values,
                rations,
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
                this._calendar.addEvent(data);
                this._events.push(data);
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

    checkEvents(start, end) {
        const endDate = new Date(end);
        const endCurr = new Date(endDate.setDate(endDate.getDate() - 1)).toISOString().substring(0, 10);

        return this._events.some(item => {
            const localEndDate = new Date(item.end.substring(0, 10));
            const localEndCurr = new Date(localEndDate.setDate(localEndDate.getDate() - 1))
                .toISOString()
                .substring(0, 10);
            const x = new Date(item.start.substring(0, 10)).getTime();
            const y = new Date(localEndCurr).getTime();

            const a = new Date(start.substring(0, 10)).getTime();
            const b = new Date(endCurr).getTime();

            if (Math.min(x, y) <= Math.max(a, b) && Math.max(x, y) >= Math.min(a, b)) {
                return true;
            }
            return false;
        });
    }

    _deleteEvent = (e) => {
        const isDelete = confirm('Ви дійсно хочете видалити цю подію?');
        const modal = e.target.closest(MODAL_SELECTOR);
        const wrappedSpinner = modal.querySelector('.wrapped-spinner');
        if (!isDelete) {
            return;
        }

        const id = e.target.dataset.id;
        wrappedSpinner.style.display = 'flex';

        fetch(`${DELETE_EVENT_URL}/${id}`)
            .then(data => data.json())
            .then(data => {
                this._calendar.getEventById(id).remove();
                wrappedSpinner.style.display = 'none';
                const idx = this._events.findIndex(item => item.id === id);
                this._events.splice(idx, 1);
                modal.classList.remove(ACTIVE_CLASS_NAME);
            })
            .catch(error => console.log(error));

    }
}

export default Calendar;

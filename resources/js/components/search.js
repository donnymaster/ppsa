import debounce from '../utils/debounce';

const DEFAULT_URL = '/doctor-search';

class SearchInputAjax {

    _searchParents = null;
    searchForm = null;
    _handlersList = [];
    _items = [];

    constructor() {
        this._init();
    }

    _init() {
        this._searchParents = document.querySelectorAll('.search-parent');

        if (this._searchParents.length === 0) {
            return;
        }

        document.addEventListener('click', this._onHideWindow);
        this.searchForm = document.querySelectorAll('.wrapped-search-window');

        for (let iter = 0; iter < this.searchForm.length; iter++) {
            this.searchForm[iter]
                .addEventListener('click', this._onClickDoctor);
        }

        for (let iter = 0; iter < this._searchParents.length; iter++) {
            const hanldeClick = debounce(this._handleChangeInput.bind(this, iter), 500);
            this._handlersList.push(hanldeClick);
            this._searchParents[iter]
                .querySelector('.input-search')
                .addEventListener('input', hanldeClick);
        }
    }

    _handleChangeInput = (iter, event) => {
        const value = event.target.value;

        if (value === '') {
            return;
        }

        const url = this._searchParents[iter].querySelector('.search-url').value;

        fetch(url + value)
            .then((data) => data.json())
            .then((data) => {
                console.log(data);
                this._showWindow(data, this._searchParents[iter]);
            })
            .catch((error) => {
                console.log(error);
            });
    }

    _showWindow(data, mainParent) {
        // get parent
        const parent = mainParent.querySelector('.wrapped-search-window');
        const id = mainParent.dataset.id;
        const show = mainParent.dataset.show;
        // create window
        const window = document.createElement('div');
        window.classList.add('box', 'search-window', 'pl-0', 'pr-0', 'pb-2', 'pt-2');

        parent.dataset?.pos == 'bottom' ? window.style.bottom = '40px' : window.style.top = '5px';

        let content = null;

        if (data.length !== 0) {
            content = this._createListItems(data, id, show);
        } else {
            content = '<p class="pl-2">Дані відсутні</p>';
        }

        window.innerHTML = content;
        // clear parent
        this._clearChild(parent);
        parent.appendChild(window);
    }

    _createListItems(items, id, show) {
        const keys = show.split(',');

        let html = '<table class="table is-narrow percent-100"><tbody>';
        for (let iter = 0; iter < items.length; iter++) {
            html += `
                <tr class="is-clickable pl-2">
                    <td
                        data-doctor="${items[iter][id]}"
                        class="doctor-item"
                    >
                    ${keys.reduce((acc, curr) => `${acc} ${items[iter][curr]}`, '')}
                    </td>
                </tr>
            `;
        }
        html += '</table></tbody>';
        return html;
    }

    _clearChild(parent) {
        while (parent.firstChild) {
            parent.removeChild(parent.lastChild);
        }
    }

    _onHideWindow = (event) => {
        if (!event.target.closest('.search-parent')) {
            const windowList = document.querySelectorAll('.wrapped-search-window');
            windowList.forEach(item => {
                this._clearChild(item);
            });
        }
    }

    _onClickDoctor = (event) => {
        if (!event.target.classList.contains('doctor-item')) {
            return;
        }

        const doctorId = event.target.dataset.doctor;
        const elId = event.target.dataset.elementId;

        const parent = event.target.closest('.search-parent');
        const windowParent = parent.querySelector('.wrapped-search-window');
        this.setDoctorId(parent, doctorId, windowParent);
        // set name doctor in input
        const previewInput = parent.querySelector('.input-search');
        previewInput.value = event.target.textContent.trim();
    }

    setDoctorId = (parent, value, windowParent) => {

        const input = parent.querySelector('.doctor_id');
        // input.value = value;
        input.setAttribute('value', value);
        this._clearChild(windowParent);
    }

    clearAllHandler = () => {
        document.removeEventListener('click', this._onHideWindow);

        // clear form listeners
        for (let iter = 0; iter < this.searchForm.length; iter++) {
            this.searchForm[iter]
                .removeEventListener('click', this._onClickDoctor);
        }

        // clear listeners inputs
        for (let iter = 0; iter < this._searchParents.length; iter++) {
            this._searchParents[iter]
                .querySelector('.input-search')
                .removeEventListener('input', this._handlersList[iter]);
        }
        this._handlersList = [];
    }

    update() {
        this.clearAllHandler();
        this._init();
    }
}

export default SearchInputAjax;

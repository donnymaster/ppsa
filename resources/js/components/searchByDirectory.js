import debounce from '../utils/debounce';

const PRODUCT_URL = '/products-info';
const FULL_PRODUCT_URL = '/product-info';

class SearchByDirectory {
    _wrapped = null;
    _input = null;

    constructor() {
        this._wrapped = document.querySelector('.search-by-directory');

        if (this._wrapped) {
            this._init();
        }
    }

    _init() {
        this._input = this._wrapped.querySelector('.search-input');
        this._input.addEventListener('input', debounce(this._changeInput, 400));
        document.querySelector('.wrapped-search-window').addEventListener('click', this._selectedProduct);
        document.addEventListener('click', this._onHideWindow.bind(this));
    }

    _changeInput = (event) => {
        const value = event.target.value;

        if (value === '') {
            return;
        }

        fetch(`${PRODUCT_URL}?search=${value}`)
            .then(data => data.json())
            .then(data => { this._showResult(data); })
            .catch(error => console.log(error));
    }

    _showResult = (data) => {
        const parent = this._wrapped.querySelector('.wrapped-search-window');
        const window = document.createElement('div');
        window.classList.add('box', 'search-window', 'pl-0', 'pr-0', 'pb-2', 'pt-2');

        let content = null;
        if (data.length === 0) {
            content = '<p class="pl-2">Дані відсутні</p>';
        } else {
            content = this._createProductList(data);
        }

        window.innerHTML = content;
        this._clearChild(parent);
        parent.appendChild(window);
    }

    _createProductList = (data) => {
        let html = '<table class="table is-narrow percent-100"><tbody>';
        for (let iter = 0; iter < data.length; iter++) {
            html += `
                <tr class="is-clickable pl-2">
                    <td
                        data-product-id="${data[iter].id}"
                        class="product-item"
                    >
                        ${data[iter].name}
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

    _onHideWindow(event) {
        if (!event.target.closest('.input.search-input')) {
            const windowList = document.querySelectorAll('.wrapped-search-window');
            windowList.forEach(item => {
                this._clearChild(item);
            });
        }
    }

    _selectedProduct = (event) => {
        if (!event.target.classList.contains('product-item')) {
            return;
        }
        this._input.disabled = true;
        const { productId } = event.target.dataset;

        fetch(`${FULL_PRODUCT_URL}/${productId}`)
            .then(data => data.json())
            .then(data => this._renderProductFull(data))
            .catch(error => console.log(error))
            .finally(() => this._input.disabled = false);
    }

    _renderProductFull = (data) => {
        const parent = document.querySelector('.product-content');
        const input = document.querySelector('.search-input');
        input.value = data.name;
        const maxIndex = Math.max(data.mean.length, data.containing.length);
        this._clearChild(parent);
        let tableData = '';

        for (let iter = 0; iter < maxIndex; iter++) {
            tableData += `
                <tr>
                    <td>${data.mean[iter]?.name ? data.mean[iter].name : '-'}</td>
                    <td>${data.containing[iter]?.name ? data.containing[iter].name : '-'}</td>
                </tr>
            `;
        }
        parent.innerHTML = tableData;
        const titleMean = document.querySelector('.title-mean');
        const titleContaining = document.querySelector('.title-containing');

        titleMean.textContent = data.name;
        titleContaining.textContent = data.name;
    }
}

export default SearchByDirectory;

const DEFAULT_SELECTOR = '.dropdown-trigger';
const CLASS_DROPDOWN = '.dropdown';
const CLASS_ACTIVE = 'is-active';
class Drop {
    _items = [];
    _selector = '';

    constructor(selector = DEFAULT_SELECTOR) {
        this._selector = selector;
        this._items = document.querySelectorAll(selector);
        this._init();
    }

    _init() {
        if (!this._items.length) {
            return;
        }

        this._items.forEach(item => {
            item.addEventListener('click', this.handleClick);
        });

        // body
        document.querySelector('body').addEventListener('click', this.onClickBody);
    }

    handleClick = (event) => {
        const parent = event.target.closest(CLASS_DROPDOWN);
        parent.classList.toggle(CLASS_ACTIVE);
    }

    onClickBody = (event) => {
        const dropdown = event.target.closest(this._selector);

        for (let iter = 0; iter < this._items.length; iter++) {
            if (this._items[iter] !== dropdown) {
                const parent = this._items[iter].closest(CLASS_DROPDOWN);
                parent.classList.remove(CLASS_ACTIVE);
            }
        }
    }
}

export default Drop;

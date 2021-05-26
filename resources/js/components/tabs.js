
const DEFAULT_NAME_SELECTOR = '.tabs';
const EVENT_NAME            = 'click';
const ACTIVE_CLASS          = 'is-active';
const HIDE_CLASS            = 'is-hidden';
const MAIN_NODE             = 'A';

class Tabs {
    _items        = [];
    _nameSelector = '';

    constructor(nameSelector = DEFAULT_NAME_SELECTOR) {
        this._items = document.querySelectorAll(nameSelector);
        this._init();
        this._nameSelector = nameSelector;
    }

    _init() {
        if (!this._items.length) {
            return;
        }

        for (let iter = 0; iter < this._items.length; iter++) {
            this._items[iter].addEventListener(EVENT_NAME, this._handleClick.bind(this));
        }
    }

    _handleClick(event) {
        const parent = event.target.parentElement;

        if (event.target.nodeName !== MAIN_NODE || parent.nodeName !== 'LI') {
            return;
        }

        if (this._removeClassFromActive(event.target)) {
            return;
        }

        const dataAttrValue = event.target.dataset.tab;
        this._changeContent(event.target.closest(this._nameSelector), dataAttrValue);

        event.target.parentElement.classList.add(ACTIVE_CLASS);
    }

    _removeClassFromActive(target) {
        const parentElement = target.closest(this._nameSelector);
        const activeElement = parentElement.querySelector(`li.${ACTIVE_CLASS}`);

        if (target.parentElement === activeElement ) {
            return true;
        }

        activeElement.classList.remove(ACTIVE_CLASS);
    }

    _changeContent(tab, id) {
        const selectedTab = tab.querySelector(`.content>div[data-tab="${id}"]`);
        const activeTab = tab.querySelector(`.content>div:not(.${HIDE_CLASS})`);

        if (selectedTab === activeTab) {
            return;
        }

        selectedTab.classList.remove(HIDE_CLASS);
        activeTab.classList.add(HIDE_CLASS);
    }
}

export default Tabs;

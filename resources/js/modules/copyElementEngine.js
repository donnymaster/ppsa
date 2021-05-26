

class CopyElementEngine {
    _settings = null;

    constructor(settings) {
        this._settings = settings;

        this._start();
    }

    _start = () => {
        const btnPlus = document.querySelector(this._settings.plusSelector);
        const btnMinus = document.querySelector(this._settings.minusSelector);

        btnPlus.addEventListener('click', this._handleClickPlus);
        btnMinus.addEventListener('click', this._handleClickMinus);
    }

    _handleClickPlus = () => {
        const parent = document.querySelector(this._settings.parentSelector);
        const countChild = parent.childElementCount;

        if (countChild >= this._settings.maxItems) {
            alert(this._settings.messageMaxItems);
            return;
        }

        const copyEl = parent.lastElementChild.cloneNode(true);
        parent.appendChild(copyEl);
    }

    _handleClickMinus = () => {
        const parent = document.querySelector(this._settings.parentSelector);
        const countChild = parent.childElementCount;

        if (countChild === this._settings.minItems) {
            alert(this._settings.messageMinItems);
            return;
        }

        parent.removeChild(parent.lastElementChild);
    }
}

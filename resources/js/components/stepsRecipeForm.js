const MAX_COUNT_STEPS = 10;
const MIN_COUNT_STEPS = 1;
const MAX_COUNT_MESSAGE = 'Максимальна кількість кроків 10';
const MIN_COUNT_MESSAGE = 'Мінімальна кількість кроків 1';

class StepsRecipe {

    _parent = null;
    _stepWrapped = null;

    constructor() {
        this._parent = document.querySelector('.steps-main');
        console.log(this._parent);
        if (this._parent !== null) {
            this._init();
        }
    }

    _init() {
        this._stepWrapped = this._parent.querySelector('.steps-items');

        const plus = this._parent.querySelector('.plus');
        const minus = this._parent.querySelector('.minus');

        plus.addEventListener('click', this._handleClickPlus);
        minus.addEventListener('click', this._handleClickMinus);
    }

    _handleClickPlus = () => {
        if (this._stepWrapped.childElementCount >= MAX_COUNT_STEPS) {
            alert(MAX_COUNT_MESSAGE);
            return;
        }

        const lastChild = this._stepWrapped.lastElementChild;
        const copyChild = this._copyElement(lastChild);

        this._stepWrapped.appendChild(copyChild);
    }

    _handleClickMinus = () => {
        const lastChild = this._stepWrapped.lastElementChild.querySelector('.link-step-del');

        if (this._stepWrapped.childElementCount === MIN_COUNT_STEPS) {
            alert(MIN_COUNT_MESSAGE);
            return;
        }

        if (lastChild?.childElementCount == 1) {
            return;
        }

        this._stepWrapped.removeChild(this._stepWrapped.lastElementChild);
    }

    _copyElement(el) {
        const clone = el.cloneNode(true);
        const id = parseInt(clone.dataset.id) + 1;
        clone.dataset.id = id;

        clone.querySelector('.step-name').name = `steps[${id}][title]`;
        if (clone.querySelector('.step-image')) {
            clone.querySelector('.step-image').name = `steps[${id}][preview]`;
        }
        clone.querySelector('.step-body').name = `steps[${id}][body]`;

        const hideInput = clone.querySelector('.idx-step');
        if (hideInput) {
            clone.removeChild(hideInput);
            const label = clone.querySelector('.label');
            const link = label.querySelector('a');
            label.removeChild(link);
        }

        return clone;
    }
}

export default StepsRecipe;

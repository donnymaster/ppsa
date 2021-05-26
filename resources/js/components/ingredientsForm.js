const SELECTOR = '.ingredients-main';
const MAX_VALUE = 20;
const MIN_VALUE = 1;
const MAX_COUNT_MESSAGE = `Максимальна кількість кроків ${MAX_VALUE}`;
const MIN_COUNT_MESSAGE = `Мінімальна кількість кроків ${MIN_VALUE}`;

class IngredientsForm {

    _form = null;
    _handlersWithAddItem = [];
    _handlersWithDeleteItem = [];

    constructor(selector = SELECTOR) {
        this._form = document.querySelector(selector);

        if (this._form !== null) {
            this._init();
        }
    }

    _init() {
        const plus = this._form.querySelector('.plus');
        const minus = this._form.querySelector('.minus');

        plus.addEventListener('click', this._clickPlus);
        minus.addEventListener('click', this._clickMinus);
    }

    _clickPlus = () => {
        const parent = this._form.querySelector('.ingredients-wrapped tbody');
        const lastChild = parent.lastElementChild;

        this.insertInEnd(parent, lastChild);

        this.runHandlers(this._handlersWithAddItem);
    }

    _clickMinus = () => {
        const parent = this._form.querySelector('.ingredients-wrapped tbody');

        this.clearLastChildren(parent);

        this.runHandlers(this._handlersWithDeleteItem);
    }

    runHandlers = (handlers) => {
        if (handlers.length === 0) {
            return;
        }

        handlers.forEach((item) => {
            if (this.isFunction(item)) {
                item();
            }
        });
    }

    isFunction = (functionToCheck) => {
        return functionToCheck && {}.toString.call(functionToCheck) === '[object Function]';
    }

    clearLastChildren = (parent) => {
        const countChildren = parent.childElementCount;
        const lastChild = parent.lastElementChild.querySelector('.par-link');

        if (lastChild?.childElementCount == 1) {
            return;
        }

        if (countChildren === MIN_VALUE) {
            alert(MIN_COUNT_MESSAGE);
            return;
        }

        parent.removeChild(parent.lastElementChild);
    }

    insertInEnd = (parent, node) => {
        const countChildren = parent.childElementCount;

        if (countChildren >= MAX_VALUE) {
            alert(MAX_COUNT_MESSAGE);
        } else {
            const id = parseInt(node.dataset.id) + 1;
            const dupNode = node.cloneNode(true);
            dupNode.setAttribute('data-id', id);

            const delBtn = dupNode.querySelector('a.link-step-ingredient');

            if (delBtn) {
                const td = dupNode.querySelector('.par-link');
                td.removeChild(delBtn);
            }

            dupNode.querySelector('.ingredient_id')
                .setAttribute('name', `ingredients[${id}][ingredient_id]`);

            dupNode.querySelector('.count')
                .setAttribute('name', `ingredients[${id}][count]`);

            dupNode.querySelector('.unit')
                .setAttribute('name', `ingredients[${id}][unit]`);

            parent.appendChild(dupNode);
        }
    }

    pushHandler = (type, handler) => {
        switch (type) {
            case 'add':
                this._handlersWithAddItem.push(handler);
                break;
            case 'delete':
                this._handlersWithDeleteItem.push(handler);
                break;
            default:
                break;
        }
    }
}

export default IngredientsForm;

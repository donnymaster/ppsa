const SELECTOR_NAME_BTN = '.modal-btn';
const ACTIVE_CLASS_NAME = 'is-active';
const CLOSE_BTN_SELECTOR = '.modal-close';
const OVERLAY_CLASS = '.modal-background';

class Modal {

    _btns = null;

    constructor() {
        this._btns = document.querySelectorAll(SELECTOR_NAME_BTN);
        this._init();
    }

    _init = () => {
        if (!this._btns.length) {
            return;
        }

        for (let i = 0; i < this._btns.length; i++) {
            const btn = this._btns[i];
            const id = btn.dataset.id;
            const modal = document.querySelector(`.modal[data-id="${id}"]`);

            btn.addEventListener('click', () => {
                modal.classList.add(ACTIVE_CLASS_NAME);
            });

            modal
                .querySelector(CLOSE_BTN_SELECTOR)
                .addEventListener('click', () => {
                    modal.classList.remove(ACTIVE_CLASS_NAME);
                });

            modal
                .querySelector(OVERLAY_CLASS)
                .addEventListener('click', (event) => {
                    if (event.target.classList.contains('modal-background')) {
                        modal.classList.remove(ACTIVE_CLASS_NAME);
                    }
                });
        }
    }
}

export default Modal;

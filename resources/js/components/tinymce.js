
const DEFAULT_SELECTOR = '.tiny-init';
const WRAPPED_SELECTOR = '.tiny-wrapped';
const SKELETON_CLASS = '.placeholder-item';
const HDIE_CLASS = 'is-hidden';
const MESSAGE = 'Заповніть поле статті!';

class InitTinyMCE {
    _items = [];
    _selector = '';

    constructor(selector = DEFAULT_SELECTOR) {
        this._items = document.querySelectorAll(selector);
        this._selector = selector;
        this._init();
    }

    _init() {
        if (!this._items.length) {
            return;
        }

        if (typeof tinymce === 'undefined' || tinymce === null) {
            throw Error('Library TinyMCE not found!');
        }

        tinymce.init(this.getConfigTinyMCE());
    }

    getConfigTinyMCE() {
        return {
            selector: this._selector,
            plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak table',
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            toolbar_mode: 'floating',
            language: 'uk',
            setup: this._handleOnInitTinyMCE.bind(this),
            height: '500',
        };
    }

    _handleOnInitTinyMCE(editor) {
        editor.on('PreInit', () => {
            this._visibleEditor();
        });

        editor.on('init', () => {
            const form = editor.targetElm.closest('form');
            form.addEventListener('submit', (event) => {
                const content = editor.getContent({ format: 'text' });
                event.preventDefault();

                if (content === '') {
                    alert(MESSAGE);
                } else {
                    form.submit();
                }
            });
        });
    }

    _visibleEditor() {
        const tinyItems = document.querySelectorAll(WRAPPED_SELECTOR);

        if (!tinyItems.length) {
            return;
        }

        document
            .querySelector('.tox-statusbar__branding')
            .classList
            .add(HDIE_CLASS);

        tinyItems.forEach(element => {
            element
                .querySelector(SKELETON_CLASS)
                .classList
                .add(HDIE_CLASS);

            element
                .querySelector(this._selector)
                .classList
                .remove(HDIE_CLASS);
        });
    }
}

export default InitTinyMCE;

const DEFAULT_PARENT_SELECTOR = '.range-parent';

class RangeInput {
    _pearent = null;
    _lowerSlider = null;
    _upperSlider = null;
    _title = null;
    _valueInput = null;

    constructor(parent = DEFAULT_PARENT_SELECTOR) {
        this._pearent = document.querySelector(parent);

        if (this._pearent !== null) {
            this._init();
        }
    }

    _init() {
        this._lowerSlider = this._pearent.querySelector('.lower');
        this._upperSlider = this._pearent.querySelector('.upper');
        this._title = this._pearent.querySelector('.range-time');
        this._valueInput = this._pearent.querySelector('.value-time');

        const initParams = this._pearent.querySelector('.url-param').value;

        if (initParams !== '') {
            const [start, end] = initParams.split(',');

            this._lowerSlider.value = start;
            this._upperSlider.value = end;
            this.setTimeInTitle(start, end);
        }

        this._lowerSlider.addEventListener('input', this.onChangeUpperSlider);
        this._upperSlider.addEventListener('input', this.onChangeLowerSlider);
    }

    onChangeLowerSlider = () => {
        const lowerVal = parseInt(this._lowerSlider.value);
        const upperVal = parseInt(this._upperSlider.value);

        if (upperVal < lowerVal + 1) {
            this._lowerSlider.value = upperVal - 1;

            if (lowerVal == this._lowerSlider.min) {
                this._upperSlider.value = 1;
            }
        }

        this.setTimeInTitle(lowerVal, upperVal);
    }

    onChangeUpperSlider = () => {
        const lowerVal = parseInt(this._lowerSlider.value);
        const upperVal = parseInt(this._upperSlider.value);

        if (lowerVal > upperVal - 1) {
            this._upperSlider.value = lowerVal + 1;
            if (upperVal == this._upperSlider.max) {
                this._lowerSlider.value = parseInt(this._upperSlider.max) - 1;
            }

        }

        this.setTimeInTitle(lowerVal, upperVal);
    }

    setTimeInTitle = (min, max) => {
        this._title.textContent = `${min}-${max}`;
        this._valueInput.value = `${min},${max}`;
    }
}

export default RangeInput;

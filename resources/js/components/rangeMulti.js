const DEFAULT_PARENT_SELECTOR = '.range-parent';

class RangeMulti {
    _items = null;

    constructor(parent = DEFAULT_PARENT_SELECTOR) {
        this._items = document.querySelectorAll(parent);

        if (this._items !== null) {
            this._init();
        }
    }

    _init = () => {
        this._items.forEach((item) => {
            const lowerSlider = item.querySelector('.lower');
            const upperSlider = item.querySelector('.upper');
            const title = item.querySelector('.range-time');
            const valueInput = item.querySelector('.value-time');

            const initParams = item.querySelector('.url-param').value;

            if (initParams !== '') {
                const [start, end] = initParams.split(',');

                lowerSlider.value = start;
                upperSlider.value = end;
                this.setTimeInTitle(start, end, title, valueInput);
            }

            lowerSlider
                .addEventListener(
                    'input',
                    this.onChangeUpperSlider.bind(this, lowerSlider, upperSlider, title, valueInput)
                );
            upperSlider
                .addEventListener(
                    'input',
                    this.onChangeLowerSlider.bind(this, lowerSlider, upperSlider, title, valueInput)
                );
        });
    }

    onChangeUpperSlider(lowerSlider, upperSlider, title, valueInput, e) {
        const lowerVal = parseInt(lowerSlider.value);
        const upperVal = parseInt(upperSlider.value);

        if (lowerVal > upperVal - 1) {
            upperSlider.value = lowerVal + 1;
            if (upperVal == upperSlider.max) {
                lowerSlider.value = parseInt(upperSlider.max) - 1;
            }

        }

        this.setTimeInTitle(lowerVal, upperVal, title, valueInput);
    }

    onChangeLowerSlider(lowerSlider, upperSlider, title, valueInput, e) {
        const lowerVal = parseInt(lowerSlider.value);
        const upperVal = parseInt(upperSlider.value);

        if (upperVal < lowerVal + 1) {
            lowerSlider.value = upperVal - 1;

            if (lowerVal == lowerSlider.min) {
                upperSlider.value = 1;
            }
        }

        this.setTimeInTitle(lowerVal, upperVal, title, valueInput);
    }

    setTimeInTitle = (min, max, title, valueInput) => {
        title.textContent = `${min}-${max}`;
        valueInput.value = `${min},${max}`;
    }
}

export default RangeMulti;

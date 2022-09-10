import {formatMoney} from 'accounting-js';
import get from 'lodash/get';
import round from 'lodash/round';

export default {
    methods: {
        money(value, config = {}) {
            return formatMoney(Number(value), {
                symbol: get(config, 'symbol', '€'),
                format: '%v %s',
                precision: get(config, 'precision', 2),
                decimal: config.decimalSeparator || '.',
                thousand: config.thousandSeparator || ',',
            })
        },

        number(value, decimals = 2, thousandsSeparator = true) {
            let number = round(value, decimals).toFixed(decimals);

            if (thousandsSeparator) {
                number = number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            return number;
        },

        openModal(name) {
            document.getElementById(name).checked = true;
        },
    },
};

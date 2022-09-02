import {formatMoney} from 'accounting-js';
import get from 'lodash/get';
import round from 'lodash/round';

export default {
    methods: {
        money(value, config = {}) {
            return formatMoney(Number(value) / 100, {
                symbol: get(config, 'symbol', 'CHF'),
                format: '%v %s',
                precision: get(config, 'precision', 2),
                decimal: config.decimalSeparator || ',',
                thousand: config.thousandSeparator || '.',
            })
        },

        number(value, decimals = 2) {
            return round(value, decimals).toFixed(decimals);
        },

        openModal(name) {
            document.getElementById(name).checked = true;
        },
    },
};

import {formatMoney} from 'accounting-js';
import get from 'lodash/get';
import round from 'lodash/round';
import dayjs from "dayjs";

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

        shortenNumber(value, decimals = 2) {
            return Math.abs(value) > 999
                ? Math.sign(value) * ((Math.abs(value) / 1000).toFixed(decimals)) + 'k'
                : Math.sign(value) * Math.abs(value);
        },

        openModal(name) {
            document.getElementById(name).checked = true;
        },

        date(value) {
            // https://day.js.org/docs/en/display/format
            return dayjs(value, 'YYYY-MM-DD').format('DD.MM.YYYY');
        },
    },
};

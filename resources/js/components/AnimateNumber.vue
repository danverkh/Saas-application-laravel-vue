<template>
    <span>{{ currentValue }}</span>
</template>

<script>
import round from 'lodash/round';

export default {
    name: "AnimateNumber",

    props: {
        value: {
            type: Number,
            required: true,
        },
    },

    data() {
        return {
            iteration: 0,
            totalIterations: 15,
            startValue: 0,
            currentValue: 0,
            intervalId: null,
        };
    },

    watch: {
        value() {
            this.reset();
            this.intervalId = setInterval(this.tick, 75);
        },
    },

    computed: {
        movingUp() {
            return this.value > this.startValue;
        },
    },

    methods: {
        tick() {
            let result;

            if (this.movingUp) {
                result = this.easeOutQuad(this.iteration++, (this.value - this.startValue), this.totalIterations) + this.startValue;

                if (this.iteration > this.totalIterations) {
                    clearInterval(this.intervalId);
                }
            } else {
                result = this.easeInQuad(this.iteration--, (this.startValue - this.value), this.totalIterations) + this.value;

                if (this.iteration < 0) {
                    clearInterval(this.intervalId);
                }
            }
            this.currentValue = round(result);
        },

        reset() {
            this.startValue = this.currentValue;
            this.iteration  = this.movingUp ? 0 : this.totalIterations;

            clearInterval(this.intervalId);
        },

        easeOutQuad(currentIteration, changeInValue, totalIterations) {
            return -changeInValue * (currentIteration /= totalIterations) * (currentIteration - 2);
        },

        easeInQuad(currentIteration, changeInValue, totalIterations) {
            return changeInValue * (currentIteration /= totalIterations) * currentIteration;
        },
    },
}
</script>

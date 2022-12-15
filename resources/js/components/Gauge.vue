<template>
    <div class="box">
        <div class="mask">
            <div class="semi-circle" :class="[color]"></div>
            <div class="semi-circle--mask" :style="{transform: `rotate(${degree}deg)`}"></div>
        </div>

        <div v-if="showValue" class="value">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: "Gauge",

    props: {
        value: {
            type: Number,
            required: true,
        },
        maxValue: {
            type: Number,
            default: 100,
        },
        showValue: {
            type: Boolean,
            default: true,
        },
        flippedColors: {
            type: Boolean,
            default: false,
        },
    },

    computed: {
        degree() {
            return (180 / this.maxValue) * this.value;
        },

        color() {
            if (this.degree < 60) return this.flippedColors ? 'bg-green-500' : 'bg-red-500';
            if (this.degree >= 60 && this.degree < 120) return 'bg-yellow-500';
            return this.flippedColors ? 'bg-red-500' : 'bg-green-500';
        },
    },
}
</script>

<style lang="scss" scoped>
$baseFontSize: 16;

@function rem($val) {
    @return #{$val / $baseFontSize}rem;
}

.box {
    position: relative;
    display: grid;
    place-items: center;
}

.mask {
    position: relative;
    overflow: hidden;

    display: block;
    width: rem(100);
    height: rem(50);
    margin: rem(10);
}

.semi-circle {
    position: relative;

    display: block;
    width: rem(100);
    height: rem(50);

    border-radius: 50% 50% 50% 50% / 100% 100% 0% 0%;

    &::before {
        content: "";

        position: absolute;
        bottom: 0;
        left: 50%;
        z-index: 2;

        display: block;
        width: rem(70);
        height: rem(35);
        margin-left: rem(-35);

        background: #fff;

        border-radius: 50% 50% 50% 50% / 100% 100% 0% 0%;
    }
}

.semi-circle--mask {
    position: absolute;
    top: 0;
    left: 0;

    width: rem(100);
    height: rem(100);

    background: transparent;

    transform: rotate(120deg) translate3d(0, 0, 0);
    transform-origin: center center;
    backface-visibility: hidden;

    &::before {
        content: "";
        border-bottom: 7px solid #fff;

        position: absolute;
        top: 0;
        left: 0;
        z-index: 2;

        display: block;
        width: rem(101);
        height: rem(51);
        margin: -1px 0 0 -1px;

        background: #dedede;

        border-radius: 50% 50% 50% 50% / 100% 100% 0% 0%;
    }
}

.value {
    position: absolute;
    left: 50%;
    bottom: 11px;
    z-index: 10;
    transform: translateX(-50%);
    text-align: center;
}
</style>

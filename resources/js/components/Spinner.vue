<template>
  <span class="loader" :style="{width: `${size}px`, height: `${size}px`, 'border-width': `${borderWidth}px`, 'border-color': color}"></span>
</template>

<script>
export default {
  name: "Spinner",

  props: {
    size: {
      type: Number,
      default: 50,
    },
    borderWidth: {
      type: Number,
      default: 7,
    },
    color: {
      type: String,
      default: '#DD2B47',
    },
  },
}
</script>

<style scoped>
.loader {
  border-style: solid;
  border-bottom-color: transparent !important;
  border-radius: 50%;
  display: inline-block;
  box-sizing: border-box;
  animation: rotation 1s linear infinite;
}

@keyframes rotation {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>

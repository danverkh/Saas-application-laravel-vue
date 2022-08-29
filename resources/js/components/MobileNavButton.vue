<template>
    <div>
        <input type="checkbox" id="togglenav-button" class="menu-trigger hidden"/>
        <label @click="toggle" class="burger-wrapper">
            <div class="hamburger"></div>
        </label>
    </div>
</template>

<script>
export default {
    name: "MobileNavButton",

    data() {
        return {
            opened: false,
        };
    },

    mounted() {
        document.getElementById('mobile-menu').addEventListener('change', elem => {
            this.opened = !elem.target.checked;
            this.toggle();
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024 && this.opened) {
                this.toggle();
            }
        });
    },

    methods: {
        toggle() {
            this.opened = !this.opened;

            document.getElementById('togglenav-button').checked = this.opened;
            document.getElementById('mobile-menu').checked      = this.opened;
        },
    },
}
</script>

<style scoped>
.burger-wrapper {
    cursor: pointer;
    margin: auto;
    width: 27px;
    height: 40px;
}

.burger-wrapper .hamburger {
    background: #111826;
    width: 27px;
    height: 4px;
    position: relative;
    transition: background 10ms 200ms ease;
    transform: translateY(20px);
    border-radius: 20px;
}

.burger-wrapper .hamburger:before, .burger-wrapper .hamburger:after {
    transition: top 200ms 250ms ease, transform 200ms 50ms ease;
    position: absolute;
    background: black;
    width: 27px;
    height: 4px;
    content: "";
    border-radius: 20px;
}

.burger-wrapper .hamburger:before {
    top: -9px;
}

.burger-wrapper .hamburger:after {
    top: 9px;
}

.menu-trigger:checked ~ .burger-wrapper .hamburger {
    background: transparent;
}

.menu-trigger:checked ~ .burger-wrapper .hamburger:after, .menu-trigger:checked ~ .burger-wrapper .hamburger:before {
    transition: top 200ms 50ms ease, transform 200ms 250ms ease;
    top: 0;
}

.menu-trigger:checked ~ .burger-wrapper .hamburger:before {
    transform: rotate(45deg);
}

.menu-trigger:checked ~ .burger-wrapper .hamburger:after {
    transform: rotate(-45deg);
}
</style>

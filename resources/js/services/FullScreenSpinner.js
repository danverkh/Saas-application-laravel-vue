class FullScreenSpinner {
    constructor() {
        this.element = null;
    }

    getElement() {
        if (this.element === null) {
            return this.element = document.getElementById('full-screen-spinner');
        }
        return this.element;
    }

    open() {
        this.getElement().classList.add('w-screen', 'h-screen', 'opacity-100');
        this.getElement().classList.remove('w-0', 'h-0', 'opacity-0');
    }

    close() {
        this.getElement().classList.remove('w-screen', 'h-screen', 'opacity-100');
        this.getElement().classList.add('w-0', 'h-0', 'opacity-0');
    }
}

export default new FullScreenSpinner;

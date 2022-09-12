class Modal {
    open(name) {
        document.getElementById(name).checked = true;
    }

    close(name) {
        document.getElementById(name).checked = false;
    }
}

export default new Modal;

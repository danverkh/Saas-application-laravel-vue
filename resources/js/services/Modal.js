class Modal {
    open(name) {
        document.getElementById(name).checked = true;
        document.getElementById(name).dispatchEvent(new Event('change'));
    }

    close(name) {
        document.getElementById(name).checked = false;
        document.getElementById(name).dispatchEvent(new Event('change'));
    }
}

export default new Modal;

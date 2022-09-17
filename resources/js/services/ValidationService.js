const scrollToError = () => {
    setTimeout(() => {
        const errors = document.querySelectorAll('.validation-error');

        if (errors.length > 0) {
            document.querySelector('.drawer-content')
                .scroll({top: (errors[0].offsetTop - 120), left: 0, behavior: 'smooth'});
        }
    }, 100);
};

export {scrollToError};

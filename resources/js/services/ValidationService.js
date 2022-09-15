const scrollToError = () => {
    setTimeout(() => {
        const errors = document.querySelectorAll('.validation-error');

        if (errors.length > 0) {
            console.log(errors[0].offsetTop);
            document.querySelector('.drawer-content')
                .scroll({top: (errors[0].offsetTop + 108), left: 0, behavior: 'smooth'});
        }
    }, 100);
};

export {scrollToError};

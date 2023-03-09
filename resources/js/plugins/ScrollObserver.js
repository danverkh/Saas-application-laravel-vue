export default function scrollObserver(selector, option) {
    let observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('shown')
                if (option && option.onShow) option.onShow(entry)
            }
            else if (!option?.once) {
                entry.target.classList.remove('shown')
                if (option && option.onHide) option.onHide(entry)
            }
        })
    }, option)

    if (Array.isArray(selector))
        selector.forEach(qAll)
    else
        qAll(selector)


    function qAll(selector) {
        const item = document.querySelectorAll(selector)
        item.forEach(i => observer.observe(i))
    }
}

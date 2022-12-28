import EventBus from "@/services/EventBus";

export default {
    data() {
        return {
            keywordInfoPopoverElement: null,
        };
    },

    mounted() {
        this.keywordInfoPopoverElement = document.getElementById('keyword-info-popover');
    },

    methods: {
        openKeywordInfoPopover(item) {
            EventBus.emit('keyword-info-popover:item', item)
            this.keywordInfoPopoverElement.classList.remove('hidden');
        },

        moveKeywordInfoPopover(event) {
            if ((event.pageY + this.keywordInfoPopoverElement.offsetHeight) > window.innerHeight) {
                this.keywordInfoPopoverElement.style.top = (window.innerHeight - this.keywordInfoPopoverElement.offsetHeight - 10) + 'px';
            } else {
                this.keywordInfoPopoverElement.style.top = event.pageY + 'px';
            }

            this.keywordInfoPopoverElement.style.left = (event.pageX + 15) + 'px';
        },

        hideKeywordInfoPopover() {
            this.keywordInfoPopoverElement.classList.add('hidden');
        },
    },
};

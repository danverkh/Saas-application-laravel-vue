export default {
    data() {
        return {
            keywordItemPopover: {},
        };
    },

    methods: {
        openKeywordInfoPopover(item) {
            this.keywordItemPopover = item;
            this.$refs.keywordInfoPopover.$el.classList.remove('hidden');
        },

        moveKeywordInfoPopover(event) {
            this.$refs.keywordInfoPopover.$el.style.top = event.pageY + 'px';
            this.$refs.keywordInfoPopover.$el.style.left = (event.pageX + 15) + 'px';
        },

        hideKeywordInfoPopover() {
            this.$refs.keywordInfoPopover.$el.classList.add('hidden');
        },
    },
};

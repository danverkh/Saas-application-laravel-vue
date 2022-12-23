export default {
    methods: {
        muteDomain(url) {
            try {
                const {origin, pathname} = new URL(url);

                return origin
                    ? `<span class="opacity-50">${origin}</span>${(pathname === '/' ? '' : pathname)}`
                    : url;
            } catch (error) {
                return url;
            }
        },

        withoutLastWord(string) {
            return string.substring(0, string.lastIndexOf(' '));
        },

        lastWord(string) {
            const words = string.split(' ');

            return words.length ? words.pop() : '';
        },
    },
};

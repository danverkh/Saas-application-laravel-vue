class Random {
    sentences(min, max) {
        min = min || this.between(1, 10);
        max = max || this.between(min, min + 10);

        return Array.from({length: this.between(min, max)})
            .map(() => this.sentence())
            .join(' ');
    }

    sentence() {
        const sentence = this.words(3, 16) + '.';

        return sentence[0].toUpperCase() + sentence.substring(1, sentence.length);
    }

    words(min, max) {
        return Array.from({length: this.between(min, max)})
            .map(() => this.word())
            .join(' ');
    }

    word(min, max) {
        min = min || this.between(1, 10);
        max = max || this.between(min, min + 10);

        return Math.random()
            .toString(36)
            .replace(/[^a-z]+/g, '')
            .substring(0, this.between(min, max));
    }

    between(min, max) {
        return Math.floor(Math.random() * (max - min)) + min;
    }

    item (array) {
        return array[this.between(0, array.length)];
    }
}

export default new Random;

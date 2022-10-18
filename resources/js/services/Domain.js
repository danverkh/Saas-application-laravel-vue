class Domain {
    getMarket(domain) {
        const lowercaseDomain = domain.toLowerCase();

        if (lowercaseDomain.includes('.at')) {
            return 'at';
        }

        if (lowercaseDomain.includes('.ch')) {
            return 'ch';
        }

        if (lowercaseDomain.includes('.de')) {
            return 'de';
        }

        if (lowercaseDomain.includes('.es')) {
            return 'es';
        }

        if (lowercaseDomain.includes('.fr')) {
            return 'fr';
        }

        if (lowercaseDomain.includes('.it')) {
            return 'it';
        }

        if (lowercaseDomain.includes('.uk')) {
            return 'uk';
        }
        return null;
    }
}

export default new Domain;

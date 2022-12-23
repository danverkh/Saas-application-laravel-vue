export default {
    methods: {
        fixedTableHeader() {
            const tableHeader = this.$refs.mainTable.querySelector('thead>tr');
            const tableHeaderTop = this.$refs.mainTable.getBoundingClientRect().top;
            const pageHeaderHeight = 137;
            const headerCells = tableHeader.querySelectorAll('th');
            const firstRowCells = this.$refs.mainTable.querySelectorAll('tbody>tr:first-child>*');

            if ((pageHeaderHeight + 55) > tableHeaderTop) {
                headerCells.forEach((el, index) => {
                    firstRowCells[index].style.width = el.offsetWidth + 'px';
                });

                tableHeader.classList.add('fixed');

                firstRowCells.forEach((el, index) => {
                    headerCells[index].style.width = el.offsetWidth + 'px';
                });
            } else {
                tableHeader.classList.remove('fixed');

                headerCells.forEach((el, index) => {
                    firstRowCells[index].style.width = 'auto';
                });
                firstRowCells.forEach((el, index) => {
                    headerCells[index].style.width = 'auto';
                });
            }
        },
    },
}

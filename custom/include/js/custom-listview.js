document.addEventListener('DOMContentLoaded', function () {
    let goToPageInput = document.getElementById('go_to_page');
    let goToPageBtn = document.getElementById('go-to-page-btn');

    // Override button behavior on keypress Enter, to trigger defined click event instead of the submit event to MassUpdate Form
    goToPageInput.addEventListener('keypress', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            goToPageBtn.click();
        }
    });
});


const handleGoToPage = () => {

    const page = document.getElementById('go_to_page').value;
    let moduleStringOffsetKey = document.getElementById('module_string').value;
    let totalRecords = document.getElementById('total_records').value;
    let recordsPerPage = document.getElementById('records_per_page').value;

    // check if page is a number
    if (isNaN(page)) {
        document.getElementById('go_to_page').value = '';
        return false;
    }

    let pageOffsetsData = pageOffsets(recordsPerPage, totalRecords);
    let offset = pageOffsetsData[page];
    if (offset === undefined) {
        offset = 0;
    }
    return sListView.save_checks(offset, moduleStringOffsetKey);
};
// create a function of fibonacci to generate the page offsets
const pageOffsets = (recordsPerPage, totalRecords) => {

    let numberOfPages = Math.ceil(totalRecords / recordsPerPage);
    const pageDataOffsets = {};
    for (let i = 1; i <= numberOfPages; i++) {
        // fibonacci sequence to calculate the offset
        pageDataOffsets[i] = recordsPerPage * (i - 1);
    }

    return pageDataOffsets;
}
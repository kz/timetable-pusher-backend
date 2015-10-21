var mainHot;

$(function () {
    /*
     * Use existing data if data has been passed back
     */
    var hotData = $('#hotData');
    createHot(JSON.parse(hotData.prop('value')));
});

function submitForm() {
    if ($("#name").prop('value').length < 1) {
        alert('You must specify a name for your timetable.');
        return false;
    }

    var hotData = JSON.stringify(mainHot.getData());
    $('#hotData').val(hotData);

    $('#create').submit();
}

function createHot(data) {
    /*
     * Update UI
     */
    var container = document.getElementById('handsontable-container');
    $('#handsontable-container').empty();

    /*
     * Create HOT
     */
    var hot = new Handsontable(container, {
        data: data,
        minSpareRows: 0,
        minSpareColumns: 0,
        rowHeaders: false,
        colHeaders: ["Period", "Start Time", "End Time", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
        contextMenu: false,
        colWidths: 100,
        maxCols: 10,
        maxRows: data.length * 2,
        stretchH: true,
        fillHandle: false
    });
    mainHot = hot;

    function notEditableRenderer(instance, td, row, col, prop, value, cellProperties) {
        td.style.background = '#EEE';
    }

    hot.updateSettings({
        cells: function (row, col, prop) {
            var cellProperties = {};
            // Make the second row of start and end times non-editable
            if (row % 2 === 1 && (col === 1 || col === 2)) {
                cellProperties.editor = false;
                cellProperties.renderer = notEditableRenderer;
            }
            // Make the 'period' column non-editable
            if (col === 0) {
                cellProperties.editor = false;
                cellProperties.renderer = notEditableRenderer;
            }
            // Add placeholders for names and locations
            if (row % 2 === 0 && col > 2) {
                cellProperties.placeholder = "Name";
            } else if (row % 2 === 1 && col > 2) {
                cellProperties.placeholder = "Location";
            }
            return cellProperties;
        }
    });
}
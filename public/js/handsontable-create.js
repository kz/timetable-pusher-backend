function generateTimetable() {
    /*
     * Get number of lessons, generate input
     */
    var lessons = parseInt(document.getElementById('lessons').value);
    if (typeof lessons !== 'number') {
        alert('You must specify a valid number.');
        return false;
    } else if (!(0 < lessons <= 10)) {
        alert('You can only specify up to 10 lessons per day.');
        return false;
    }

    /*
     * Create timetable based on lessons
     */
    var data = [];
    for (var i = 0; i < lessons; i++) {
        data.push([i + 1, "09:00", "13:00", "", "", "", "", "", "", ""]);
        data.push(["", "", "", "", "", "", "", "", "", ""]);
    }

    /*
     * Update UI
     */
    var container = document.getElementById('handsontable-container');
    $('#handsontable-container').empty();
    $('#lessons').prop('disabled', 'disabled');
    $('#generate-timetable-button')
        .addClass('disabled')
        .prop('disabled', 'disabled');
    $('#post-creation').show();

    /*
     * Create HOT
     */
    var hot = new Handsontable(container, {
        data: data,
        minSpareRows: 1,
        rowHeaders: false,
        colHeaders: ["Period", "Start Time", "End Time", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
        contextMenu: false,
        colWidths: 100,
        stretchH: true
    });

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

function submitForm() {

}
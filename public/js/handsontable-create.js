var mainHot;

$(function() {
    /*
     * Use old data if data has been passed back
     */
    var hotData = $('#hotData');
    if (typeof hotData.prop('value') !== 'undefined' && hotData.prop('value') != "") {
        createHot(JSON.parse(hotData.prop('value')));
    }
});

function generateTimetable() {
    /*
     * Get number of lessons, generate input
     */
    var lessons = parseInt(document.getElementById('lessons').value);
    if (typeof lessons !== 'number' || isNaN(lessons)) {
        alert('You must specify a valid number.');
        return false;
    } else if (lessons < 1 || lessons > 10) {
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

    createHot(data);
}

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
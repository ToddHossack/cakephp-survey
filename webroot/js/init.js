(function ($) {
    console.log('inited');
    var format = 'YYYY-MM-DD HH:mm:ss';
    $('[data-provide="datetimepicker"]').each(function () {
        var options = {
            singleDatePicker: true,
            showDropdowns: true,
            timePicker: true,
            drops: 'down',
            timePicker24Hour: true,
            timePickerIncrement: 5,
            locale: {
                cancelLabel: 'Clear',
                format: format,
                firstDay: 1
            }
        };

        var defaultValue = $(this).data('default-value');
        if (!this.value && undefined !== defaultValue) {
            options.startDate = moment().format(defaultValue);
        } else {
            options.autoUpdateInput = false;
        }

        // date range picker (used for datetime fields)
        $(this).daterangepicker(options);

        $(this).on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format(format));
        });

        $(this).on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });
    });

})(jQuery);

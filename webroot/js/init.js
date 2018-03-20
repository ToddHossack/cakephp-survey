(function ($) {
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

    $('.survey-question-results').each(function () {
        var that = this;

        $.ajax({
            dataType: 'json',
            method: 'POST',
            url: '/api/v1.0/surveys/view-results/',
            data: {
                survey_question_id: $(this).data('id'),
                survey_id: $(this).data('survey-id')
            },
            headers: {
                Authorization: 'Bearer ' + apiToken
            }
        }).then(function (response) {

            if (!response.success) {
                return;
            }

            if (['input', 'textarea'].includes(response.data.question.type)) {
                return;
            }

            var graphContainerId = $(that).find('div.graphs-container').attr('id');
            var graphData = [];

            for (var answerId in response.data.answers) {
                var element = response.data.answers[answerId];
                var listElement = $(that).find('li[data-answer-id="' + answerId + '"]');
                $(listElement).find('.answer-stats').text(element.results);
                graphData.push({
                    label: element.entity.answer,
                    value: parseInt(element.results)
                });
            }

            if (window.Morris !== undefined) {
                Morris.Donut({
                    'element': graphContainerId,
                    'data': graphData,
                    'resize': true
                });
            }
        });
    });
})(jQuery);

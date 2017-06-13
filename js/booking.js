$(document).ready(function () {

    $('#date-popup').datepicker({
        clearBtn: true,
        language: 'ptBR',
        autoclose: true,
        keyboardNavigation: false,
        forceParse: false,
        todayHighlight: true
    });

    $(".select2").select2();
    $(".select2-placeholer").select2({
        allowClear: true
    });
});

function requestAvailableProjectors() {
    //Reset options
    var select = $('#projector').find('option');
    for (var i = 1; i < select.length; i++) {
        if (!select[i].hasAttribute('class')) {
            select[i].setAttribute('class', 'hide-element')
        }
    }

    var date = $('#_date').val();
    var startsAt = $('#_startsAt').val();
    var endsAt = $('#_endsAt').val();

    if (date.length && startsAt.length && endsAt.length) {
        $('#results').addClass('hide-element');
        $('#no-results').addClass('hide-element');
        $('#searching').removeClass('hide-element');
        $.post(
            '/includes/projectorBookingsRequest.php?do=request',
            {
                date: date,
                startsAt: startsAt,
                endsAt: endsAt
            },
            function (data) {
                if (data.total > 0) {
                    //Define form values
                    $('#startsAt').val($('#_startsAt').val());
                    $('#endsAt').val($('#_endsAt').val());
                    $('#date').val($('#_date').val());

                    //Unhiding content
                    $('#results').removeClass('hide-element');
                    $('#results').show(400);
                    $('span.select2.select2-container.select2-container--default.select2-container--below').attr('style', 'width: 100%');
                    $('#searching').addClass('hide-element');

                    for (var i = 0; i < data.total; i++) {
                        $('#opt_' + data.results[i].id).removeAttr('class');
                    }
                } else {
                    $('#searching').addClass('hide-element');
                    $('#no-results').removeClass('hide-element');
                    $('#no-results').show(400);
                }
            }
        );
    }
}

function dismissProjectorsAlert() {
    $('#no-results').addClass('hide-element');
}
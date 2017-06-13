function liveSearchRequest(after) {
    after = after == undefined ? 0 : after;
    console.log(after);
    if (after == 0) {
        $("#liveresults").empty();
    }

    $("#livesearch").find("input").addClass('searching');
    $.post(
        'ajaxsearch.php',
        {
            'query': $("#livesearch").find("input").val(),
            'after': after
        },
        function (data) {
            $("#livesearch").find("input").removeClass('searching');
            if (data.total > 0) {
                if (after == 0) $("#liveresults").empty();
                for (var i = 0; i < data.results.length; i++) {
                    $('projector').find('option')
                    result = $("#livesearch-result").clone().appendTo('#liveresults').removeClass('hidden-ls');
                    upload = data.results[i];
                    //Decode entities
                    upload.title = decodeEntities(upload.title);
                    upload.uploader = decodeEntities(upload.opentag + upload.uploader + upload.closetag);
                    upload.forumtitle = decodeEntities(upload.forumtitle);
                    upload.servidores = decodeEntities(upload.servidores);
                    //Insert link to uploader's profile into its name
                    upload.uploader = '<a href=\'' + BBURL + '/member.php?u=' + upload.userid + '\'>' + upload.uploader + '</a>';
                    img = $(".poster img", result);
                    img.attr('src', img.attr('src') + upload.poster);
                    $(".info a.title", result).attr('href', BBURL + "/showthread.php?t=" + upload.id).text(upload.title);
                    $(".info span.uploader", result).html(upload.uploader);
                    $(".extrainfo span.title", result).text(upload.servidores);
                    $(".extrainfo a.title", result).attr('href', BBURL + "/forumdisplay.php?f=" + upload.forumid).text(upload.forumtitle);
                }
            } else if (after == 0) {
                $("#liveresults").empty();
            }
        }, 'json'
    );
}

function requestAvailableProjectors() {
    var date = $('#_date').val();
    var startsAt = $('#_startsAt').val();
    var endsAt = $('#_endsAt').val();

    if (date.length && startsAt.length && endsAt.length) {
        $('#results').addClass('hide-element');
        $('#no-results').addClass('hide-element');
        $('#searching').removeClass('hide-element');
        $.post(
            '/includes/projectorBookingsRequest.php',
            {
                date: date,
                startsAt: startsAt,
                endsAt: endsAt
            },
            function (data) {
                if (data.total > 0) {
                    $('#results').removeClass('hide-element');
                    $('#searching').addClass('hide-element');
                } else {
                    $('#searching').addClass('hide-element');
                    $('#results').addClass('hide-element');
                    $('#no-results').removeClass('hide-element');
                }
            }
        );
    }
}
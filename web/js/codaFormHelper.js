$(document).ready(function() {

    $("#coda-form").on("afterValidate", function (event, messages) {

        $("#progressBarWrap").css('visibility', 'visible');
        var percent = 100;
        $("#progressBar").attr('aria-valuenow', percent).css('width', percent + '%').text(percent + '%');

    });
    
});



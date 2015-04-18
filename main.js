$(function() {
    $('#reasonForm').submit(function(e) {
        e.preventDefault();
        $.post('/add-reason.json', $(this).serialize(), function(data) {
            $('#reasonForm').slideUp();
            if (data.success) {
                $('#ar-success-msg').slideDown();
                $('#reasonForm').reset();
            } else {
                $('#ar-error-msg').slideDown();
            }
        }, 'JSON');
    });

    $('#feedbackForm').submit(function(e) {
        e.preventDefault();
        $.post('/send-feedback.json', $(this).serialize(), function(data) {
            $('#feedbackForm .elems').slideUp();
            if (data.success) {
                $('#sf-success-msg').slideDown();
                $('#feedbackForm').reset();
            } else {
                $('#sf-error-msg').slideDown();
            }
        }, 'JSON');
    });

    $('#feedbackLink').click(function(e) {
        e.preventDefault();
        $('#feedbackForm .elems, .overlay, #feedbackForm').show();
    });

    $('#feedbackForm .title .close').click(function(e) {
        e.preventDefault();
        $('.overlay, #feedbackForm, .sf-msg').hide();
    });
})

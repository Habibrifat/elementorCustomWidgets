; (function ($) {
    $(document).ready(function () {
        let formdata = {};
        $(".contact_button").off('click');
        $(".contact_button").on('click', function () {
            $(this).parent().find('.form-control').each(function () {
                let placeholder = $(this).attr('placeholder');
                let value = $(this).val();
                formdata[placeholder] = value;
                $(this).val('');
            });
            //console.log(formdata);
            let nonce = $("#venus_nonce").val();
            $.post(venus.ajax_url, { action: 'venus_contact', nonce: nonce, 'formdata': formdata }, function (data) {
                alert("Form Submitted");

            });
            return false;
        });
    });
})(jQuery);
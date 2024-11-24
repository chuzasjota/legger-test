(function( $ ) {
	'use strict';

	$('#form-registro').submit( function(e) {
		e.preventDefault();

        const form = document.getElementById('form-registro');
        const successMessage = document.getElementById('success-message');
        
        let formData = $('#form-registro').serializeArray();
        let dataObject = {
            action: 'dcms_ajax_frm_contact',
            nonce: dcms_form.frmNonce
        };
        
        formData.forEach(item => {
            dataObject[item.name] = item.value;
        });

		$.ajax({
			url : dcms_form.ajaxUrl,
			type: 'post',
			dataType: 'json',
            data: dataObject,
			beforeSend: function(){
				$('#submit').prop('disabled', true);
			}
        })
        .done( function(res) {
            if(res.status === 1){
                form.style.display = 'none';
                successMessage.style.display = 'block';
                setTimeout(() => {
                    form.reset();
                    form.style.display = 'block';
                    successMessage.style.display = 'none';
                }, 5000);
            }
        })
	});
})( jQuery );
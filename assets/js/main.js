// require jQuery normally
const $ = require('jquery');

// create global $ and jQuery variables
global.$ = global.jQuery = $;

$ (function () {
	$('body').on('click', '#contact_submit', function (ev) {
		ev.preventDefault();

		var form = $(this).closest('form');

		if (form[0].checkValidity()) {
			form.find('button').hide();
			form.find('.loader').show();
			$.ajax({
				url: form.attr('action'),
				data: form.serialize(),
				type: 'POST',
				success: function (html) {
					$('#form_container').html(html);
				},
				error: function () {
					alert('Ooops something went wrong...');
					form.find('button').show();
					form.find('.loader').hide();
				}
			});
		} else {
			form[0].reportValidity();
		}

		return false;
	});
});


(function () {
	document.querySelector('body').addEventListener('click', function(ev) {
		if (ev.target.id === 'contact_submit_js') {
			ev.preventDefault();

			let form = ev.target.parentElement;

			if (form.checkValidity()) {
				document.getElementById('contact_submit_js').style.display = 'none';
				document.getElementById('contact_submit').style.display = 'none';
				document.getElementById('loader').style.display = 'block';

				let xhr = new XMLHttpRequest();
				let data = new FormData(form);

				xhr.onreadystatechange = function() {
					if (this.readyState == 4) {
						if (this.status == 200) {
							let cont = document.getElementById('form_container');
							cont.innerHTML = this.responseText;
						} else {
							document.getElementById('contact_submit_js').style.display = 'block';
							document.getElementById('contact_submit').style.display = 'block';
							document.getElementById('loader').style.display = 'none';
						}
					}
				};
				xhr.open('POST', form.action, true);
				xhr.send(data);
			} else {
				form.reportValidity();
			}
		}
	});
})();
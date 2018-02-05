// require jQuery normally
const $ = require('jquery');

// create global $ and jQuery variables
global.$ = global.jQuery = $;

$ (function () {
	$('body').on('click', '#contact_submit', function (ev) {
		ev.preventDefault();

		var form = $(this).closest('form');

		if (form[0].checkValidity()) {
			$.ajax({
				url: form.attr('action'),
				data: form.serialize(),
				type: 'POST',
				success: function (html) {
					$('#form_container').html(html);
				},
				error: function () {
					alert('Ooops something went wrong...');
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
			let xhr = new XMLHttpRequest();
			let data = new FormData(form);
			
			xhr.onreadystatechange = function() {
				console.log(this.readyState);
				if (this.readyState == 4 && this.status == 200) {
					let cont = document.getElementById('form_container');
					cont.innerHTML = this.responseText;
				}
			};
			xhr.open('POST', form.action, true);
			xhr.send(data);
		} else {
			form.reportValidity();
		}

//		return false;
		}
	});
})();
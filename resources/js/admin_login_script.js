var admin_login = {

	error_messages: {
		error_problem: 'Настана грешка. Обидете се повторно.',
		error_fields: 'Сите полиња се задолжителни.',
		invalid_credentials: 'Погрешно корисничко име или лозинка.',
	},

	globals: {
		
	},

	init: function() {
		this.events()
	},

	events: function() {
		$('#submit').on('click', this.submitCredentials);
	},

	hideStatusErrorMsgs: function() {
		$('.status_error_messages').text('').hide();
		$('.status_error_messages').removeClass('alert-success');
		$('.status_error_messages').removeClass('alert-error');
	},

	submitCredentials: function() {
		var data = admin_login.getLoginData();
			valid = admin_login.validation(data);

		$('.error_message').hide();

		if(valid) {
			admin_login.hideStatusErrorMsgs();

			$.when($.ajax({
				url: BASE_URL + 'admin_login/verifyUser',
				type: 'post',
				dataType: 'json',
				data: data,
			}))
			.then(function(result) {
				if(result === 1) {
					window.location.replace(BASE_URL + 'admin_dashboard');
				} else if(0) {
					$('#error_message').text(admin_login.error_messages.error_fields).addClass('alert-error').show();
				} else if(2) {
					$('#error_message').text(admin_login.error_messages.invalid_credentials).addClass('alert-error').show();
				}
			})
			.fail(function(result) {
				$('#error_message').text(admin_login.error_messages.error_problem).addClass('alert-error').show();
			});
		}
	},

	getLoginData: function() {
		data = {};

		data.username = $('#username').val();
		data.password = $('#password').val();

		return data;
	},

	validation: function(data) {
		admin_login.hideStatusErrorMsgs();

		if(data.username === '' || data.password === '') {
			$('#error_message').text(admin_login.error_messages.error_fields).addClass('alert-error').show();
			return false;
		} else {
			return true;
		}
	},
};

$(function() {
	admin_login.init();
})
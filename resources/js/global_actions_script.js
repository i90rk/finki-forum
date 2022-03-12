var global_actions = {

	error_messages: {
		// error_firstname: 'Firstname is required.',
		error_firstname: 'Внесете име.',
		// error_lastname: 'Lastname is required.',
		error_lastname: 'Внесете презиме.',
		// error_username: 'Username is required.',
		error_username: 'Внесете корисничко име.',
		// error_password: 'Password is required.',
		error_password: 'Внесете лозинка.',
		// error_password_confirm: 'Confirm password is required.',
		error_password_confirm: 'Внесете потврда на лозинката.',
		// error_password_mismatch_confirm: 'Confirm password does not match with password.',
		error_password_mismatch_confirm: 'Потврдата за лозинката не се совпаѓа со лозинката.',
		// error_email: 'Email is required.',
		error_email: 'Внесете email адреса.',
		// error_invalid_email: 'Valid email address required.',
		error_invalid_email: 'Внесете валидна email адреса.',
		// error_problem: 'Problem occured. Please try again.',
		error_problem: 'Настана грешка. Обидете се повторно.',
		// success_registration: 'Registration was successful.',
		success_registration: 'Успешна регистрација.',
		// error_username_exists: 'Username already exists.',
		error_username_exists: 'Корисничкото име веќе постои.',
		// error_email_exists: 'Email address already exists.',
		error_email_exists: 'Email адресата веќе постои.',
		// error_wrong_credentials: 'Wrong username or password.',
		error_wrong_credentials: 'Погрешно корисничко име или лозинка.',
	},

	globals: {
		
	},

	init: function() {
		global_actions.events();
	},

	events: function() {
		$('#loginModalBtn').on('click', function() {
			$('#loginModal').modal();
		});
		
		$('#registerModalBtn').on('click', function() {
			$('#registerModal').modal();
		});
		
		$('#login_btn').on('click', this.loginUser);
		$('#register_btn').on('click', this.registerUser);

		$('.close_modal').on('click', function() {
			global_actions.hideStatusErrorMsgs();
			global_actions.resetRegisterUserForm();
			global_actions.resetLoginUserForm();
		});
	},

	registerUser: function() {
		var data = global_actions.getRegisterUserData();
		var valid = global_actions.validateRegisterUserData(data);

		if(valid) {
			$.when($.ajax({
				url: BASE_URL + 'global_actions/registerUser',
				type: 'post',
				data: data,
				dataType: 'json',
			}))
			.then(function(result) {
				if(result === 1) {
					// ok
					global_actions.hideStatusErrorMsgs();
					$('#register_user_error').text(global_actions.error_messages.success_registration).addClass('alert-success').show();
					global_actions.resetRegisterUserForm();
				} else if(result === 0) {
					// error
					global_actions.hideStatusErrorMsgs();
					$('#register_user_error').text(global_actions.error_messages.error_problem).addClass('alert-error').show();
				} else if(result === 2) {
					// username exist
					global_actions.hideStatusErrorMsgs();
					$('#register_user_error').text(global_actions.error_messages.error_username_exists).addClass('alert-error').show();
				} else if(result === 3) {
					// email exist
					global_actions.hideStatusErrorMsgs();
					$('#register_user_error').text(global_actions.error_messages.error_email_exists).addClass('alert-error').show();
				}
			})
			.fail(function() {
				global_actions.hideStatusErrorMsgs();
				$('#register_user_error').text(global_actions.error_messages.error_problem).addClass('alert-error').show();
			});
		}
	},

	hideStatusErrorMsgs: function() {
		$('.status_error_messages').text('').hide();
		$('.status_error_messages').removeClass('alert-success');
		$('.status_error_messages').removeClass('alert-error');
	},

	resetRegisterUserForm: function() {
		$('#add_firstname').val('');
		$('#add_lastname').val('');
		$('#add_username').val('');
		$('#add_password').val('');
		$('#add_password_confirm').val('');
		$('#add_email').val('');
	},

	getRegisterUserData: function() {
		var data = {};

		data.firstname = $('#add_firstname').val();
		data.lastname = $('#add_lastname').val();
		data.username = $('#add_username').val();
		data.password = $('#add_password').val();
		data.confirm_password = $('#add_password_confirm').val();
		data.email = $('#add_email').val();
		
		return data;
	},

	validateRegisterUserData: function(data) {
		global_actions.hideStatusErrorMsgs();

		if(data.firstname === '') {
			$('#register_user_error').text(global_actions.error_messages.error_firstname).addClass('alert-error').show();
			return false;
		} else if(data.lastname === '') {
			$('#register_user_error').text(global_actions.error_messages.error_lastname).addClass('alert-error').show();
			return false;
		} else if(data.username === '') {
			$('#register_user_error').text(global_actions.error_messages.error_username).addClass('alert-error').show();
			return false;
		} else if(data.password === '') {
			$('#register_user_error').text(global_actions.error_messages.error_password).addClass('alert-error').show();
			return false;
		} else if(data.confirm_password === '') {
			$('#register_user_error').text(global_actions.error_messages.error_password_confirm).addClass('alert-error').show();
			return false;
		} else if(data.confirm_password !== data.password) {
			$('#register_user_error').text(global_actions.error_messages.error_password_mismatch_confirm).addClass('alert-error').show();
			return false;
		} else if(data.email === '') {
			$('#register_user_error').text(global_actions.error_messages.error_email).addClass('alert-error').show();
			return false;
		} else if(!global_actions.isValidEmailAddress(data.email)) {
			$('#register_user_error').text(global_actions.error_messages.error_invalid_email).addClass('alert-error').show();
			return false;
		}

		return true;
	},

	isValidEmailAddress: function(emailAddress) {
	    var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);

	    return pattern.test(emailAddress);
	},

	loginUser: function() {
		var data = global_actions.getLoginUserData();
		var valid = global_actions.validateLoginUserData(data);

		if(valid) {
			$.when($.ajax({
				url: BASE_URL + 'global_actions/verifyUser',
				type: 'post',
				data: data,
				dataType: 'json'
			}))
			.then(function(result) {
				if(result === 1) {
					// ok
					// $('#close_login_modal').click();
					document.location.reload(true);
				} else if(result === 0) {
					// error
					global_actions.hideStatusErrorMsgs();
					global_actions.resetLoginUserForm();
					$('#login_user_error').text(global_actions.error_messages.error_problem).addClass('alert-error').show();
				} else if(result === 2) {
					// username exist
					global_actions.hideStatusErrorMsgs();
					global_actions.resetLoginUserForm();
					$('#login_user_error').text(global_actions.error_messages.error_wrong_credentials).addClass('alert-error').show();
				} else {
					window.location.replace(BASE_URL + 'banned_user/bannedUser/' + result);
				}
			})
			.fail(function() {
				global_actions.hideStatusErrorMsgs();
				global_actions.resetLoginUserForm();
				$('#login_user_error').text(global_actions.error_messages.error_problem).addClass('alert-error').show();
			});
		}
	},

	resetLoginUserForm: function() {
		$('#inputUsername').val('');
		$('#inputPassword').val('');
		$('#remember_checkbox').prop('checked', false);
	},

	getLoginUserData: function() {
		data = {};

		data.username = $('#inputUsername').val();
		data.password = $('#inputPassword').val();

		return data;
	},

	validateLoginUserData: function() {
		global_actions.hideStatusErrorMsgs();

		if(data.username === '') {
			$('#login_user_error').text(global_actions.error_messages.error_username).addClass('alert-error').show();
			return false;
		} else if(data.password === '') {
			$('#login_user_error').text(global_actions.error_messages.error_password).addClass('alert-error').show();
			return false;
		}

		return true;
	},
};

$(function() {
	global_actions.init();
});
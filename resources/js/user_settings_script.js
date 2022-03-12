var user_settings = {

	error_messages: {
		error_problem: 'Настана грешка. Обидете се повторно.',
		error_firstname: 'Ова поле е задолжително.',
		error_lastname: 'Ова поле е задолжително.',
		error_birthday: 'Сите полиња се задолжителни.',
		error_date_mismatch: 'Невалиден датум.',
		success_basic_settings: 'Основните прилагодувања се променети.',
		success_avatar: 'Аватарот е успешно променет.',
		error_avatar: 'Само слики се дозволени.',
		error_avatar_empty: 'Одберете датотека.',
		error_old_password: 'Ова поле е задолжително.',
		error_new_password: 'Ова поле е задолжително.',
		error_password_confirm: 'Ова поле е задолжително.',
		error_password_mismatch: 'Внесените лозинки не се совпаѓаат.',
		error_wrong_old_password: 'Грешна стара лозинка.',
		change_password_success: 'Лозинката е успешно променета.',
	},

	globals: {
		user_id: undefined,
	},

	init: function() {
		$('#add_birth_month').select2({
			width: '170px',
			placeholder: 'Mесец',
            allowClear: true
		});

		this.getUserId();
		this.events();
	},

	events: function() {
		$('#collapseBasicSettings').on('hidden', function() {
			user_settings.hideStatusErrorMsgs();
			user_settings.resetBasicSettingsForm();
		});

		$('#collapseAvatar').on('hidden', function() {
			user_settings.hideStatusErrorMsgs();
			user_settings.resetAvatarForm();
		});

		$('#collapsePassword').on('hidden', function() {
			user_settings.hideStatusErrorMsgs();
			user_settings.resetPasswordForm();
		});

		$('#upload_image_btn').on('click', function() {
			$('#upload_image_sim').click();
		});

		$('#upload_image_sim').on('change', function() {
			var file_name = $('#upload_image_sim')[0].files[0]['name'];
			$('#upload_image_name').text(file_name);
		});

		$('#submit_basic_settings').on('click', this.changeBasicSettings);
		$('#change_avatar_btn').on('click', this.changeAvatar);
		$('#change_password_btn').on('click', this.changePassword);
	},

	getUserId: function() {
		var pathname = window.location.pathname.split('/');

		user_settings.globals.user_id = pathname[3];
	},

	hideStatusErrorMsgs: function() {
		$('.status_error_messages').hide();
		$('.status_error_messages').removeClass('alert-success');
		$('.status_error_messages').removeClass('alert-error');
	},

	resetBasicSettingsForm: function() {
		/*$('#add_firstname').val('');
		$('#add_lastname').val('');

		$('#add_birth_month').select2('val', '');
		$('#add_birth_day').val('');
		$('#add_birth_year').val('');*/
	},

	resetAvatarForm: function() {
		$('#upload_image_sim').val('');
		$('#upload_image_name').text('');
	},

	resetPasswordForm: function() {
		$('#old_password').val('');
		$('#new_password').val('');
		$('#password_confirm').val('');
	},

	changeBasicSettings: function() {
		var data = user_settings.getBasicSettingsData();
		var valid = user_settings.validateBasicSettingsData(data);

		if (valid) {
			user_settings.hideStatusErrorMsgs();

			$.when($.ajax({ 
				url: BASE_URL + 'user_settings/changeBasicSettings',
				data: data,
				dataType: 'json',
				type: 'post'
			}))
			.then(function(result) {
				if(result) {
					$('#submit_basic_settings_message').text(user_settings.error_messages.success_basic_settings).addClass('alert-success').show();
					// user_settings.resetBasicSettingsForm();
					user_settings.updateUserBasicSettings(data);
				} else {
					$('#submit_basic_settings_message').text(user_settings.error_messages.error_problem).addClass('alert-error').show();
					// user_settings.resetBasicSettingsForm();
				}
			})
			.fail(function() {
				$('#submit_basic_settings_message').text(user_settings.error_messages.error_problem).addClass('alert-error').show();
					// user_settings.resetBasicSettingsForm();
			});
		}
	},

	getBasicSettingsData: function() {
		var data = {};

		data.firstname = $('#add_firstname').val();
		data.lastname = $('#add_lastname').val();

		data.birth_month = $('#add_birth_month').val();
		data.birth_day = $('#add_birth_day').val();
		data.birth_year = $('#add_birth_year').val();

		return data;
	},

	validateBasicSettingsData: function(data) {
		var validate_birthday;

		user_settings.hideStatusErrorMsgs();

		if(data.firstname === '') {
			$('#add_firstname_error').text(user_settings.error_messages.error_firstname).addClass('alert-error').show();
			return false;

		} else if(data.lastname === '') {
			$('#add_lastname_error').text(user_settings.error_messages.error_lastname).addClass('alert-error').show();
			return false;

		} else if(data.birth_month !== '') {
			if(data.birth_day === '' || data.birth_year === '') {
				$('#add_birthday_error').text(user_settings.error_messages.error_birthday).addClass('alert-error').show();
				return false;

			} else {
				validate_birthday = user_settings.validateBirthday(data.birth_month, data.birth_day, data.birth_year);
				if(validate_birthday === false) {
					$('#add_birthday_error').text(user_settings.error_messages.error_date_mismatch).addClass('alert-error').show();
					return false;

				}
			}
		} else if(data.birth_month === '' && (data.birth_day !== '' || data.birth_year !== '')) {
			$('#add_birthday_error').text(user_settings.error_messages.error_birthday).addClass('alert-error').show();
			return false;

		}

		return true;
	},

	validateBirthday: function(birth_month, birth_day, birth_year) {
		var month = user_settings.getMonthNumber(birth_month);
		var	day = parseInt(birth_day, 10);
		var	year = parseInt(birth_year, 10);
		var	date = new Date(year, month, day);

		return (((date.getFullYear() === year) && (year >= 1950 && year <= 2050)) && (date.getMonth() === month) && (date.getDate() === day));
	},

	getMonthNumber: function(birth_month) {
		var month_number;

		switch(birth_month) {
			case 'Јануари':
				month_number = 0;
				break;
			case 'Февруари':
				month_number = 1;
				break;
			case 'Март':
				month_number = 2;
				break;
			case 'Април':
				month_number = 3;
				break;
			case 'Мај':
				month_number = 4;
				break;
			case 'Јуни':
				month_number = 5;
				break;
			case 'Јули':
				month_number = 6;
				break;
			case 'Август':
				month_number = 7;
				break;
			case 'Септември':
				month_number = 8;
				break;
			case 'Октомври':
				month_number = 9;
				break;
			case 'Ноември':
				month_number = 10;
				break;
			case 'Декември':
				month_number = 11;
				break;	
		}

		return month_number;
	},

	updateUserBasicSettings: function(data) {
		$('#fullname').text(data.firstname + ' ' + data.lastname);
		$('#birthday').text(data.birth_day + ' ' + data.birth_month + ' ' + data.birth_year);
	},

	changeAvatar: function() {
		var data = user_settings.getAvatar();
		var valid = user_settings.validateAvatar(data);
		var formdata = user_settings.packAvatarData(data);

		if(valid) {
			$.when($.ajax({
				url: BASE_URL + 'user_settings/changeAvatar',
				type: 'post',
				data: formdata,
				dataType: 'json',
				processData: false,
                contentType: false,
			}))
			.then(function(result) {
				if(result) {
					$('#change_avatar_message').text(user_settings.error_messages.success_avatar).addClass('alert-success').show();
					user_settings.resetAvatarForm();
					user_settings.updateUserAvatarImage(result);
				} else {
					$('#change_avatar_message').text(user_settings.error_messages.error_problem).addClass('alert-error').show();
					user_settings.resetAvatarForm();
				}
			})
			.fail(function() {
				$('#change_avatar_message').text(user_settings.error_messages.error_problem).addClass('alert-error').show();
				user_settings.resetAvatarForm();
			});
		}
	},

	getAvatar: function() {
		var data = {};

		data.avatar = $('#upload_image_sim')[0].files[0];

		return data;
	},

	validateAvatar: function(data) {
		user_settings.hideStatusErrorMsgs();

		if(data.avatar) {
			if(!(data.avatar['type'] == 'image/jpg' || data.avatar['type'] == 'image/jpeg' || data.avatar['type'] == 'image/png')) {
				$('#add_avatar_error').text(user_settings.error_messages.error_avatar).addClass('alert-error').show();
				return false;
			} else {
				return true;
			}
		} else {
			$('#add_avatar_error').text(user_settings.error_messages.error_avatar_empty).addClass('alert-error').show();
			return false;
		}
	},

	packAvatarData: function(data) {
		var formdata = new FormData();

		$.each(data, function(key, value) {
			formdata.append(key, value);
		});

		return formdata;
	},

	updateUserAvatarImage: function(img_path) {
		var src = BASE_URL + img_path;
		$('#user_avatar').attr('src', src);
	},

	changePassword: function() {
		var data = user_settings.getPasswordData();
		var valid = user_settings.validatePasswordData(data);

		if(valid) {
			$.when($.ajax({ 
				url: BASE_URL + 'user_settings/changePassword',
				data: data,
				dataType: 'json',
				type: 'post'
			}))
			.then(function(result) {
				if(result === 1) {
					$('#change_password_message').text(user_settings.error_messages.change_password_success).addClass('alert-success').show();
					user_settings.resetPasswordForm();
				} else if(result === 2) {
					$('#change_password_message').text(user_settings.error_messages.error_wrong_old_password).addClass('alert-error').show();
					user_settings.resetPasswordForm();
				} else if(result === 0) {
					$('#change_password_message').text(user_settings.error_messages.error_problem).addClass('alert-error').show();
					user_settings.resetPasswordForm();
				}
			})
			.fail(function() {
				$('#change_password_message').text(user_settings.error_messages.error_problem).addClass('alert-error').show();
					user_settings.resetPasswordForm();
			});
		}
	},

	getPasswordData: function() {
		var data = {};

		data.old_password = $('#old_password').val();
		data.new_password = $('#new_password').val();
		data.password_confirm = $('#password_confirm').val();

		return data;
	},

	validatePasswordData: function(data) {
		user_settings.hideStatusErrorMsgs();

		if(data.old_password === '') {
			$('#old_password_error').text(user_settings.error_messages.error_old_password).addClass('alert-error').show();
			return false;
		} else if(data.new_password === '') {
			$('#new_password_error').text(user_settings.error_messages.error_new_password).addClass('alert-error').show();
			return false;
		} else if(data.password_confirm === '') {
			$('#password_confirm_error').text(user_settings.error_messages.error_password_confirm).addClass('alert-error').show();
			return false;
		} else if(data.new_password !== data.password_confirm) {
			$('#password_confirm_error').text(user_settings.error_messages.error_password_mismatch).addClass('alert-error').show();
			return false;
		}

		return true;
	},

};

$(function() {
	user_settings.init();
});
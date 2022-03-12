var admin_users = {

	error_messages: {
		// error_firstname: 'This field is required.',
		error_firstname: 'Ова поле е задолжително.',
		// error_lastname: 'This field is required.',
		error_lastname: 'Ова поле е задолжително.',
		// error_username: 'This field is required.',
		error_username: 'Ова поле е задолжително.',
		// error_password: 'This field is required.',
		error_password: 'Ова поле е задолжително.',
		// error_password_confirm: 'This field is required.',
		error_password_confirm: 'Ова поле е задолжително.',
		// error_password_mismatch_confirm: 'Confirm password does not match with password.',
		error_password_mismatch_confirm: 'Потврдата за лозинката не се совпаѓа со лозинката.',
		// error_email: 'This field is required.',
		error_email: 'Ова поле е задолжително.',
		// error_invalid_email: 'Valid email address required.',
		error_invalid_email: 'Потребна е валидна email адреса.',
		// error_birthday: 'All fields are required.',
		error_birthday: 'Сите полиња се задолжителни.',
		// error_date_mismatch: 'Invalid date.',
		error_date_mismatch: 'Невалиден датум.',
		// error_avatar: 'Only images are allowed.',
		error_avatar: 'Дозволени се само слики.',
		// error_problem: 'Problem occured. Please try again.',
		error_problem: 'Настана грешка. Обидете се повторно.',
		// success_new_user: 'New user added successfully.',
		success_new_user: 'Новиот член е успешно додаден.',
		// error_username_exists: 'Username already exists.',
		error_username_exists: 'Корисничкото име веќе постои.',
		// error_email_exists: 'Email address already exists.',
		error_email_exists: 'Email адресата веќе постои.',
		// success_edit_user: 'User edited successfully.',
		success_edit_user: 'Членот е успешно променет.',
		// delete_user_confirm: 'Are you sure you want to delete this user?',
		delete_user_confirm: 'Дали сте сигурни дека сакате да го избришете членот?',
		// success_delete_user: 'User deleted successfully.',
		success_delete_user: 'Членот е успешно избришан.',
		// error_select_user: 'Please select a user.',
		error_select_user: 'Селектирајте член.',
		// error_ban_period: 'Please select ban period.',
		error_ban_period: 'Селектирајте временски период.',
		// error_ban_reason: 'This field is required.',
		error_ban_reason: 'Ова поле е задолжително.',
		// success_ban_user: 'User banned successfully.',
		success_ban_user: 'Членот е баниран успешно.',
		// lift_ban_confirm: 'Are you sure you want to lift the ban for this user?',
		lift_ban_confirm: 'Дали сте сигурни дека сакате да ја отстраните забраната за членот?',
	},

	globals: {
		
	},

	init: function() {
		this.events();

		$("#add_birth_month").select2({
			width: '170px',
			placeholder: 'Месец',
            allowClear: true
		});

		$("#edit_birth_month").select2({
			width: '170px',
			placeholder: 'Месец',
            allowClear: true
		});

		$("#ban_select_period").select2({
			width: '170px',
			placeholder: 'Времетраење',
            allowClear: true
		});
	},

	events: function() {

		/* Left panel navigation */
		/*$('#add_user').on('click', function() {
			$('div#panel-left').find('a').removeClass('link_active');
			$(this).find('a').addClass('link_active');

			admin_users.resetNewUserForm();
			admin_users.hideStatusErrorMsgs();

			$('div.form_wrap').hide();
			$('div#add_user_wrap').show();
		});*/

		// novo
		$('#add_user').on('click', function() {
			$('div#panel-left').find('li').removeClass('active');
			$(this).addClass('active');

			admin_users.resetNewUserForm();
			admin_users.hideStatusErrorMsgs();

			$('div.form_wrap').hide();
			$('div#add_user_wrap').show();
		});

		/*$('#manage_users').on('click', function() {
			$('div#panel-left').find('a').removeClass('link_active');
			$(this).find('a').addClass('link_active');

			admin_users.getRegisteredUsers();
			admin_users.resetEditUserForm();
			admin_users.hideStatusErrorMsgs();
			$('#edit_user_form').hide();

			$('div.form_wrap').hide();
			$('div#manage_users').show();
		});*/

		$('#manage_users').on('click', function() {
			$('div#panel-left').find('li').removeClass('active');
			$(this).addClass('active');

			admin_users.getRegisteredUsers();
			admin_users.resetEditUserForm();
			admin_users.hideStatusErrorMsgs();
			$('#edit_user_form').hide();

			$('div.form_wrap').hide();
			$('div#manage_users').show();
		});

		/*$('#ban_user').on('click', function() {
			$('div#panel-left').find('a').removeClass('link_active');
			$(this).find('a').addClass('link_active');

			admin_users.getNotBannedUsers();
			admin_users.resetBanUserForm();
			admin_users.hideStatusErrorMsgs();

			$('div.form_wrap').hide();
			$('div#ban_user_wrap').show();
		});*/

		$('#ban_user').on('click', function() {
			$('div#panel-left').find('li').removeClass('active');
			$(this).addClass('active');

			admin_users.getNotBannedUsers();
			admin_users.resetBanUserForm();
			admin_users.hideStatusErrorMsgs();

			$('div.form_wrap').hide();
			$('div#ban_user_wrap').show();
		});

		/*$('#banned_users').on('click', function() {
			$('div#panel-left').find('a').removeClass('link_active');
			$(this).find('a').addClass('link_active');

			admin_users.getBannedUsers();

			$('div.form_wrap').hide();
			$('div#banned_users_wrap').show();
		});*/

		$('#banned_users').on('click', function() {
			$('div#panel-left').find('li').removeClass('active');
			$(this).addClass('active');

			admin_users.getBannedUsers();

			$('div.form_wrap').hide();
			$('div#banned_users_wrap').show();
		});

		/*$('#send_email').on('click', function() {
			$('div#panel-left').find('a').removeClass('link_active');
			$(this).find('a').addClass('link_active');

			$('div.form_wrap').hide();
			$('div#send_email_wrap').show();
		});*/


		/* Add new user */
		$('#submit_new_user').on('click', this.submitNewUser);

		$('#upload_image_btn').on('click', function() {
			$('#upload_image_sim').click();
		});

		$('#upload_image_sim').on('change', function() {
			var file_name = $('#upload_image_sim')[0].files[0]['name'];
			$('#upload_image_name').text(file_name);
		});


		/* Manage users */
		$('#edit_user_btn').on('click', function() {
			if($('#manage_users_select_action').val()) {
				var user_id = $('#manage_users_select_action').val();
				admin_users.hideStatusErrorMsgs();
				admin_users.getUserDetails(user_id);
			} else {
				admin_users.hideStatusErrorMsgs();
				$('#edit_action_status_message').text(admin_users.error_messages.error_select_user).addClass('alert-success').show();
			} 
		});

		$('#submit_edit_user').on('click', this.submitEditUser);

		$('#delete_user_btn').on('click', function() {
			if($('#manage_users_select_action').val()) {
				var user_id = $('#manage_users_select_action').val();
				admin_users.hideStatusErrorMsgs();
				admin_users.deleteUser(user_id);
			} else {
				admin_users.hideStatusErrorMsgs();
				$('#edit_action_status_message').text(admin_users.error_messages.error_select_user).addClass('alert-success').show();
			}
		});

		/* Ban user */
		$('#ban_user_submit').on('click', this.submitBanUser);

		/* List of banned users*/
		$('#banned_users_list').on('click', 'a.lift_ban', function() {
			var user_id = $(this).parent().data('id');

			admin_users.userLiftBan(user_id);
		});
	},

	hideStatusErrorMsgs: function() {
		$('.status_error_messages').hide();
		$('.status_error_messages').removeClass('alert-success');
		$('.status_error_messages').removeClass('alert-error');
	},

	submitNewUser: function() {
		var data = admin_users.getNewUserData(),
			valid = admin_users.validateNewUserData(data),
			formdata = admin_users.packNewUserFormData(data);

		if(valid) {
			$.when($.ajax({
				url: BASE_URL + 'admin_dashboard_users/addNewUser',
				type: 'post',
				data: formdata,
				dataType: 'json',
				processData: false,
                contentType: false,
			}))
			.then(function(result) {
				if(result === 1) {
					// ok
					admin_users.hideStatusErrorMsgs();
					$('#add_user_status_message').text(admin_users.error_messages.success_new_user).addClass('alert-success').show();
					admin_users.resetNewUserForm();
				} else if(result === 0) {
					// error
					admin_users.hideStatusErrorMsgs();
					$('#add_user_status_message').text(admin_users.error_messages.error_problem).addClass('alert-error').show();
				} else if(result === 2) {
					// username exist
					admin_users.hideStatusErrorMsgs();
					$('#add_username_error').text(admin_users.error_messages.error_username_exists).addClass('alert-error').show();
				} else if(result === 3) {
					// email exist
					admin_users.hideStatusErrorMsgs();
					$('#add_email_error').text(admin_users.error_messages.error_email_exists).addClass('alert-error').show();
				}
			})
			.fail(function() {
				admin_users.hideStatusErrorMsgs();
				$('#add_user_status_message').text(admin_users.error_messages.error_problem).addClass('alert-error').show();
			});
		}
	},

	resetNewUserForm: function() {
		$('#add_firstname').val('');
		$('#add_lastname').val('');
		$('#add_username').val('');
		$('#add_password').val('');
		$('#add_password_confirm').val('');
		$('#add_email').val('');
		$('#add_birth_month').select2('val', '');
		$('#add_birth_day').val('');
		$('#add_birth_year').val('');
		$('#upload_image_sim').val('');
	},

	packNewUserFormData: function(data) {
		var formdata = new FormData();

		$.each(data, function(key, value) {
			formdata.append(key, value);
		});

		return formdata;
	},

	getNewUserData: function() {
		var data = {};

		data.firstname = $('#add_firstname').val();
		data.lastname = $('#add_lastname').val();
		data.username = $('#add_username').val();
		data.password = $('#add_password').val();
		data.confirm_password = $('#add_password_confirm').val();
		data.email = $('#add_email').val();
		data.birth_month = $('#add_birth_month').select2('val');
		data.birth_day = $('#add_birth_day').val();
		data.birth_year = $('#add_birth_year').val();
		data.avatar = $('#upload_image_sim')[0].files[0];
		
		return data;
	},

	validateNewUserData: function(data) {
		var validate_birthday;

		admin_users.hideStatusErrorMsgs();

		if(data.firstname === '') {
			$('#add_firstname_error').text(admin_users.error_messages.error_firstname).addClass('alert-error').show();
			return false;
		} else if(data.lastname === '') {
			$('#add_lastname_error').text(admin_users.error_messages.error_lastname).addClass('alert-error').show();
			return false;
		} else if(data.username === '') {
			$('#add_username_error').text(admin_users.error_messages.error_username).addClass('alert-error').show();
			return false;
		} else if(data.password === '') {
			$('#add_password_error').text(admin_users.error_messages.error_password).addClass('alert-error').show();
			return false;
		} else if(data.confirm_password === '') {
			$('#add_password_confirm_error').text(admin_users.error_messages.error_password_confirm).addClass('alert-error').show();
			return false;
		} else if(data.confirm_password !== data.password) {
			$('#add_password_confirm_error').text(admin_users.error_messages.error_password_mismatch_confirm).addClass('alert-error').show();
			return false;
		} else if(data.email === '') {
			$('#add_email_error').text(admin_users.error_messages.error_email).addClass('alert-error').show();
			return false;
		} else if(!admin_users.isValidEmailAddress(data.email)) {
			$('#add_email_error').text(admin_users.error_messages.error_invalid_email).addClass('alert-error').show();
			return false;
		} else if(data.birth_month !== '') {
			if(data.birth_day === '' || data.birth_year === '') {
				$('#add_birthday_error').text(admin_users.error_messages.error_birthday).addClass('alert-error').show();
				return false;
			} else {
				validate_birthday = admin_users.validateBirthday(data.birth_month, data.birth_day, data.birth_year);
				if(validate_birthday === false) {
					$('#add_birthday_error').text(admin_users.error_messages.error_date_mismatch).addClass('alert-error').show();
					return false;
				}
			}
		} else if(data.birth_month === '' && (data.birth_day !== '' || data.birth_year !== '')) {
			$('#add_birthday_error').text(admin_users.error_messages.error_birthday).addClass('alert-error').show();
			return false;
		} else if(data.avatar) {
			if(!(data.avatar['type'] == 'image/jpg' || data.avatar['type'] == 'image/jpeg' || data.avatar['type'] == 'image/png')) {
				$('#add_avatar_error').text(admin_users.error_messages.error_avatar).addClass('alert-error').show();
				return false;
			}
		}

		return true;
	},

	isValidEmailAddress: function(emailAddress) {
	    var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);

	    return pattern.test(emailAddress);
	},

	/*
 	 *	JavaScript interprets 2/29/2011 as 3/1/2011. 
	 *	Understanding how javascript deals with wonky dates, 
	 * 	you can test for valid inputs by comparing them to what the Date object returns from getFullYear(), getMonth(), and getDate(). 
	 *	If the inputs match the method results, you've got valid input.
	*/
	validateBirthday: function(birth_month, birth_day, birth_year) {
		var month = admin_users.getMonthNumber(birth_month),
			day = parseInt(birth_day, 10),
			year = parseInt(birth_year, 10),
			date = new Date(year, month, day);

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


	/* Manage users*/
	getRegisteredUsers: function() {
    	$.when($.ajax({
			url: BASE_URL + 'admin_dashboard_users/getRegisteredUsers',
			dataType: 'json',
		}))
		.then(function(results) {
			if(results) {
				admin_users.listRegisteredUsers(results);
				$("#manage_users_select_action").select2({
					width: '260px',
					placeholder: 'Избери член',
		            allowClear: true
				});
			}
		})
		.fail(function() {
			console.log('fail-error');
		});
    },

    listRegisteredUsers: function(data) {
    	var source = $('#manageUsersSelectActionTmpl').html(),
            template = Handlebars.compile(source),
            html = template(data);

    	$('#manage_users_select_action').html(html);
    },

    resetEditUserForm: function() {
    	$('#edit_user_form_id').val('');
		$('#edit_firstname').val('');
		$('#edit_lastname').val('');
		$('#edit_username').val('');
		$('#edit_password').val('');
		$('#edit_password_confirm').val('');
		$('#edit_email').val('');
		$('#edit_birth_month').select2('val', '');
		$('#edit_birth_day').val('');
		$('#edit_birth_year').val('');
		$('#edit_upload_image_sim').val('');
    },

    getUserDetails: function(user_id) {
    	$.when($.ajax({
    		url: BASE_URL + 'admin_dashboard_users/getUserDetails',
    		type: 'post',
    		data: {
    			user_id: user_id,
    		},
    		dataType: 'json',
    	}))
    	.then(function(result) {
    		if(result) {
    			admin_users.populateEditUserForm(result);
    			$('#edit_user_form').show();
    		} else {

    		}
    	})
    	.fail(function() {

    	});
    },

    populateEditUserForm: function(data) {
		$('#edit_user_form_id').val(data._id.$id);
		$('#edit_firstname').val(data.firstname);
		$('#edit_lastname').val(data.lastname);
		$('#edit_username').val(data.username);
		$('#edit_email').val(data.email);
		$('#edit_birth_month').select2('val', data.birth_month);
		$('#edit_birth_day').val(data.birth_day);
		$('#edit_birth_year').val(data.birth_year);
    },

    submitEditUser: function() {
    	var data = admin_users.getEditUserData(),
    		valid = admin_users.validateEditUserData(data);
    		formdata = admin_users.packEditUserFormData(data);

		if(valid) {
			$.when($.ajax({
				url: BASE_URL + 'admin_dashboard_users/editUser',
				type: 'post',
				data: formdata,
				dataType: 'json',
				processData: false,
                contentType: false,
			}))
			.then(function(result) {
				if(result === 1) {
					// ok
					admin_users.hideStatusErrorMsgs();
					$('#edit_user_status_message').text(admin_users.error_messages.success_edit_user).addClass('alert-success').show();
					// admin_users.resetEditUserForm();
					window.setTimeout(function() {
						admin_users.hideStatusErrorMsgs();
         				$('#manage_users').click();
				    }, 3000);
				} else if(result === 0) {
					// error
					admin_users.hideStatusErrorMsgs();
					$('#edit_user_status_message').text(admin_users.error_messages.error_problem).addClass('alert-error').show();
				} else if(result === 2) {
					// username exist
					admin_users.hideStatusErrorMsgs();
					$('#edit_username_error').text(admin_users.error_messages.error_username_exists).addClass('alert-error').show();
				} else if(result === 3) {
					// email exist
					admin_users.hideStatusErrorMsgs();
					$('#edit_email_error').text(admin_users.error_messages.error_email_exists).addClass('alert-error').show();
				}
			})
			.fail(function() {
				admin_users.hideStatusErrorMsgs();
				$('#edit_user_status_message').text(admin_users.error_messages.error_problem).addClass('alert-error').show();
			});
		}		
    },

    getEditUserData: function() {
    	var data = {};

    	data.id = $('#edit_user_form_id').val();
		data.firstname = $('#edit_firstname').val();
		data.lastname = $('#edit_lastname').val();
		data.username = $('#edit_username').val();
		// data.password = $('#edit_password').val();
		// data.confirm_password = $('#edit_password_confirm').val();
		data.email = $('#edit_email').val();
		data.birth_month = $('#edit_birth_month').select2('val');
		data.birth_day = $('#edit_birth_day').val();
		data.birth_year = $('#edit_birth_year').val();
		data.avatar = $('#edit_upload_image_sim')[0].files[0];
		
		return data;
    },

    validateEditUserData: function(data) {
    	var validate_birthday;

		admin_users.hideStatusErrorMsgs();

		if(data.firstname === '') {
			$('#edit_firstname_error').text(admin_users.error_messages.error_firstname).addClass('alert-error').show();
			return false;
		} else if(data.lastname === '') {
			$('#edit_lastname_error').text(admin_users.error_messages.error_lastname).addClass('alert-error').show();
			return false;
		} else if(data.username === '') {
			$('#edit_username_error').text(admin_users.error_messages.error_username).addClass('alert-error').show();
			return false;
		} /*else if(data.password === '') {
			$('#edit_password_error').text(admin_users.error_messages.error_password).addClass('alert-error').show();
			return false;
		} else if(data.confirm_password === '') {
			$('#edit_password_confirm_error').text(admin_users.error_messages.error_password_confirm).addClass('alert-error').show();
			return false;
		} else if(data.confirm_password !== data.password) {
			$('#edit_password_confirm_error').text(admin_users.error_messages.error_password_mismatch_confirm).addClass('alert-error').show();
			return false;
		}*/ else if(data.email === '') {
			$('#edit_email_error').text(admin_users.error_messages.error_email).addClass('alert-error').show();
			return false;
		} else if(!admin_users.isValidEmailAddress(data.email)) {
			$('#edit_email_error').text(admin_users.error_messages.error_invalid_email).addClass('alert-error').show();
			return false;
		} else if(data.birth_month !== '') {
			if(data.birth_day === '' || data.birth_year === '') {
				$('#edit_birthday_error').text(admin_users.error_messages.error_birthday).addClass('alert-error').show();
				return false;
			} else {
				validate_birthday = admin_users.validateBirthday(data.birth_month, data.birth_day, data.birth_year);
				if(validate_birthday === false) {
					$('#edit_birthday_error').text(admin_users.error_messages.error_date_mismatch).addClass('alert-error').show();
					return false;
				}
			}
		} else if(data.birth_month === '' && (data.birth_day !== '' || data.birth_year !== '')) {
			$('#edit_birthday_error').text(admin_users.error_messages.error_birthday).addClass('alert-error').show();
			return false;
		} else if(data.avatar) {
			if(!(data.avatar['type'] == 'image/jpg' || data.avatar['type'] == 'image/jpeg' || data.avatar['type'] == 'image/png')) {
				$('#edit_avatar_error').text(admin_users.error_messages.error_avatar).addClass('alert-error').show();
				return false;
			}
		}

		return true;
    },

    packEditUserFormData: function(data) {
		var formdata = new FormData();

		$.each(data, function(key, value) {
			formdata.append(key, value);
		});

		return formdata;
    },

    deleteUser: function(user_id) {
    	var conf = confirm('' + admin_users.error_messages.delete_user_confirm + '');

    	if(conf === true) {
    		$.when($.ajax({
				url: BASE_URL + 'admin_dashboard_users/deleteUser',
				type: 'post',
				data: {
					user_id: user_id,
				},
				dataType: 'json',
			}))
			.then(function(result) {
				if(result === 1) {
					admin_users.hideStatusErrorMsgs();
					$('#edit_action_status_message').text(admin_users.error_messages.success_delete_user).addClass('alert-success').show();
					window.setTimeout(function() {
						admin_users.hideStatusErrorMsgs();
         				$('#manage_users').click();
				    }, 3000);
				} else {
					admin_users.hideStatusErrorMsgs();
					$('#edit_action_status_message').text(admin_users.error_messages.error_problem).addClass('alert-error').show();
				}
			})
			.fail(function() {
				admin_users.hideStatusErrorMsgs();
				$('#edit_action_status_message').text(admin_users.error_messages.error_problem).addClass('alert-error').show();
			});
		}
    },


    /* Ban user */
    resetBanUserForm: function() {
    	$('#ban_select_user').select2('data', null);
		$('#ban_select_period').select2('val', '');
		$('#ban_reason').val('');
    },

    getNotBannedUsers: function() {
    	$.when($.ajax({
			url: BASE_URL + 'admin_dashboard_users/getNotBannedUsers',
			dataType: 'json',
		}))
		.then(function(results) {
			if(results) {
				admin_users.listNotBannedUsers(results);
				$("#ban_select_user").select2({
					width: '260px',
					placeholder: 'Избери член',
		            allowClear: true
				});
			}
		})
		.fail(function() {
			console.log('fail-error');
		});
    },   

    listNotBannedUsers: function(data) {
    	var source = $('#manageUsersSelectActionTmpl').html(),
            template = Handlebars.compile(source),
            html = template(data);

    	$('#ban_select_user').html(html);
    },
    
    submitBanUser: function() {
    	var data = admin_users.getBanUserData(),
    		valid = admin_users.validateBanUserData(data);

		if(valid) {
			$.when($.ajax({
				url: BASE_URL + 'admin_dashboard_users/banUser',
				type: 'post',
				data: data,
				dataType: 'json',
			}))
			.then(function(result) {
				if(result === 1) {
					admin_users.hideStatusErrorMsgs();
					admin_users.resetBanUserForm();
					$('#ban_user_status_message').text(admin_users.error_messages.success_ban_user).addClass('alert-success').show();
				} else {
					admin_users.hideStatusErrorMsgs();
					$('#ban_user_status_message').text(admin_users.error_messages.error_problem).addClass('alert-error').show();
				}
			})
			.fail(function() {
				admin_users.hideStatusErrorMsgs();
				$('#ban_user_status_message').text(admin_users.error_messages.error_problem).addClass('alert-error').show();
			})
		}
    },

    getBanUserData: function() {
    	var data = {};

    	data.user_id = $('#ban_select_user').val();
    	data.ban_period = $('#ban_select_period').select2('val');
    	data.ban_reason = $('#ban_reason').val();

    	return data;
    },

    validateBanUserData: function(data) {
    	if(data.user_id === '') {
			admin_users.hideStatusErrorMsgs();
			$('#ban_select_user_error').text(admin_users.error_messages.error_select_user).addClass('alert-error').show();
			return false;
    	} else if(data.ban_period === '') {
    		admin_users.hideStatusErrorMsgs();
			$('#ban_select_period_error').text(admin_users.error_messages.error_ban_period).addClass('alert-error').show();
			return false;
    	} else if(data.ban_reason === '') {
    		admin_users.hideStatusErrorMsgs();
			$('#ban_reason_error').text(admin_users.error_messages.error_ban_reason).addClass('alert-error').show();
			return false;
    	}

    	return true;
    },


    /*List of banned users */
    getBannedUsers: function() {
    	$.when($.ajax({
    		url: BASE_URL + 'admin_dashboard_users/getBannedUsers',
    		dataType: 'json',
    	}))
    	.then(function(result) {
    		if(result) {
    			admin_users.listBannedUsers(result);
    		}
    	})
    	.fail(function() {
    		console.log('fail');
    	});
    },

    listBannedUsers: function(data) {
    	var source = $('#listOfBannedUsersTmpl').html(),
            template = Handlebars.compile(source),
            html = template(data);

    	$('#banned_users_list').html(html);
    },

    userLiftBan: function(user_id) {
    	var conf = confirm('' + admin_users.error_messages.lift_ban_confirm + '');
    	if(conf) {
    		$.when($.ajax({
	    		url: BASE_URL + 'admin_dashboard_users/userLiftBan',
	    		type: 'post',
	    		data: {
	    			user_id: user_id,
	    		},
	    		dataType: 'json',
	    	}))
	    	.then(function(result) {
	    		if(result) {
	    			$('#banned_users').click();
	    		}
	    	})
	    	.fail(function() {
	    		console.log('fail');
	    	});
    	}
    }
};

$(function() {
	admin_users.init();
});
var user_profile = {
	error_messages: {
		error_problem: 'Настана грешка. Обидете се повторно.',
		error_ban_period: 'Изберете временски период.',
		error_ban_reason: 'Внесете причина за забраната.',
		success_ban_user: 'Членот е успешно баниран',
		lift_ban_confirm: 'Дали сте сигурни дека сакате да ја укинете забраната за овој член?',

	},

	globals: {
		user_id: undefined,
	},

	init: function() {
		$('#ban_select_period').select2({
			width: '180px',
			placeholder: 'Времетраење',
            allowClear: true
		});

		this.events();
		this.getUserId();
		this.paginate();
	},

	events: function() {
		$('#ban_user_btn').on('click', this.banUserModal);
		$('#unban_user_btn').on('click', this.userLiftBan);
		$('#ban_user_submit').on('click', this.banUserSubmit);
		$('.close_modal').on('click', this.resetBanUserForm);
	},

	hideStatusErrorMsgs: function() {
		$('.status_error_messages').text('').hide();
		$('.status_error_messages').removeClass('alert-success');
		$('.status_error_messages').removeClass('alert-error');
	},

	getUserId: function() {
		var pathname = window.location.pathname.split('/');

		user_profile.globals.user_id = pathname[3];
	},

	initializeBootstrapPaginator: function(posts_num, currentPage) {
		/* If topic is deleted and the number of total pages is less then number of the current page */
		var totalPages = Math.ceil(posts_num/4);

		if(totalPages < currentPage) {
			currentPage = totalPages;
		}

		if(posts_num > 4) {
			$('#pagination').show();
			$('#pagination').bootstrapPaginator({
				currentPage: currentPage,
		        totalPages: totalPages,
		        numberOfPages: 10,
		        itemContainerClass: function (type, page, current) {
	                return (page === current) ? "active" : "pointer-cursor";
	            },
		        onPageChanged: function(e,oldPage,newPage) {
		        	user_profile.paginate(newPage);
	                $('html,body').animate({scrollTop: 0}, 600);
	            }
		    });
		} else {
			$('#pagination').hide();
			$('#pagination').bootstrapPaginator({
				currentPage: 1,
		        totalPages: 1,
		        numberOfPages: 10,
		    });
		}
	},

	calculateResultsOffset: function(current) {
		var from = undefined;
		var current_page = user_profile.setCurrentPage(current);

		from = (current_page - 1) * 4; 

		return from;
	},

	setCurrentPage: function(pageNum) {
		var currentPage = pageNum ? pageNum : 1;

		return currentPage;
	},

	paginate: function(pageNum) {
		var currentPage = user_profile.setCurrentPage(pageNum);
		var from = user_profile.calculateResultsOffset(currentPage);

		$.when(user_profile.getPostsCount(), user_profile.getPostsList(from))
    	.then(function(result_count, result_list) {
    		user_profile.initializeBootstrapPaginator(result_count[0], currentPage);
    		user_profile.listPosts(result_list[0]);
    	})
    	.fail(function() {
    		
    	});
	},

	getPostsCount: function() {
		return $.ajax({
    		url: BASE_URL + 'user_profile/getPostsCount/',
    		data: {
				user_id: user_profile.globals.user_id,
			},
    		type:'post',
    		dataType: 'json'
    	});
	},

	getPostsList: function(from) {
		return $.ajax({
    		url: BASE_URL + 'user_profile/getPostsList/',
    		data: {
				user_id: user_profile.globals.user_id,
				from: from,
			},
    		type:'post',
    		dataType: 'json'
    	});
	},

	listPosts: function(result) {
		var source = $('#userPostsListTemplate').html();
		var template = Handlebars.compile(source);
	    var html = template(result);

	    $('#user_profile_posts_wrap').html(html);
	},

	banUserModal: function() {
		$('#banUserModal').modal();
	},

	resetBanUserForm: function() {
		user_profile.hideStatusErrorMsgs();
		$('#ban_select_period').select2('val', '');
		$('textarea#ban_reason').val('');
	},

	banUserSubmit: function() {
		var data = user_profile.getBanUserData();
		var valid = user_profile.validateBanUserData(data);

		if(valid) {
			$('#ban_user_submit').addClass('disabled');

			$.when($.ajax({
				url: BASE_URL + 'user_profile/banUser',
				data: data,
				type: 'post',
				dataType: 'json'
			}))
			.then(function(result) {	
				if(result) {
					user_profile.resetBanUserForm();
					$('#ban_user_submit').removeClass('disabled');
					$('#ban_user_msgs').text(user_profile.error_messages.success_ban_user).addClass('alert-success').show();
					$('#ban_user_btn').hide();
					$('#unban_user_btn').show();
				} else {
					user_profile.resetBanUserForm();
					$('#ban_user_submit').removeClass('disabled');
					$('#ban_user_msgs').text(user_profile.error_messages.error_problem).addClass('alert-error').show();
				}
			})
			.fail(function() {
				user_profile.resetBanUserForm();
				$('#ban_user_submit').removeClass('disabled');
				$('#ban_user_msgs').text(user_profile.error_messages.error_problem).addClass('alert-error').show();
			});
		}
	},

	getBanUserData: function() {
		var data = {};

    	data.user_id = user_profile.globals.user_id;
    	data.ban_period = $('#ban_select_period').select2('val');
    	data.ban_reason = $('#ban_reason').val();

    	return data;
	},

	validateBanUserData: function(data) {
		user_profile.hideStatusErrorMsgs();
		
		if(data.ban_period === '') {
			$('#ban_user_msgs').text(user_profile.error_messages.error_ban_period).addClass('alert-error').show();
			return false;
    	} else if(data.ban_reason === '') {
			$('#ban_user_msgs').text(user_profile.error_messages.error_ban_reason).addClass('alert-error').show();
			return false;
    	}

    	return true;
	},

	userLiftBan: function() {
    	var conf = confirm('' + user_profile.error_messages.lift_ban_confirm + '');
    	if(conf) {
    		$.when($.ajax({
	    		url: BASE_URL + 'user_profile/userLiftBan',
	    		type: 'post',
	    		data: {
	    			user_id: user_profile.globals.user_id
	    		},
	    		dataType: 'json',
	    	}))
	    	.then(function(result) {
				$('#unban_user_btn').hide();
	    		$('#ban_user_btn').show();
	    	})
	    	.fail(function() {
	    		
	    	});
    	}
    },


};

$(function() {
	user_profile.init();
});
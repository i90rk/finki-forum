var admin_dashboard = {

	error_messages: {
		// error_title: 'This field is required.',
		error_title: 'Ова поле е задолжително.',
		// error_description: 'This field is required.',
		error_description: 'Ова поле е задолжително.',
		// error_display_order: 'This field is required and must contain numeric value between 0 and 50.',
		error_display_order: 'Ова поле е задолжително и мора да содржи нумеричка вредност помеѓу 0 и 50.',
		// error_problem: 'Problem occured. Please try again.',
		error_problem: 'Настана грешка. Обидете се повторно.',
		// success_new_forum: 'New forum added successfully.',
		success_new_forum: 'Форумот е успешно додаден.',
		// success_edit_forum: 'The forum was edited successfully.',
		success_edit_forum: 'Форумот е успешно променет.',
		// error_edit_forum_order: 'All fields are required.',
		error_edit_forum_order: 'Сите полиња се задолжителни.',
		// error_quick_display_order: 'Display order field must contain numeric value between 0 and 50.',
		error_quick_display_order: 'Полето за редослед мора да содржи нумеричка вредност помеѓу 0 и 50.',
		// success_edit_forum_order: 'Forums display order successfully changed.',
		success_edit_forum_order: 'Редоследот на форумите е успешно променет.',
		// delete_forum_confirm: 'Are you sure you want to delete this forum?\n\nNOTE: Every subforum, topic and post in this forum will be also deleted.',
		delete_forum_confirm: 'Дали сте сигурни дека сакате да го избришете форумот?\n\nЗабелешка: Сите подфоруми, теми и мислења во овој форум исто така ќе бидат избришани.',
		// delete_forum: 'The forum was deleted successfully.',
		delete_forum: 'Форумот е успешно избришан.',
		// error_parent_forum: 'Please select parent forum for new subforum.',
		error_parent_forum: 'Селектирајте форум родител за новиот подфорум.',
		// success_new_subforum: 'New subforum added successfully.',
		success_new_subforum: 'Подфорумот е успешно додаден.',
		// error_edit_parent_forum: 'Please select parent forum.',
		error_edit_parent_forum: 'Селектирајте форум родител.',
		// success_edit_subforum: 'The subforum was edited successfully.',
		success_edit_subforum: 'Подфорумот е успешно променет.',
		// delete_subforum_confirm: 'Are you sure you want to delete this subforum?\n\nNOTE: Every topic and post in this subforum will be also deleted.',
		delete_subforum_confirm: 'Дали сте сигурни дека сакате да го избришете подфорумот?\n\nЗабелешка: Сите теми и мислења во овој подфорум исто така ќе бидат избришани.',
		// delete_subforum: 'The subforum was deleted successfully.',
		delete_subforum: 'Подфорумот е успешно избришан.',
		// error_edit_subforum_order: 'All fields are required.',
		error_edit_subforum_order: 'Сите полиња се задолжителни.',
		// success_edit_subforum_order: 'Subforums display order successfully changed.',
		success_edit_subforum_order: 'Редоследот на подфорумите е успешно променет.',
		// new_moderator_select_error: 'Please choose a user.',
		new_moderator_select_error: 'Селектирајте член.',
		// success_add_moderator: 'New moderator added successfully.',
		success_add_moderator: 'Модераторот е успешно додаден.',
		// delete_moderator_confirm: 'Are you sure you want to remove this moderator?',
		delete_moderator_confirm: 'Дали сте сигурни дека сакате да го отстраните модераторот?',
		// success_edit_moderator: 'The moderator was edited successfully.',
		success_edit_moderator: 'Модераторот е успешно променет.',
	},

	globals: {
		
	},

	init: function() {
		this.events();
	},

	events: function() {

		/* Side menu events */
		/*$('#new_forum').on('click', function() {
			$('div#panel-left').find('a').removeClass('link_active');
			$(this).find('a').addClass('link_active');

			admin_dashboard.resetNewForumForm();
			admin_dashboard.hideStatusErrorMsgs();

			$('div.form_wrap').hide();
			$('div#new_forum_wrap').show();
		});*/
		
		// novo
		$('#new_forum').on('click', function() {
			$('div#panel-left').find('li').removeClass('active');
			$(this).addClass('active');

			admin_dashboard.resetNewForumForm();
			admin_dashboard.hideStatusErrorMsgs();

			$('div.form_wrap').hide();
			$('div#new_forum_wrap').show();
		});

		/*$('#manage_forums').on('click', function() {
			$('div#panel-left').find('a').removeClass('link_active');
			$(this).find('a').addClass('link_active');

			admin_dashboard.getForumsList();
			admin_dashboard.hideStatusErrorMsgs();

			$('div.form_wrap').hide();
			$('div#manage_forums_wrap').show();
		});*/
		
		// novo
		$('#manage_forums').on('click', function() {
			$('div#panel-left').find('li').removeClass('active');
			$(this).addClass('active');

			admin_dashboard.getForumsList();
			admin_dashboard.hideStatusErrorMsgs();

			$('div.form_wrap').hide();
			$('div#manage_forums_wrap').show();
		});

		/*$('#new_subforum').on('click', function() {
			$('div#panel-left').find('a').removeClass('link_active');
			$(this).find('a').addClass('link_active');

			admin_dashboard.resetNewSubforumForm();
			admin_dashboard.hideStatusErrorMsgs();
			admin_dashboard.getParentForums();

			$('div.form_wrap').hide();
			$('div#new_subforum_wrap').show();
		});*/
		
		// novo
		$('#new_subforum').on('click', function() {
			$('div#panel-left').find('li').removeClass('active');
			$(this).addClass('active');

			admin_dashboard.resetNewSubforumForm();
			admin_dashboard.hideStatusErrorMsgs();
			admin_dashboard.getParentForums();

			$('div.form_wrap').hide();
			$('div#new_subforum_wrap').show();
		});

		/*$('#manage_subforums').on('click', function() {
			$('div#panel-left').find('a').removeClass('link_active');
			$(this).find('a').addClass('link_active');

			admin_dashboard.getSubforumsList();
			admin_dashboard.hideStatusErrorMsgs();

			$('div.form_wrap').hide();
			$('div#manage_subforums_wrap').show();
		});*/
		
		// novo
		$('#manage_subforums').on('click', function() {
			$('div#panel-left').find('li').removeClass('active');
			$(this).addClass('active');

			admin_dashboard.getSubforumsList();
			admin_dashboard.hideStatusErrorMsgs();

			$('div.form_wrap').hide();
			$('div#manage_subforums_wrap').show();
		});


		/* Submit new forum */
		$('#submit_new_forum').on('click', this.submitNewForum);


		/* Manage forums */
		$('div#forums_list').on('click', '.action_button', function() {
			var action = $(this).prev().select2('val'),
				id = $(this).parent().data('id');

			if(action === 'edit') {
				admin_dashboard.showEditForumForm(id);
			} else if(action === 'delete') {
				admin_dashboard.deleteForum(id);
			}
		});


		/* Submit edit forum */
		$('#submit_edit_forum').on('click', this.editForumSubmit);


		/* Save forum order */
		$('#forums_list').on('click', '#save_forum_order', this.updateForumsOrders);


		/* Select forum moderator action */
		$('#forums_list').on('click', '.forum_manage_moderators_btn', function() {
			var action = $(this).prev().select2('val');
			var	forum_id = $(this).parent().data('id');
			var title = $(this).parent().prev().prev().prev().text();

			$('.header_title').html('<b>Форум: </b><span>' + title + '</span>');

			switch(action) {
				case 'moderators':
					admin_dashboard.hideStatusErrorMsgs();
					admin_dashboard.getForumModeratorsList(forum_id);
					$('#list_moderator_module').val('forum');
					$('#list_moderator_forumid').val(forum_id);
					$('div.form_wrap').hide();
					$('div#list_moderators_wrap').show();
					break;

				case 'add_moderator':
					admin_dashboard.hideStatusErrorMsgs();
					admin_dashboard.resetNewModeratorForm();
					admin_dashboard.getNotBannedNotForumModeratorUsers(forum_id);
					$('#new_moderator_module').val('forum');
					$('#new_moderator_forumid').val(forum_id);
					$('div.form_wrap').hide();
					$('div#add_new_moderator_wrap').show();
					break;

				default:
					var user_id = action;
					var username = $(this).parent().find('select option:selected').text();
					$('.header_user').text(username);

					admin_dashboard.hideStatusErrorMsgs();
					admin_dashboard.resetEditModeratorForm();
					admin_dashboard.getForumModeratorAbilities(forum_id, user_id);
					$('#edit_moderator_module').val('forum');
					$('#edit_moderator_userid').val(user_id);
					$('#edit_moderator_forumid').val(forum_id);
					$('div.form_wrap').hide();
					$('div#edit_moderator_wrap').show();
					break;
			}
		});


		/* Submit new subforum */
		$('#submit_new_subforum').on('click', this.submitNewSubforum);


		/* Manage subforums */
		$('div#subforums_list').on('click', '.action_button', function() {
			var action = $(this).prev().select2('val'),
				subforum_id = $(this).parent().data('id'),
				forum_id = $(this).parent().data('forum_id');

			if(action === 'edit') {
				admin_dashboard.editSubforumCallback(forum_id, subforum_id);
			} else if(action === 'delete') {
				admin_dashboard.deleteSubforum(forum_id, subforum_id);
			}
		});


		/* Submit edit subforum */
		$('#submit_edit_subforum').on('click', this.editSubforumSubmit);


		/* Save subforum order */
		$('div#subforums_list').on('click', '.save_subforum_order', function() {
			var table_id = $(this).parents().get(3).id,
				forum_id = $(this).parent().data('forum_id');

			admin_dashboard.updateSubforumsOrders(table_id, forum_id);
		});


		/* Select subforum moderator action */
		$('#subforums_list').on('click', '.subforum_manage_moderators_btn', function() {
			var action = $(this).prev().val();
			var	subforum_id = $(this).parent().data('id');
			var	forum_id = $(this).parent().data('forum_id');
			var title = $(this).parent().prev().prev().prev().text();

			$('.header_title').html('<b>Подфорум: </b><span>' + title + '</span>');

			switch(action) {
				case 'moderators':
					admin_dashboard.hideStatusErrorMsgs();
					admin_dashboard.getSubforumModeratorsList(forum_id, subforum_id);

					$('#list_moderator_module').val('subforum');
					$('#list_moderator_forumid').val(forum_id);
					$('#list_moderator_subforumid').val(subforum_id);
					$('div.form_wrap').hide();
					$('div#list_moderators_wrap').show();
					break;

				case 'add_moderator':
					admin_dashboard.hideStatusErrorMsgs();
					admin_dashboard.resetNewModeratorForm();
					admin_dashboard.getNotBannedNotSubforumModeratorUsers(forum_id, subforum_id);
					$('#new_moderator_module').val('subforum');
					$('#new_moderator_forumid').val(forum_id);
					$('#new_moderator_subforumid').val(subforum_id);
					$('div.form_wrap').hide();
					$('div#add_new_moderator_wrap').show();
					break;

				default:
					var user_id = action;
					var username = $(this).parent().find('select option:selected').text();
					$('.header_user').text(username);

					admin_dashboard.hideStatusErrorMsgs();
					admin_dashboard.resetEditModeratorForm();
					admin_dashboard.getSubforumModeratorAbilities(subforum_id, user_id);
					$('#edit_moderator_module').val('subforum');
					$('#edit_moderator_userid').val(user_id);
					$('#edit_moderator_forumid').val(forum_id);
					$('#edit_moderator_subforumid').val(subforum_id);
					$('div.form_wrap').hide();
					$('div#edit_moderator_wrap').show();
					break;
			}
		});

		
		/* Submit new moderator */
		$('#submit_new_moderator').on('click', function() {
			var module = $('#new_moderator_module').val();

			if(module === 'forum') {
				admin_dashboard.submitNewForumModerator();
			} else {
				admin_dashboard.submitNewSubforumModerator();
			}
		});


		/* Edit moderator from list */
		$('#list_moderators_table').on('click', '.edit_abilities', function() {
			var module = $('#list_moderator_module').val();
			var	user_id = $(this).parent().data('id');
			var	forum_id = $('#list_moderator_forumid').val();
			var	subforum_id = $('#list_moderator_subforumid').val();

			var username = $(this).parent().prev().text();
			var fullname = $(this).parent().prev().prev().text();
			var user = fullname + ' (' + username + ')';

			$('.header_user').text(user);

			if(module === 'forum') {
				admin_dashboard.hideStatusErrorMsgs();
				admin_dashboard.resetEditModeratorForm();
				admin_dashboard.getForumModeratorAbilities(forum_id, user_id);
				$('#edit_moderator_module').val('forum');
				$('#edit_moderator_userid').val(user_id);
				$('#edit_moderator_forumid').val(forum_id);
				$('div.form_wrap').hide();
				$('div#edit_moderator_wrap').show();
			} else {
				admin_dashboard.hideStatusErrorMsgs();
				admin_dashboard.resetEditModeratorForm();
				admin_dashboard.getSubforumModeratorAbilities(subforum_id, user_id);
				$('#edit_moderator_module').val('subforum');
				$('#edit_moderator_userid').val(user_id);
				$('#edit_moderator_forumid').val(forum_id);
				$('#edit_moderator_subforumid').val(subforum_id);
				$('div.form_wrap').hide();
				$('div#edit_moderator_wrap').show();
			}
		});


		/* Delete moderator from list */
		$('#list_moderators_table').on('click', '.delete_moderator', function() {
			var module = $('#list_moderator_module').val(),
				user_id = $(this).parent().data('id'),
				forum_id = $('#list_moderator_forumid').val(),
				subforum_id = $('#list_moderator_subforumid').val();

			if(module === 'forum') {
				admin_dashboard.hideStatusErrorMsgs();
				admin_dashboard.deleteForumModerator(user_id, forum_id);
			} else {
				admin_dashboard.hideStatusErrorMsgs();
				admin_dashboard.deleteSubforumModerator(subforum_id, user_id, forum_id);
			}
		});


		/* Submit edit moderator */
		$('#submit_edit_moderator').on('click', function() {
			var module = $('#edit_moderator_module').val();

			if(module === 'forum') {
				admin_dashboard.submitEditForumModerator();
			} else {
				admin_dashboard.submitEditSubforumModerator();
			}
		});
	},


	/* Hide messages */
	hideStatusErrorMsgs: function() {
		$('.status_error_messages').hide();
		$('.status_error_messages').removeClass('alert-success');
		$('.status_error_messages').removeClass('alert-error');

		// This is for manage subforums table
		$('#subforums_list').find('.status_error_messages').hide();
		$('#subforums_list').find('.status_error_messages').removeClass('alert-success');
		$('#subforums_list').find('.status_error_messages').removeClass('alert-error');
	},


	/* Add new forum */
	submitNewForum: function() {
		var data = admin_dashboard.getNewForumData(),
			valid = admin_dashboard.validateNewForumData(data);

		if(valid) {
			$.when($.ajax({
				url: BASE_URL + 'admin_dashboard/addNewForum',
				type: 'post',
				dataType: 'json',
				data: data,
			}))
			.then(function(result) {
				if(result === 1) {
					admin_dashboard.hideStatusErrorMsgs();
					$('#new_forum_status_message').text(admin_dashboard.error_messages.success_new_forum).addClass('alert-success').show();
					admin_dashboard.resetNewForumForm();
				} else {
					admin_dashboard.hideStatusErrorMsgs();
					$('#new_forum_status_message').text(admin_dashboard.error_messages.error_problem).addClass('alert-error').show();
				}
			})
			.fail(function() {
				admin_dashboard.hideStatusErrorMsgs();
				$('#new_forum_status_message').text(admin_dashboard.error_messages.error_problem).addClass('alert-error').show();
			});
		}
	},

	getNewForumData: function() {
		var data = {};

		data.title = $('#title').val();
		data.description = $('#description').val();
		data.display_order = $('#display_order').val();

		return data;
	},

	validateNewForumData: function(data) {
		admin_dashboard.hideStatusErrorMsgs();

		if(data.title === '') {
			$('#title_error').text(admin_dashboard.error_messages.error_title).addClass('alert-error').show();
			return false;
		} else if(data.description === '') {
			$('#description_error').text(admin_dashboard.error_messages.error_description).addClass('alert-error').show();
			return false;
		} else if(data.display_order === '' || !(data.display_order).match(/(^[0-9]{1}$|^[0-4]{1}[0-9]{1}$|^50$)/gm)) {
			$('#display_order_error').text(admin_dashboard.error_messages.error_display_order).addClass('alert-error').show();
			return false;
		}

		return true;
	},

	resetNewForumForm: function() {
		$('#title').val('');
		$('#description').val('');
		$('#display_order').val('');
	},


	/* Get forums data */
	getForumsList: function() {
		$.when($.ajax({
			url: BASE_URL + 'admin_dashboard/getForums',
			dataType: 'json',
		}))
		.then(function(results) {
			if(results) {
				admin_dashboard.listForums(results);
				$(".select_manage_forum_action").select2({
					// width: '260px',
					placeholder: 'Акција',
		            allowClear: true
				});

				$(".forum_manage_moderators").select2({
					width: '270px',
					placeholder: 'Акција',
		            allowClear: true
				});
			}
		})
		.fail(function() {
			console.log('fail-error');
		});
	},

	listForums: function(data) {
	    var source = $('#forumsListTemplate').html(),
	            template = Handlebars.compile(source),
	            html = template(data);

	    $('#forums_list').html(html);
    },


    /* Edit forum */
    showEditForumForm: function(forum_id) {
    	admin_dashboard.resetEditForumForm();
    	admin_dashboard.hideStatusErrorMsgs();

    	$.when($.ajax({
    		url: BASE_URL + 'admin_dashboard/getForumDetails',
    		type:'post',
    		data: {
    			forum_id: forum_id
    		},
    		dataType: 'json',
    	}))
    	.then(function(result) {
    		if(result) {
    			admin_dashboard.populateEditForm(result);
    			$('#manage_forums_wrap').hide();
    			$('#edit_forum_wrap').show();
    		} else {
    			admin_dashboard.hideStatusErrorMsgs();
				$('#manage_forums_error_msgs').text(admin_dashboard.error_messages.error_problem).addClass('alert-error').show();
    		}
    	})
    	.fail(function() {
    		admin_dashboard.hideStatusErrorMsgs();
			$('#manage_forums_error_msgs').text(admin_dashboard.error_messages.error_problem).addClass('alert-error').show();
    	});
    },

    populateEditForm: function(data) {
    	$('#edit_id').val(data._id.$id);
    	$('#edit_title').val(data.title);
    	$('#edit_description').val(data.description);
    	$('#edit_display_order').val(data.display_order);
    },

    editForumSubmit: function() {
		var data = admin_dashboard.getEditForumData(),
			valid = admin_dashboard.validateEditForumData(data);

		if(valid) {
			$.when($.ajax({
				url: BASE_URL + 'admin_dashboard/editForum',
				type: 'post',
				data: data,
				dataType: 'json',
			}))
			.then(function(result) {
				if(result === 1) {
					admin_dashboard.hideStatusErrorMsgs();
					$('#edit_forum_status_message').text(admin_dashboard.error_messages.success_edit_forum).addClass('alert-success').show();
					window.setTimeout(function() {  
         				$('#manage_forums').click();
				    }, 3000);
				} else {
					admin_dashboard.hideStatusErrorMsgs();
					$('#edit_forum_status_message').text(admin_dashboard.error_messages.error_problem).addClass('alert-error').show();
				}
			})
			.fail(function() {
				admin_dashboard.hideStatusErrorMsgs();
				$('#edit_forum_status_message').text(admin_dashboard.error_messages.error_problem).addClass('alert-error').show();
			})
		}
    },

    getEditForumData: function() {
    	var data = {};

    	data.id = $('#edit_id').val();
    	data.title = $('#edit_title').val();
		data.description = $('#edit_description').val();
		data.display_order = $('#edit_display_order').val();

		return data;
    },

    validateEditForumData: function(data) {
    	admin_dashboard.hideStatusErrorMsgs();

    	if(data.id === '') {
			$('#edit_forum_status_message').text(admin_dashboard.error_messages.error_problem).addClass('alert-error').show();
			return false;
    	}
		else if(data.title === '') {
			$('#edit_title_error').text(admin_dashboard.error_messages.error_title).addClass('alert-error').show();
			return false;
		} else if(data.description === '') {
			$('#edit_description_error').text(admin_dashboard.error_messages.error_description).addClass('alert-error').show();
			return false;
		} else if(data.display_order === '' || !(data.display_order).match(/(^[0-9]{1}$|^[0-4]{1}[0-9]{1}$|^50$)/gm)) {
			$('#edit_display_order_error').text(admin_dashboard.error_messages.error_display_order).addClass('alert-error').show();
			return false;
		}

		return true;
    },

    resetEditForumForm: function() {
    	$('#edit_id').val('');
    	$('#edit_title').val('');
		$('#edit_description').val('');
		$('#edit_display_order').val('');
		admin_dashboard.hideStatusErrorMsgs();
    },


    /* Delete forum */
    deleteForum: function(forum_id) {
    	var conf = confirm('' + admin_dashboard.error_messages.delete_forum_confirm + '');

    	if(conf === true) {
    		$.when($.ajax({
				url: BASE_URL + 'admin_dashboard/deleteForum',
				type: 'post',
				data: {
					forum_id: forum_id,
				},
				dataType: 'json',
			}))
			.then(function(result) {
				if(result === 1) {
					admin_dashboard.hideStatusErrorMsgs();
					$('#manage_forums_error_msgs').text(admin_dashboard.error_messages.delete_forum).addClass('alert-success').show();
					window.setTimeout(function() {
						admin_dashboard.hideStatusErrorMsgs();
         				$('#manage_forums').click();
				    }, 3000);
				} else {
					admin_dashboard.hideStatusErrorMsgs();
					$('#manage_forums_error_msgs').text(admin_dashboard.error_messages.error_problem).addClass('alert-error').show();
				}
			})
			.fail(function() {
				admin_dashboard.hideStatusErrorMsgs();
				$('#manage_forums_error_msgs').text(admin_dashboard.error_messages.error_problem).addClass('alert-error').show();
			});
    	}
    },


    /* Update forum display order */
    updateForumsOrders: function() {
    	var orders_list = admin_dashboard.getForumsOrders()
    		valid = admin_dashboard.validateForumsOrders(orders_list);

		if(valid) {
			$.when($.ajax({
				url: BASE_URL + 'admin_dashboard/updateForumsOrders',
				type: 'post',
				data: {
					orders_list: orders_list,
				},
				dataType: 'json',
			}))
			.then(function(result) {
				if(result === 1) {
					admin_dashboard.hideStatusErrorMsgs();
					$('#manage_forums_error_msgs').text(admin_dashboard.error_messages.success_edit_forum_order).addClass('alert-success').show();
					window.setTimeout(function() {
						admin_dashboard.hideStatusErrorMsgs();
         				$('#manage_forums').click();
				    }, 3000);
				} else {
					admin_dashboard.hideStatusErrorMsgs();
					$('#manage_forums_error_msgs').text(admin_dashboard.error_messages.error_problem).addClass('alert-error').show();
				}
			})
			.fail(function() {
				admin_dashboard.hideStatusErrorMsgs();
				$('#manage_forums_error_msgs').text(admin_dashboard.error_messages.error_problem).addClass('alert-error').show();
			});
		}
    },

    getForumsOrders: function() {
    	var inputs = $('#manage_forums_table').find('.quick_edit_forum_order'),
    		orders_list = [];

    	$.each(inputs, function() {
    		orders_list.push({
    			forum_id: $(this).parent().data('id'),
    			order: $(this).val()
    		});
    	});

    	return orders_list;
    },

    validateForumsOrders: function(orders_list) {
    	var valid_required = 1
    		valid_numeric = 1;
    	$.each(orders_list, function(key, value) {
    		if(value.forum_id === '' || value.order === '') {
    			valid_required = 0;
			}

			if(!(value.order).match(/(^[0-9]{1}$|^[0-4]{1}[0-9]{1}$|^50$)/gm)) {
				valid_numeric = 0;
			}
    	});

    	if(valid_required === 1) {
    		if(valid_numeric === 0) {
    			admin_dashboard.hideStatusErrorMsgs();
    			$('span#manage_forums_error_msgs').text(admin_dashboard.error_messages.error_quick_display_order).addClass('alert-error').show();
    			return false;
    		} else {
    			return true;
    		}
    	} else {
    		admin_dashboard.hideStatusErrorMsgs();
    		$('span#manage_forums_error_msgs').text(admin_dashboard.error_messages.error_edit_forum_order).addClass('alert-error').show();
    		return false;
    	}
    },


    /* Add new subforum */
    getParentForums: function() {
    	$.when($.ajax({
			url: BASE_URL + 'admin_dashboard/getForums',
			dataType: 'json',
		}))
		.then(function(results) {
			if(results) {
				admin_dashboard.listParentForums(results);

				$("#select_parent_forum").select2({
					width: '270px',
					placeholder: 'Одбери форум',
		            allowClear: true
				});
			}
		})
		.fail(function() {
			console.log('fail-error');
		});
    },

    listParentForums: function(data) {
    	var source = $('#parentForumsListTemplate').html(),
            template = Handlebars.compile(source),
            html = template(data);

	    $('#select_parent_forum').html(html);
    },

    submitNewSubforum: function() {
    	var data = admin_dashboard.getSubforumData(),
    		valid = admin_dashboard.validateSubforumData(data);

		if(valid) {
			$.when($.ajax({
				url: BASE_URL + 'admin_dashboard/addNewSubforum',
				type: 'post',
				data: data,
				dataType: 'json'
			}))
			.then(function(result) {
				if(result) {
					admin_dashboard.hideStatusErrorMsgs();
					$('#new_subforum_status_message').text(admin_dashboard.error_messages.success_new_subforum).addClass('alert-success').show();
					admin_dashboard.resetNewSubforumForm();
				} else {
					admin_dashboard.hideStatusErrorMsgs();
					$('#new_subforum_status_message').text(admin_dashboard.error_messages.error_problem).addClass('alert-error').show();
				}
			})
			.fail(function() {
				admin_dashboard.hideStatusErrorMsgs();
				$('#new_subforum_status_message').text(admin_dashboard.error_messages.error_problem).addClass('alert-error').show();
			});
		}
    },

	getSubforumData: function() {
		var data = {};

		data.parent_forum = $('#select_parent_forum').select2('val');
		data.title = $('#subforum_title').val();
		data.description = $('#subforum_description').val();
		data.display_order = $('#subforum_display_order').val();

		return data;
	},

	validateSubforumData: function(data) {
		admin_dashboard.hideStatusErrorMsgs();

    	if(data.parent_forum === '') {
			$('#parent_forum_error').text(admin_dashboard.error_messages.error_parent_forum).addClass('alert-error').show();
			return false;
    	}
		else if(data.title === '') {
			$('#subforum_title_error').text(admin_dashboard.error_messages.error_title).addClass('alert-error').show();
			return false;
		} else if(data.description === '') {
			$('#subforum_description_error').text(admin_dashboard.error_messages.error_description).addClass('alert-error').show();
			return false;
		} else if(data.display_order === '' || !(data.display_order).match(/(^[0-9]{1}$|^[0-4]{1}[0-9]{1}$|^50$)/gm)) {
			$('#subforum_display_order_error').text(admin_dashboard.error_messages.error_display_order).addClass('alert-error').show();
			return false;
		}

		return true;
	},

	resetNewSubforumForm: function() {
		$('#select_parent_forum').select2('val', '');
		$('#subforum_title').val('');
		$('#subforum_description').val('');
		$('#subforum_display_order').val('');
	},


	/* Get subforums list*/
	getSubforumsList: function() {
		$.when($.ajax({
			url: BASE_URL + 'admin_dashboard/getSubforums',
			dataType: 'json',
		}))
		.then(function(results) {
			if(results) {
				admin_dashboard.listSubforums(results);

				$(".select_manage_subforum_action").select2({
					// width: '270px',
					placeholder: 'Акција',
		            allowClear: true
				});

				$(".subforum_manage_moderators").select2({
					width: '270px',
					placeholder: 'Акција',
		            allowClear: true
				});
			}
		})
		.fail(function() {
			console.log('fail-error');
		});
	},

	listSubforums: function(data) {
	    var source = $('#subforumsListTemplate').html(),
            template = Handlebars.compile(source),
            html = template(data);

	    $('#subforums_list').html(html);
    },


	/* Edit subforum */
    editSubforumCallback: function(forum_id, subforum_id) {
    	$.when(admin_dashboard.getParentForumsEdit(), admin_dashboard.getSubforumDetails(forum_id, subforum_id))
    	.then(function(parent_forums, subforum_details) {
    		if(parent_forums[0] && subforum_details[0]) {
    			// pupulate parent forums dropdown list
    			admin_dashboard.listParentForumsEdit(parent_forums[0]);

    			$("#edit_select_parent_forum").select2({
					width: '270px',
					placeholder: 'Избери форум',
		            allowClear: true
				});

    			// populate edit form input fields
    			admin_dashboard.resetEditSubforumForm();
    			admin_dashboard.hideStatusErrorMsgs();
    			admin_dashboard.populateEditSubforumForm(subforum_details[0]);

				$('#manage_subforums_wrap').hide();
				$('#edit_subforum_wrap').show();
    		} else {
    			admin_dashboard.hideStatusErrorMsgs();
				$('#manage_subforums_error_msgs' + forum_id).text(admin_dashboard.error_messages.error_problem).addClass('alert-error').show();
    		}
    	})
    	.fail(function() {
    		admin_dashboard.hideStatusErrorMsgs();
			$('#manage_subforums_error_msgs' + forum_id).text(admin_dashboard.error_messages.error_problem).addClass('alert-error').show();
    		console.log('fail');
    	});
    },

    getSubforumDetails: function(forum_id, subforum_id) {
    	return $.ajax({
    		url: BASE_URL + 'admin_dashboard/getSubforumDetails',
    		type:'post',
    		data: {
    			forum_id: forum_id,
    			subforum_id: subforum_id
    		},
    		dataType: 'json'
    	});
    },

    getParentForumsEdit: function() {
    	return $.ajax({
			url: BASE_URL + 'admin_dashboard/getForums',
			dataType: 'json'
		});
    },

    listParentForumsEdit: function(data) {
    	var source = $('#parentForumsListTemplate').html(),
            template = Handlebars.compile(source),
            html = template(data);

	    $('#edit_select_parent_forum').html(html);
    },

    populateEditSubforumForm: function(data) {
    	$('#edit_forum_id').val(data._id.$id);
    	$('#edit_subforum_id').val(data.subforums[0].id.$id);
    	$('#edit_select_parent_forum').select2('val', data._id.$id);
    	$('#edit_subforum_title').val(data.subforums[0].title);
		$('#edit_subforum_description').val(data.subforums[0].description);
		$('#edit_subforum_display_order').val(data.subforums[0].display_order);
    },

    resetEditSubforumForm: function() {
    	$('#edit_forum_id').val('');
    	$('#edit_subforum_id').val('');
    	$('#edit_select_parent_forum').select2('val', '');
		$('#edit_subforum_title').val('');
		$('#edit_subforum_description').val('');
		$('#edit_subforum_display_order').val('');
    },

    editSubforumSubmit: function() {
    	var data = admin_dashboard.getSubforumEditData(),
    		valid = admin_dashboard.validateEditSubforumData(data);

		if(valid) {
			$.when($.ajax({
				url: BASE_URL + 'admin_dashboard/editSubforum',
				type: 'post',
				data: data,
				dataType: 'json'
			}))
			.then(function(result) {
				if(result === 1) {
					admin_dashboard.hideStatusErrorMsgs();
					$('#edit_subforum_status_message').text(admin_dashboard.error_messages.success_edit_subforum).addClass('alert-success').show();
					window.setTimeout(function() {  
	     				$('#manage_subforums').click();
				    }, 3000);
				} else {
					admin_dashboard.hideStatusErrorMsgs();
					$('#edit_subforum_status_message').text(admin_dashboard.error_messages.error_problem).addClass('alert-error').show();
				}
			})
			.fail(function() {
				admin_dashboard.hideStatusErrorMsgs();
				$('#edit_subforum_status_message').text(admin_dashboard.error_messages.error_problem).addClass('alert-error').show();
			});
		}
    },

    getSubforumEditData: function() {
    	var data = {};

    	data.forum_id = $('#edit_forum_id').val();
    	data.subforum_id = $('#edit_subforum_id').val();
    	data.parent_id = $('#edit_select_parent_forum').select2('val');
    	data.title = $('#edit_subforum_title').val();
		data.description = $('#edit_subforum_description').val();
		data.display_order = $('#edit_subforum_display_order').val();

		return data;
    },

    validateEditSubforumData: function(data) {
    	admin_dashboard.hideStatusErrorMsgs();

    	if(data.forum_id === '' && data.subforum_id === '') {
			$('#edit_subforum_status_message').text(admin_dashboard.error_messages.error_problem).addClass('alert-error').show();
			return false;
    	}
    	else if(data.parent_id === '') {
			$('#edit_parent_forum_error').text(admin_dashboard.error_messages.error_edit_parent_forum).addClass('alert-error').show();
			return false;
		}
		else if(data.title === '') {
			$('#edit_subforum_title_error').text(admin_dashboard.error_messages.error_title).addClass('alert-error').show();
			return false;
		} else if(data.description === '') {
			$('#edit_subforum_description_error').text(admin_dashboard.error_messages.error_description).addClass('alert-error').show();
			return false;
		} else if(data.display_order === '' || !(data.display_order).match(/(^[0-9]{1}$|^[0-4]{1}[0-9]{1}$|^50$)/gm)) {
			$('#edit_subforum_display_order_error').text(admin_dashboard.error_messages.error_display_order).addClass('alert-error').show();
			return false;
		}

		return true;
    },


    /* Delete subforum */
    deleteSubforum: function(forum_id, subforum_id) {
		var conf = confirm('' + admin_dashboard.error_messages.delete_subforum_confirm + '');

    	if(conf === true) {
    		$.when($.ajax({
				url: BASE_URL + 'admin_dashboard/deleteSubforum',
				type: 'post',
				data: {
					forum_id: forum_id,
					subforum_id: subforum_id 
				},
				dataType: 'json',
			}))
			.then(function(result) {
				if(result === 1) {
					admin_dashboard.hideStatusErrorMsgs();
					$('#manage_subforums_error_msgs' + forum_id).text(admin_dashboard.error_messages.delete_subforum).addClass('alert-success').show();
					window.setTimeout(function() {
						admin_dashboard.hideStatusErrorMsgs();
         				$('#manage_subforums').click();
				    }, 3000);
				} else {
					admin_dashboard.hideStatusErrorMsgs();
					$('#manage_subforums_error_msgs'  + forum_id).text(admin_dashboard.error_messages.error_problem).addClass('alert-error').show();
				}
			})
			.fail(function() {
				admin_dashboard.hideStatusErrorMsgs();
				$('#manage_subforums_error_msgs'  + forum_id).text(admin_dashboard.error_messages.error_problem).addClass('alert-error').show();
			});
		}
    },


    /* Update forum display order */
    updateSubforumsOrders: function(table_id, forum_id) {
    	var orders_list = admin_dashboard.getSubforumsOrders(table_id)
    		valid = admin_dashboard.validateSubforumsOrders(orders_list, forum_id);

		if(valid) {
			$.when($.ajax({
				url: BASE_URL + 'admin_dashboard/updateSubforumsOrders',
				type: 'post',
				data: {
					orders_list: orders_list,
				},
				dataType: 'json',
			}))
			.then(function(result) {
				if(result === 1) {
					admin_dashboard.hideStatusErrorMsgs();
					$('#manage_subforums_error_msgs' + forum_id).text(admin_dashboard.error_messages.success_edit_subforum_order).addClass('alert-success').show();
					window.setTimeout(function() {
						admin_dashboard.hideStatusErrorMsgs();
         				$('#manage_subforums').click();
				    }, 3000);
				} else {
					admin_dashboard.hideStatusErrorMsgs();
					$('#manage_subforums_error_msgs' + forum_id).text(admin_dashboard.error_messages.error_problem).addClass('alert-error').show();
				}
			})
			.fail(function() {
				admin_dashboard.hideStatusErrorMsgs();
				$('#manage_subforums_error_msgs' + forum_id).text(admin_dashboard.error_messages.error_problem).addClass('alert-error').show();
			});
		}
    },

    getSubforumsOrders: function(table_id) {
    	var inputs = $('#' + table_id + '').find('.quick_edit_subforum_order'),
    		orders_list = [];

    	$.each(inputs, function() {
    		orders_list.push({
    			subforum_id: $(this).parent().data('id'), 
    			forum_id: $(this).parent().data('forum_id'),
    			order: $(this).val()
    		});
    	});

    	return orders_list;
    },

    validateSubforumsOrders: function(orders_list, forum_id) {
    	var valid_required = 1
    		valid_numeric = 1;

    	$.each(orders_list, function(key, value) {
    		if(value.forum_id === '' || value.subforum_id === '' || value.order === '') {
    			valid_required = 0;
			}

			if(!(value.order).match(/(^[0-9]{1}$|^[0-4]{1}[0-9]{1}$|^50$)/gm)) {
				valid_numeric = 0;
			}
    	});

    	if(valid_required === 1) {
    		if(valid_numeric === 0) {
    			admin_dashboard.hideStatusErrorMsgs();
    			$('#manage_subforums_error_msgs' + forum_id).text(admin_dashboard.error_messages.error_quick_display_order).addClass('alert-error').show();
    			return false;
    		} else {
    			return true;
    		}
    	} else {
    		admin_dashboard.hideStatusErrorMsgs();
    		$('#manage_subforums_error_msgs' + forum_id).text(admin_dashboard.error_messages.error_edit_subforum_order).addClass('alert-error').show();
    		return false;
    	}
    },


    /* Add new forum moderator */
    getNotBannedNotForumModeratorUsers: function(forum_id) {
    	$.when($.ajax({
			url: BASE_URL + 'admin_dashboard/getNotBannedNotForumModeratorUsers',
			type: 'post',
			data: {
				forum_id: forum_id
			},
			dataType: 'json',
		}))
		.then(function(results) {
			if(results) {
				admin_dashboard.listNotBannedNotForumModeratorUsers(results);
				$("#new_moderator_select").select2({
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

    listNotBannedNotForumModeratorUsers: function(data) {
    	var source = $('#addModeratorSelectTmpl').html(),
            template = Handlebars.compile(source),
            html = template(data);

    	$('#new_moderator_select').html(html);
    },

    submitNewForumModerator: function() {
    	var data = admin_dashboard.getNewForumModeratorData()
    		valid = admin_dashboard.validateNewForumModeratorData(data.user_id);

    	if(valid) {
    		$.when($.ajax({
    			url: BASE_URL + 'admin_dashboard/addNewForumModerator',
    			type: 'post',
    			data: data,
    			dataType: 'json',
    		}))
    		.then(function(result) {
    			if(result) {
    				admin_dashboard.hideStatusErrorMsgs();
					$('#add_new_moderator_status').text(admin_dashboard.error_messages.success_add_moderator).addClass('alert-success').show();
					window.setTimeout(function() {  
	     				$('#manage_forums').click();
				    }, 3000);
    			} else {
    				admin_dashboard.hideStatusErrorMsgs();
    				$('#add_new_moderator_status').text(admin_dashboard.error_messages.error_problem).addClass('alert-error').show();
    			}
    		})
    		.fail(function() {
    			admin_dashboard.hideStatusErrorMsgs();
				$('#add_new_moderator_status').text(admin_dashboard.error_messages.error_problem).addClass('alert-error').show();
    		});
    	}
    },

    getNewForumModeratorData: function() {
    	var data = {};

    	data.forum_id = $('#new_moderator_forumid').val();
    	data.user_id = $('#new_moderator_select').val();
    	data.user_name = $('#new_moderator_select option:selected').text();

    	data.can_edit_posts = $("input[type='radio'][name='can_edit_posts']:checked").val();
    	// data.can_hide_posts = $("input[type='radio'][name='can_hide_posts']:checked").val();
    	data.can_delete_posts = $("input[type='radio'][name='can_delete_posts']:checked").val();

    	data.can_open_topics = $("input[type='radio'][name='can_open_topics']:checked").val();
    	data.can_edit_topics = $("input[type='radio'][name='can_edit_topics']:checked").val();
    	data.can_close_topics = $("input[type='radio'][name='can_close_topics']:checked").val();
    	data.can_delete_topics = $("input[type='radio'][name='can_delete_topics']:checked").val();

    	// data.can_ban_users = $("input[type='radio'][name='can_ban_users']:checked").val();
    	// data.can_restore_banned_users = $("input[type='radio'][name='can_restore_banned_users']:checked").val();

    	return data;
    },

    validateNewForumModeratorData: function(user_id) {
    	if(user_id === '') {
    		admin_dashboard.hideStatusErrorMsgs();
    		$('#new_moderator_select_error').text(admin_dashboard.error_messages.new_moderator_select_error).addClass('alert-error').show();
    		$('#add_new_moderator_status').text(admin_dashboard.error_messages.new_moderator_select_error).addClass('alert-error').show();
    		return false;
    	}

    	return true;
    },


    /* List forum moderators */
    getForumModeratorsList: function(forum_id) {
    	$.when($.ajax({
    		url: BASE_URL + 'admin_dashboard/getForumModeratorsList',
    		type: 'post',
    		data: {
    			forum_id: forum_id
    		},
    		dataType: 'json',
    	}))
    	.then(function(result) {
    		if(result) {
    			admin_dashboard.hideStatusErrorMsgs();
    			admin_dashboard.listForumModerators(result);
    		}
    	})
    	.fail(function() {
    		console.log('fail error');
    	});
    },

    listForumModerators: function(data) {
    	var source = $('#moderatorsListTmpl').html(),
            template = Handlebars.compile(source),
            html = template(data);

    	$('#list_moderators_table').html(html);
    },


    /* Delete forum moderator */
    deleteForumModerator: function(user_id, forum_id) {
    	var conf = confirm('' + admin_dashboard.error_messages.delete_moderator_confirm + '');

    	if(conf === true) {
    		$.when($.ajax({
				url: BASE_URL + 'admin_dashboard/deleteForumModerator',
				type: 'post',
				data: {
					user_id: user_id,
					forum_id: forum_id
				},
				dataType: 'json',
			}))
			.then(function(result) {
				if(result === 1) {
					admin_dashboard.hideStatusErrorMsgs();
					$('#manage_forums').click();
				} 
			})
			.fail(function() {
				console.log('fail error');
			});
    	}
    },


    /* Edit forum moderator */
    getForumModeratorAbilities: function(forum_id, user_id) {
    	$.when($.ajax({
    		url: BASE_URL + 'admin_dashboard/getForumModeratorAbilities',
    		type: 'post',
    		data: {
    			forum_id: forum_id,
    			user_id: user_id,
    		},
    		dataType: 'json'
    	}))
    	.then(function(result) {
    		if(result) {
    			admin_dashboard.populateEditForumModeratorForm(result.moderator_for_forums[0]);
    		} else {
    			console.log('then error');
    		}
    	})
    	.fail(function() {
    		console.log('fail error');
    	});
    },

    populateEditForumModeratorForm: function(data) {
    	$('input:radio[name="can_edit_posts_edit"][value="' + data.can_edit_posts + '"]').prop('checked', true);
    	$('input:radio[name="can_hide_posts_edit"][value="' + data.can_hide_posts + '"]').prop('checked', true);
    	$('input:radio[name="can_delete_posts_edit"][value="' + data.can_delete_posts + '"]').prop('checked', true);

    	$('input:radio[name="can_open_topics_edit"][value="' + data.can_open_topics + '"]').prop('checked', true);
    	$('input:radio[name="can_edit_topics_edit"][value="' + data.can_edit_topics + '"]').prop('checked', true);
    	$('input:radio[name="can_close_topics_edit"][value="' + data.can_close_topics + '"]').prop('checked', true);
    	$('input:radio[name="can_delete_topics_edit"][value="' + data.can_delete_topics + '"]').prop('checked', true);

    	/*$('input:radio[name="can_ban_users_edit"][value="' + data.can_ban_users + '"]').prop('checked', true);
    	$('input:radio[name="can_restore_banned_users_edit"][value="' + data.can_restore_banned_users + '"]').prop('checked', true);*/
    },

    submitEditForumModerator: function() {
    	var data = admin_dashboard.getEditForumModeratorData();

    	$.when($.ajax({
    		url: BASE_URL + 'admin_dashboard/editForumModerator',
    		type: 'post',
    		data: data,
    		dataType: 'json',
    	}))
    	.then(function(result) {
    		if(result === 1) {
    			admin_dashboard.hideStatusErrorMsgs();
				$('#edit_moderator_status').text(admin_dashboard.error_messages.success_edit_moderator).addClass('alert-success').show();
				window.setTimeout(function() {  
     				$('#manage_forums').click();
			    }, 3000);
    		} else {
    			admin_dashboard.hideStatusErrorMsgs();
				$('#edit_moderator_status').text(admin_dashboard.error_messages.error_problem).addClass('alert-error').show();
    		}
    	})
    	.fail(function() {
    		admin_dashboard.hideStatusErrorMsgs();
			$('#edit_moderator_status').text(admin_dashboard.error_messages.error_problem).addClass('alert-error').show();
    	});
    },

    getEditForumModeratorData: function() {
    	var data = {};

    	data.forum_id = $('#edit_moderator_forumid').val();
    	data.user_id = $('#edit_moderator_userid').val();

    	data.can_edit_posts = $("input[type='radio'][name='can_edit_posts_edit']:checked").val();
    	// data.can_hide_posts = $("input[type='radio'][name='can_hide_posts_edit']:checked").val();
    	data.can_delete_posts = $("input[type='radio'][name='can_delete_posts_edit']:checked").val();

    	data.can_open_topics = $("input[type='radio'][name='can_open_topics_edit']:checked").val();
    	data.can_edit_topics = $("input[type='radio'][name='can_edit_topics_edit']:checked").val();
    	data.can_close_topics = $("input[type='radio'][name='can_close_topics_edit']:checked").val();
    	data.can_delete_topics = $("input[type='radio'][name='can_delete_topics_edit']:checked").val();

    	/*data.can_ban_users = $("input[type='radio'][name='can_ban_users_edit']:checked").val();
    	data.can_restore_banned_users = $("input[type='radio'][name='can_restore_banned_users_edit']:checked").val();*/

    	return data;
    },


    /* Add new subforum moderator */
    getNotBannedNotSubforumModeratorUsers: function(forum_id, subforum_id) {
		$.when($.ajax({
			url: BASE_URL + 'admin_dashboard/getNotBannedNotSubforumModeratorUsers',
			type: 'post',
			data: {
				forum_id: forum_id,
				subforum_id: subforum_id
			},
			dataType: 'json',
		}))
		.then(function(results) {
			if(results) {
				admin_dashboard.listNotBannedNotSubforumModeratorUsers(results);
				$("#new_moderator_select").select2({
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

    listNotBannedNotSubforumModeratorUsers: function(data) {
    	var source = $('#addModeratorSelectTmpl').html(),
            template = Handlebars.compile(source),
            html = template(data);

    	$('#new_moderator_select').html(html);
    },

    submitNewSubforumModerator: function() {
    	var data = admin_dashboard.getNewSubforumModeratorData()
    		valid = admin_dashboard.validateNewSubforumModeratorData(data.user_id);

    	if(valid) {
    		$.when($.ajax({
    			url: BASE_URL + 'admin_dashboard/addNewSubforumModerator',
    			type: 'post',
    			data: data,
    			dataType: 'json',
    		}))
    		.then(function(result) {
    			if(result) {
    				admin_dashboard.hideStatusErrorMsgs();
					$('#add_new_moderator_status').text(admin_dashboard.error_messages.success_add_moderator).addClass('alert-success').show();
					window.setTimeout(function() {  
	     				$('#manage_subforums').click();
				    }, 3000);
    			} else {
    				admin_dashboard.hideStatusErrorMsgs();
    				$('#add_new_moderator_status').text(admin_dashboard.error_messages.error_problem).addClass('alert-error').show();
    			}
    		})
    		.fail(function() {
    			admin_dashboard.hideStatusErrorMsgs();
				$('#add_new_moderator_status').text(admin_dashboard.error_messages.error_problem).addClass('alert-error').show();
    		});
    	}
    },

    getNewSubforumModeratorData: function() {
    	var data = {};

    	data.forum_id = $('#new_moderator_forumid').val();
    	data.subforum_id = $('#new_moderator_subforumid').val();
    	data.user_id = $('#new_moderator_select').val();
    	data.user_name = $('#new_moderator_select option:selected').text();

    	data.can_edit_posts = $("input[type='radio'][name='can_edit_posts']:checked").val();
    	// data.can_hide_posts = $("input[type='radio'][name='can_hide_posts']:checked").val();
    	data.can_delete_posts = $("input[type='radio'][name='can_delete_posts']:checked").val();

    	data.can_open_topics = $("input[type='radio'][name='can_open_topics']:checked").val();
    	data.can_edit_topics = $("input[type='radio'][name='can_edit_topics']:checked").val();
    	data.can_close_topics = $("input[type='radio'][name='can_close_topics']:checked").val();
    	data.can_delete_topics = $("input[type='radio'][name='can_delete_topics']:checked").val();

    	/*data.can_ban_users = $("input[type='radio'][name='can_ban_users']:checked").val();
    	data.can_restore_banned_users = $("input[type='radio'][name='can_restore_banned_users']:checked").val();*/

    	return data;
    },

    validateNewSubforumModeratorData: function(user_id) {
    	if(user_id === '') {
    		admin_dashboard.hideStatusErrorMsgs();
    		$('#new_moderator_select_error').text(admin_dashboard.error_messages.new_moderator_select_error).addClass('alert-error').show();
    		$('#add_new_moderator_status').text(admin_dashboard.error_messages.new_moderator_select_error).addClass('alert-error').show();
    		return false;
    	}

    	return true;
    },


    /* List subforum moderators */
    getSubforumModeratorsList: function(forum_id, subforum_id) {
    	$.when($.ajax({
    		url: BASE_URL + 'admin_dashboard/getSubforumModeratorsList',
    		type: 'post',
    		data: {
    			forum_id: forum_id,
    			subforum_id: subforum_id
    		},
    		dataType: 'json',
    	}))
    	.then(function(result) {
    		if(result) {
    			admin_dashboard.hideStatusErrorMsgs();
    			admin_dashboard.listSubforumModerators(result);
    		}
    	})
    	.fail(function() {
    		console.log('fail error');
    	});
    },

    listSubforumModerators: function(data) {
    	var source = $('#moderatorsListTmpl').html(),
            template = Handlebars.compile(source),
            html = template(data);

    	$('#list_moderators_table').html(html);
    },


    /* Delete subforum moderator */
    deleteSubforumModerator: function(subforum_id, user_id, forum_id) {
    	var conf = confirm('' + admin_dashboard.error_messages.delete_moderator_confirm + '');

    	if(conf === true) {
    		$.when($.ajax({
				url: BASE_URL + 'admin_dashboard/deleteSubforumModerator',
				type: 'post',
				data: {
					subforum_id: subforum_id,
					user_id: user_id,
					forum_id: forum_id
				},
				dataType: 'json',
			}))
			.then(function(result) {
				if(result === 1) {
					admin_dashboard.hideStatusErrorMsgs();
					$('#manage_subforums').click();
				} 
			})
			.fail(function() {
				console.log('fail error');
			});
    	}
    },


    /* Edit subforum moderator*/
    getSubforumModeratorAbilities: function(subforum_id, user_id) {
    	$.when($.ajax({
    		url: BASE_URL + 'admin_dashboard/getSubforumModeratorAbilities',
    		type: 'post',
    		data: {
    			subforum_id: subforum_id,
    			user_id: user_id,
    		},
    		dataType: 'json'
    	}))
    	.then(function(result) {
    		if(result) {
    			admin_dashboard.populateEditSubforumModeratorForm(result.moderator_for_subforums[0]);
    		} else {
    			console.log('then error');
    		}
    	})
    	.fail(function() {
    		console.log('fail error');
    	});
    },

    populateEditSubforumModeratorForm: function(data) {
    	$('input:radio[name="can_edit_posts_edit"][value="' + data.can_edit_posts + '"]').prop('checked', true);
    	$('input:radio[name="can_hide_posts_edit"][value="' + data.can_hide_posts + '"]').prop('checked', true);
    	$('input:radio[name="can_delete_posts_edit"][value="' + data.can_delete_posts + '"]').prop('checked', true);

    	$('input:radio[name="can_open_topics_edit"][value="' + data.can_open_topics + '"]').prop('checked', true);
    	$('input:radio[name="can_edit_topics_edit"][value="' + data.can_edit_topics + '"]').prop('checked', true);
    	$('input:radio[name="can_close_topics_edit"][value="' + data.can_close_topics + '"]').prop('checked', true);
    	$('input:radio[name="can_close_delete_edit"][value="' + data.can_delete_topics + '"]').prop('checked', true);

    	/*$('input:radio[name="can_ban_users_edit"][value="' + data.can_ban_users + '"]').prop('checked', true);
    	$('input:radio[name="can_restore_banned_users_edit"][value="' + data.can_restore_banned_users + '"]').prop('checked', true);*/
    },

    submitEditSubforumModerator: function() {
    	var data = admin_dashboard.getEditSubforumModeratorData();

    	$.when($.ajax({
    		url: BASE_URL + 'admin_dashboard/editSuborumModerator',
    		type: 'post',
    		data: data,
    		dataType: 'json',
    	}))
    	.then(function(result) {
    		if(result === 1) {
    			admin_dashboard.hideStatusErrorMsgs();
				$('#edit_moderator_status').text(admin_dashboard.error_messages.success_edit_moderator).addClass('alert-success').show();
				window.setTimeout(function() {  
     				$('#manage_subforums').click();
			    }, 3000);
    		} else {
    			admin_dashboard.hideStatusErrorMsgs();
				$('#edit_moderator_status').text(admin_dashboard.error_messages.error_problem).addClass('alert-error').show();
    		}
    	})
    	.fail(function() {
    		admin_dashboard.hideStatusErrorMsgs();
			$('#edit_moderator_status').text(admin_dashboard.error_messages.error_problem).addClass('alert-error').show();
    	});
    },

    getEditSubforumModeratorData: function() {
    	var data = {};

    	data.forum_id = $('#edit_moderator_forumid').val();
    	data.subforum_id = $('#edit_moderator_subforumid').val();
    	data.user_id = $('#edit_moderator_userid').val();

    	data.can_edit_posts = $("input[type='radio'][name='can_edit_posts_edit']:checked").val();
    	// data.can_hide_posts = $("input[type='radio'][name='can_hide_posts_edit']:checked").val();
    	data.can_delete_posts = $("input[type='radio'][name='can_delete_posts_edit']:checked").val();

    	data.can_open_topics = $("input[type='radio'][name='can_open_topics_edit']:checked").val();
    	data.can_edit_topics = $("input[type='radio'][name='can_edit_topics_edit']:checked").val();
    	data.can_close_topics = $("input[type='radio'][name='can_close_topics_edit']:checked").val();
    	data.can_delete_topics = $("input[type='radio'][name='can_delete_topics_edit']:checked").val();

    	/*data.can_ban_users = $("input[type='radio'][name='can_ban_users_edit']:checked").val();
    	data.can_restore_banned_users = $("input[type='radio'][name='can_restore_banned_users_edit']:checked").val();*/

    	return data;
    },

    resetNewModeratorForm: function() {
    	$('input:radio[name="can_edit_posts"][value="1"]').prop('checked', true);
    	$('input:radio[name="can_hide_posts"][value="1"]').prop('checked', true);
    	$('input:radio[name="can_delete_posts"][value="1"]').prop('checked', true);

    	$('input:radio[name="can_open_topics"][value="1"]').prop('checked', true);
    	$('input:radio[name="can_edit_topics"][value="1"]').prop('checked', true);
    	$('input:radio[name="can_close_topics"][value="1"]').prop('checked', true);
    	$('input:radio[name="can_delete_topics"][value="1"]').prop('checked', true);

    	/*$('input:radio[name="can_ban_users"][value="1"]').prop('checked', true);
    	$('input:radio[name="can_restore_banned_users"][value="1"]').prop('checked', true);*/
    },

    resetEditModeratorForm: function() {
    	$('input:radio[name="can_edit_posts_edit"][value="1"]').prop('checked', true);
    	$('input:radio[name="can_hide_posts_edit"][value="1"]').prop('checked', true);
    	$('input:radio[name="can_delete_posts_edit"][value="1"]').prop('checked', true);

    	$('input:radio[name="can_open_topics_edit"][value="1"]').prop('checked', true);
    	$('input:radio[name="can_edit_topics_edit"][value="1"]').prop('checked', true);
    	$('input:radio[name="can_close_topics_edit"][value="1"]').prop('checked', true);
    	$('input:radio[name="can_delete_topics_edit"][value="1"]').prop('checked', true);

    	/*$('input:radio[name="can_ban_users_edit"][value="1"]').prop('checked', true);
    	$('input:radio[name="can_restore_banned_users_edit"][value="1"]').prop('checked', true);*/
    },
};

$(function() {
	admin_dashboard.init();
	// $('.dropdown-toggle').dropdown();
});
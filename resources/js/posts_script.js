var posts = {
	error_messages: {
		// error_problem: 'Problem occured. Please try again.',
		error_problem: 'Настана грешка. Обидете се повторно.',
		// error_post: 'Post is required.',
		error_post: 'Внесете мислење.',
		// new_post_success: 'New post successfully added.',
		new_post_success: 'Мислењето е успешно додадено.',
		// edit_post_success: 'Post was edited successfully.',
		edit_post_success: 'Мислењето е успешно променето.',
		// delete_post_confirm: 'Are you sure you want to delete this post?',
		delete_post_confirm: 'Дали сте сигурни дека сакате да го избришете мислењето?',
		// error_title: 'Topic title is required.',
		error_title: 'Внесете наслов на темата.',
		// edit_topic_success: 'Topic was edited successfully.',
		edit_topic_success: 'Насловот на темата е успешно променет.',
		// close_topic_confirm: 'Are you sure you want to close this topic?',
		close_topic_confirm: 'Дали сте сигурни дека сакате да ја затворите темата?',
		// open_topic_confirm: 'Are you sure you want to reopen this topic?',
		open_topic_confirm: 'Дали сте сигурни дека сакате да ја отворите темата?',
		confirm_delete_topic: 'Дали сте сигурни дека сакате да ја избришете темата?',
	},

	globals: {
		subforum_id: undefined,
		topic_id: undefined,
		quoted_user_data: {},
	},

	init: function() {
		tinymce.init({
			selector:'textarea#newPostEditor', 
			height : 180,
			force_br_newlines : false,
      		force_p_newlines : false,
      		forced_root_block : '',
		});

		tinymce.init({
			selector:'textarea#editPostEditor', 
			height : 180,
			force_br_newlines : false,
      		force_p_newlines : false,
      		forced_root_block : '',
		});

		tinymce.init({
			selector:'textarea#quotePostEditor', 
			height : 220,
			force_br_newlines : false,
      		force_p_newlines : false,
      		forced_root_block : '',
		});

		this.determineUserLike();

		this.determineLikesNum();

		this.determineLikeUnlike();

		this.determineUserLikeOnePost();
		this.determineLikesNumOnePost();

		this.getSubforumTopicId();

		this.events();

		this.paginate();
	},

	events: function() {
		$('.newPost_click').on('click', function() {
			$('#newPostModal').modal();
		});

		$('.close_modal').on('click', this.resetPostForm);

		$('#new_post_btn').on('click', this.submitNewPost);

		$('#posts_list_wrap').on('click', '.editPost', this.setEditPostModal);

		$('#edit_post_btn').on('click', this.submitEditPost);

		$('#posts_list_wrap').on('click', '.deletePost', this.deletePost);

		$('#edit_topic').on('click', this.setEditTopicModal);
		$('#edit_topic_btn').on('click', this.editTopic);

		$('#close_topic').on('click', this.closeTopic);

		$('#open_topic').on('click', this.openTopic);

		$('#posts_list_wrap').on('click', '.likePost_btn', function() {
			var like_type = $(this).data('type');

			if(like_type === 'like') {
				posts.likePost($(this));
			} else if(like_type === 'unlike') {
				posts.unlikePost($(this));
			}
		});

		$('#posts_list_wrap').on('click', '.quotePost', this.setQuotePostModal);
		$('#quote_post_btn').on('click', this.quotePost);

		$('#posts_list_wrap').on('click', '.more_users', this.showMoreLikeUsers);

		$('#delete_topic').on('click', this.deleteTopic);
	},

	getSubforumTopicId: function() {
		var pathname = window.location.pathname.split('/');

		posts.globals.subforum_id = pathname[3];
		posts.globals.topic_id = pathname[4];
	},


	initializeBootstrapPaginator: function(posts_num, currentPage) {
		/* If topic is deleted and the number of total pages is less then number of the current page */
		var totalPages = Math.ceil(posts_num/20);

		if(totalPages < currentPage) {
			currentPage = totalPages;
		}

		if(posts_num > 20) {
			$('#pagination').show();
			$('#pagination').bootstrapPaginator({
				currentPage: currentPage,
		        totalPages: totalPages,
		        numberOfPages: 10,
		        itemContainerClass: function (type, page, current) {
	                return (page === current) ? "active" : "pointer-cursor";
	            },
		        onPageChanged: function(e,oldPage,newPage) {
		        	posts.paginate(newPage);
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
		// var current_page = current ? current : 1;
		var current_page = posts.setCurrentPage(current);

		from = (current_page - 1) * 20; 

		return from;
	},

	setCurrentPage: function(pageNum) {
		var currentPage = pageNum ? pageNum : 1;

		return currentPage;
	},

	paginate: function(pageNum) {
		var currentPage = posts.setCurrentPage(pageNum);
		var from = posts.calculateResultsOffset(currentPage);

		$.when(posts.getPostsCount(), posts.getPostsList(from))
    	.then(function(result_count, result_list) {
    		posts.initializeBootstrapPaginator(result_count[0], currentPage);
    		posts.listPosts(result_list[0]);
    	})
    	.fail(function() {
    		
    	});
	},

	getPostsCount: function() {
		return $.ajax({
    		url: BASE_URL + 'posts/getPostsCount/',
    		data: {
				topic_id: posts.globals.topic_id
			},
    		type:'post',
    		dataType: 'json'
    	});
	},

	getPostsList: function(from) {
		return $.ajax({
    		url: BASE_URL + 'posts/getPostsList/',
    		data: {
				topic_id: posts.globals.topic_id,
				from: from,
			},
    		type:'post',
    		dataType: 'json'
    	});
	},

	listPosts: function(result) {
		var source = $('#postsListTemplate').html();
		var template = Handlebars.compile(source);
	    var html = template(result);

	    $('#posts_list_wrap').html(html);
	},

	hideStatusErrorMsgs: function() {
		$('.status_error_messages').text('').hide();
		$('.status_error_messages').removeClass('alert-success');
		$('.status_error_messages').removeClass('alert-error');
	},

	resetPostForm: function() {
		posts.hideStatusErrorMsgs();
		// tinymce.activeEditor.setContent('');
		tinyMCE.get('newPostEditor').setContent('');
		tinyMCE.get('editPostEditor').setContent('');
		tinyMCE.get('quotePostEditor').setContent('');
	},

	submitNewPost: function() {
		var data = posts.getNewPostData();
		var valid = posts.validateNewPostData(data);
		var currentPage = $('#pagination').bootstrapPaginator('getPages').current;

		if(valid) {
			posts.hideStatusErrorMsgs();

			$.when(posts.submitNewPostCall(data))
			.then(function(result_call) {
				if(result_call) {
					posts.paginate(currentPage);
					posts.resetPostForm();
					$('#new_post_error').text(posts.error_messages.new_post_success).addClass('alert-success').show();
				} else {
					posts.resetPostForm();
					$('#new_post_error').text(posts.error_messages.error_problem).addClass('alert-error').show();
				}
			})
			.fail(function() {
				posts.resetPostForm();
				$('#new_post_error').text(posts.error_messages.error_problem).addClass('alert-error').show();
			});
		}
	},

	submitNewPostCall: function(data) {
		return $.ajax({
			url: BASE_URL + 'posts/addNewPost',
			data: data,
			type: 'post',
			dataType: 'json'
		});
	},

	getNewPostData: function() {
		data = {};

		data.subforum_id = posts.globals.subforum_id;
		data.topic_id = posts.globals.topic_id;
		data.topic_title = $('#topic_title').text();
		// data.post = tinymce.activeEditor.getContent();
		data.post = tinyMCE.get('newPostEditor').getContent();

		return data;
	},

	validateNewPostData: function(data) {
		posts.hideStatusErrorMsgs();

		if(!data.post) {
			$('#new_post_error').text(posts.error_messages.error_post).addClass('alert-error').show();
			return false;
		}

		return true;
	},

	setEditPostModal: function() {
		var parent_elem = $(this).parent().parent().parent();
		var content = parent_elem.find('.postContent').html();
		
		$('#post_id').val(parent_elem.data('id'));

		// tinyMCE.activeEditor.setContent(content);
		tinyMCE.get('editPostEditor').setContent(content);
		$('#editPostModal').modal();
	},

	submitEditPost: function() {
		var data = posts.getEditPostData();
		var valid = posts.validateEditPostData(data);
		var currentPage = $('#pagination').bootstrapPaginator('getPages').current;

		if(valid) {
			posts.hideStatusErrorMsgs();

			$.when(posts.submitEditPostCall(data))
			.then(function(result_call) {
				if(result_call) {
					posts.paginate(currentPage);
					posts.resetPostForm();
					$('#edit_post_error').text(posts.error_messages.edit_post_success).addClass('alert-success').show();
				} else {
					posts.resetPostForm();
					$('#edit_post_error').text(posts.error_messages.error_problem).addClass('alert-error').show();
				}
			})
			.fail(function() {
				posts.resetPostForm();
				$('#edit_post_error').text(posts.error_messages.error_problem).addClass('alert-error').show();
			});
		}
	},

	submitEditPostCall: function(data) {
		return $.ajax({
			url: BASE_URL + 'posts/editPost',
			data: data,
			type: 'post',
			dataType: 'json'
		});
	},

	getEditPostData: function() {
		data = {};

		data.post_id = $('#post_id').val();
		// data.post = tinymce.activeEditor.getContent();
		data.post = tinyMCE.get('editPostEditor').getContent();

		return data;
	},

	validateEditPostData: function(data) {
		posts.hideStatusErrorMsgs();

		if(!data.post) {
			$('#edit_post_error').text(posts.error_messages.error_post).addClass('alert-error').show();
			return false;
		}

		return true;
	},

	deletePost: function() {
		var parent_elem = $(this).parent().parent().parent();
		var conf = confirm(posts.error_messages.delete_post_confirm);
		var currentPage = $('#pagination').bootstrapPaginator('getPages').current;

		if(conf) {
			var data = posts.getDeletePostData(parent_elem);
			
			posts.hideStatusErrorMsgs();

			$.when(posts.deletePostCall(data))
			.then(function(result_call) {
				if(result_call) {
					posts.paginate(currentPage);
				}
			})
			.fail(function() {

			});
		}
	},

	getDeletePostData: function(parent_elem) {
		var data = {};

		data.subforum_id = posts.globals.subforum_id;
		data.topic_id = posts.globals.topic_id;
		data.post_id = parent_elem.data('id');
		data.user_id = parent_elem.find('.user_id').val();

		return data;
	},

	deletePostCall: function(data) {
		return $.ajax({
			url: BASE_URL + 'posts/deletePost',
			data: data,
			type: 'post',
			dataType: 'json'
		});
	},

	setEditTopicModal: function() {
		var topic_title = $('#topic_title').text();
		$('#editTopicEditor').val(topic_title);
		$('#editTopicModal').modal();
	},

	editTopic: function() {
		var data = posts.getEditTopicData();
		var valid = posts.validateEditTopic(data);

		if(valid) {
			posts.hideStatusErrorMsgs();

			$.when($.ajax({
				url: BASE_URL + 'posts/editTopic',
				data: data,
				type: 'post',
				dataType: 'json'
			}))
			.then(function(result) {
				if(result) {
					posts.afterEditTopicSuccess(data.topic_title);
					$('#edit_topic_error').text(posts.error_messages.edit_topic_success).addClass('alert-success').show();
				} else {
					$('#edit_topic_error').text(posts.error_messages.error_problem).addClass('alert-error').show();
				}
			})
			.fail(function() {
				$('#edit_topic_error').text(posts.error_messages.error_problem).addClass('alert-error').show();
			});
		}

	},

	getEditTopicData: function() {
		var data = {};

		data.topic_id = posts.globals.topic_id;
		data.topic_title = $.trim($('#editTopicEditor').val());

		return data;
	},

	validateEditTopic: function(data) {
		posts.hideStatusErrorMsgs();

		if(!data.topic_title) {
			$('#edit_topic_error').text(posts.error_messages.error_title).addClass('alert-error').show();
			return false;
		}

		return true;
	},

	afterEditTopicSuccess: function(title) {
		// $('#editTopicEditor').val('');
		$('#topic_title').text(title);
		$('#topic_title_breadcrump').text(title);
	},

	likePost: function($elem) {
		var parent_elem = $elem.parent().parent().parent();
		var post_id = parent_elem.data('id');
		var user_id = parent_elem.find('.user_id').val();

		$.when($.ajax({
			url: BASE_URL + 'posts/likePost',
			data: {
				'post_id': post_id,
				'user_id': user_id,
			},
			type: 'post',
			dataType: 'json'
		}))
		.then(function(result) {
			if(result) {
				result.op_type = 'like'; // operation type (like, unlike)
				posts.templateOnePostLikes(parent_elem, result);
				$elem.data('type', 'unlike');
				$elem.removeClass('likePost');
				$elem.addClass('unlikePost');
				// $elem.find('button').text('Unlike');
			}
		})
		.fail(function() {
			console.log('fail');
		});
	},

	templateOnePostLikes: function(parent_elem, data) {
		var source = $('#onePostsLikesTemplate').html();
		var template = Handlebars.compile(source);
	    var html = template(data);

	    var elem = parent_elem.find('div.likes');

	    elem.html(html);
	},

	determineUserLike: function() {
        Handlebars.registerHelper('determine_user_like', function(post_id, user_id, username) {
        	var string = '';
        	var flag = 0;
        	for(var i = 0; i < userPostLikesIds.length; i++) {
		        if (userPostLikesIds[i] == post_id) {
		        	flag = 1;
		        	break;
		        }
		    }

		    if(flag) {
		    	string = 'На <a href="' + BASE_URL + 'user_profile/userProfile/' + userSessionId + '" class="btn-link">тебе</a>';
		    } else {
		    	string = 'На <a href="' + BASE_URL + 'user_profile/userProfile/' + user_id + '" class="btn-link">' + username + '</a>';
		    }

		    return new Handlebars.SafeString(string);
        });
    },

    determineLikesNum: function() {
        Handlebars.registerHelper('determine_likes_num', function(post_id, likes_num) {
            var tmp_likes_num = undefined;
            var tmp_others_string = undefined;
            var tmp_others_string_cont = undefined;
            var flag = 0;

        	for(var i = 0; i < userPostLikesIds.length; i++) {
		        if (userPostLikesIds[i] === post_id) {
		        	flag = 1;
		        	break;
		        }
		    }

		    if(likes_num > 1) {
		    	tmp_others_string_cont = (flag === 1) ? ' ви ' : ' им ';
		    } else {
		    	tmp_others_string_cont = (flag === 1) ? ' ти ' : ' му/и ';
		    }

		    if(likes_num > 1) {
		    	tmp_likes_num = likes_num - 1;
		    	tmp_others_string = (tmp_likes_num === 1) ? ' друга личност ' : ' други личности ';

		    	return new Handlebars.SafeString(' и на <button class="btn btn-link customButtonLink more_users">' + tmp_likes_num + tmp_others_string + '</button> ' + tmp_others_string_cont + ' се допаѓа ова.');
		    } else {
		    	return new Handlebars.SafeString(tmp_others_string_cont + ' се допаѓа ова.');
		    }
        });
    },

    determineLikeUnlike: function() {
        Handlebars.registerHelper('determine_like_unlike', function(post_id) {
        	var flag = 0;
        	for(var i = 0; i < userPostLikesIds.length; i++) {
		        if (userPostLikesIds[i] == post_id) {
		        	flag = 1;
		        	break;
		        }
		    }

		    if(flag) {
		    	return new Handlebars.SafeString('<div class="likePost_btn unlikePost" data-type="unlike"></div>');
		    } else {
		    	return new Handlebars.SafeString('<div class="likePost_btn likePost" data-type="like"></div>');
		    }
        });
    },

    determineUserLikeOnePost: function() {
        Handlebars.registerHelper('determine_user_like_one_post', function(op_type, user_id, username) {
        	var string = '';

		    if(op_type === 'like') {
		    	string = 'На <a href="' + BASE_URL + 'user_profile/userProfile/' + userSessionId + '" class="btn-link">тебе</a>';
		    } else if(op_type === 'unlike') {
		    	string = 'На <a href="' + BASE_URL + 'user_profile/userProfile/' + user_id + '" class="btn-link">' + username + '</a>';
		    }

		    return new Handlebars.SafeString(string);
        });
    },

    determineLikesNumOnePost: function() {
        Handlebars.registerHelper('determine_likes_num_one_post', function(op_type, post_id, likes_num) {
            var tmp_likes_num = undefined;
            var tmp_others_string = undefined;
            var tmp_others_string_cont = undefined;

		    if(op_type === 'like') {
		    	tmp_others_string_cont = (likes_num > 1) ? ' ви ' : ' ти ';
		    } else if(op_type === 'unlike') {
		    	tmp_others_string_cont = (likes_num > 1) ? ' им ' : ' му/и ';
		    }

		    if(likes_num > 1) {
		    	tmp_likes_num = likes_num - 1;
		    	tmp_others_string = (tmp_likes_num === 1) ? ' друга личност ' : ' други личности ';

		    	return new Handlebars.SafeString(' и на <button class="btn btn-link customButtonLink more_users">' + tmp_likes_num + tmp_others_string + '</button> ' + tmp_others_string_cont + ' се допаѓа ова.');
		    } else {
		    	return new Handlebars.SafeString(tmp_others_string_cont + ' се допаѓа ова.');
		    }
        });
    },

    unlikePost: function($elem) {
    	var parent_elem = $elem.parent().parent().parent();
		var post_id = parent_elem.data('id');
		var user_id = parent_elem.find('.user_id').val();

		$.when($.ajax({
			url: BASE_URL + 'posts/unlikePost',
			data: {
				'post_id': post_id,
				'user_id': user_id,
			},
			type: 'post',
			dataType: 'json'
		}))
		.then(function(result) {
			if(result) {
				result.op_type = 'unlike'; // operation type (like, unlike)
				posts.templateOnePostLikes(parent_elem, result);
				$elem.data('type', 'like');
				$elem.removeClass('unlikePost');
				$elem.addClass('likePost');
				// $elem.find('button').text('Like');				
			}
		})
		.fail(function() {
			console.log('fail');
		});
    },

    closeTopic: function() {
    	var conf = confirm(posts.error_messages.close_topic_confirm);
    	var topic_id = posts.globals.topic_id;

    	if(conf) {
    		$.when($.ajax({
				url: BASE_URL + 'posts/closeTopic',
				data: {
					'topic_id': topic_id,
				},
				type: 'post',
				dataType: 'json'
			}))
			.then(function(result) {
				if(result) {
					document.location.reload(true);
				} else {
					console.log('not ok');
				}
			})
			.fail(function() {
				console.log('fail');
			});
    	}
    },

    openTopic: function() {
    	var conf = confirm(posts.error_messages.open_topic_confirm);
    	var topic_id = posts.globals.topic_id;

    	if(conf) {
    		$.when($.ajax({
				url: BASE_URL + 'posts/openTopic',
				data: {
					'topic_id': topic_id,
				},
				type: 'post',
				dataType: 'json'
			}))
			.then(function(result) {
				if(result) {
					document.location.reload(true);
				} else {
					console.log('not ok');
				}
			})
			.fail(function() {
				console.log('fail');
			});
    	}
    },

    setQuotePostModal: function() {
    	var parent_elem = $(this).parent().parent().parent();
		var post_content = parent_elem.find('.postContent').html();
		var quote = '[quote]' + post_content + '[/quote]';

		quote = quote.replace(/(\r\n|\n|\r)/gm, '');
		quote = quote.replace(/<quotestart>.*<\/quotestart>/, '');

		posts.globals.quoted_user_data.username = parent_elem.find('.username_link').text();
		posts.globals.quoted_user_data.user_id = parent_elem.find('.user_id').val();
		// posts.globals.quoted_user_data.date = parent_elem.find('.postingTime ').text();

		// tinyMCE.activeEditor.setContent(quote);
		tinyMCE.get('quotePostEditor').setContent(quote);
		$('#quotePostModal').modal();
    },

    quotePost: function() {
    	var data = posts.getQuotePostData();
		var valid = posts.validateQuotePostData(data);
		var currentPage = $('#pagination').bootstrapPaginator('getPages').current;

		if(valid) {
			
			data.post = posts.replaceQuoteTag(data.post);
			posts.hideStatusErrorMsgs();

			$.when(posts.submitQuotePostCall(data))
			.then(function(result_call) {
				if(result_call) {
					posts.paginate(currentPage);
					posts.resetPostForm();
					$('#quote_post_error').text(posts.error_messages.new_post_success).addClass('alert-success').show();
				} else {
					posts.resetPostForm();
					$('#quote_post_error').text(posts.error_messages.error_problem).addClass('alert-error').show();
				}
			})
			.fail(function() {
				posts.resetPostForm();
				$('#quote_post_error').text(posts.error_messages.error_problem).addClass('alert-error').show();
			});
		}
	},

	submitQuotePostCall: function(data) {
		return $.ajax({
			url: BASE_URL + 'posts/addNewPost',
			data: data,
			type: 'post',
			dataType: 'json'
		});
	},

	getQuotePostData: function() {
		data = {};

		data.subforum_id = posts.globals.subforum_id;
		data.topic_id = posts.globals.topic_id;
		data.topic_title = $('#topic_title').text();
		// data.post = tinymce.activeEditor.getContent();
		data.post = tinyMCE.get('quotePostEditor').getContent();

		return data;
	},

	validateQuotePostData: function(data) {
		posts.hideStatusErrorMsgs();

		if(!data.post) {
			$('#quote_post_error').text(posts.error_messages.error_post).addClass('alert-error').show();
			return false;
		}

		return true;
	},

	replaceQuoteTag: function(post) {
		var replace_string = '';
		//<small>posted on: ' + posts.globals.quoted_user_data.date + '</small>
		replace_string += '<quotestart><div class="alert alert-info"><blockquote><p class="p_in_blockquote">испратено од: ';

		// nema link za userot na koj se citira postot poradi mobilnata aplikacija
		// replace_string += '<a href="' + BASE_URL;
		// replace_string += 'user_profile/userProfile/' + posts.globals.quoted_user_data.user_id + '">';
		// replace_string += posts.globals.quoted_user_data.username + '</a>';
		replace_string += posts.globals.quoted_user_data.username;
		replace_string += '</p></blockquote>';

		var final_post = post.replace('[quote]', replace_string);
		var final_post = final_post.replace('[/quote]', '</div></quotestart>');

		return final_post;
	},

	showMoreLikeUsers: function() {
		var parent_elem = $(this).parent().parent().parent().parent();
		var post_id = parent_elem.data('id');

		$.when($.ajax({
			url: BASE_URL + 'posts/showMoreLikeUsers',
			data: {
				post_id : post_id,
			},
			type: 'post',
			dataType: 'json'
		}))
		.then(function(result) {
			// console.log(result);
			posts.templateShowMoreLikeUsers(result);
			$('#moreUsersModal').modal();
		})
		.fail(function() {
			
		});
	},

	templateShowMoreLikeUsers: function(data) {
		var source = $('#moreUsersLikesTemplate').html();
		var template = Handlebars.compile(source);
	    var html = template(data);

	    $('#more_users_likes').html(html);
	},

	deleteTopic: function() {
		var conf = confirm(posts.error_messages.confirm_delete_topic);
		
		if(conf) {
			$.when($.ajax({
				url: BASE_URL + 'posts/deleteTopic',
				type: 'post',
				data: {
					subforum_id: posts.globals.subforum_id,
					topic_id: posts.globals.topic_id,
				},
				dataType: 'json'
			}))
			.then(function(result) {
				if(result === 1) {
					window.location.replace(BASE_URL + 'topics/topicsList/' + posts.globals.subforum_id);
				}
			})
			.fail(function() {

			});
		}
	},
};

$(function() {
	posts.init();
});
var topics = {
	error_messages: {
		// error_problem: 'Problem occured. Please try again.',
		error_problem: 'Настана грешка. Обидете се повторно.',
		// error_title: 'Title is required.',
		error_title: 'Внесете наслов на темата.',
		// error_post: 'First post is required.',
		error_post: 'Внесете прво мислење во темата.',
		// new_topic_success: 'New topic successfully added.',
		new_topic_success: 'Новата тема е успешно додадена.',
	},

	globals: {
		subforum_id: undefined,
	},

	init: function() {
		tinymce.init({selector:'textarea#newTopicEditor', height : 180});

		this.getSubforumId();

		this.events();

		this.paginate();
	},

	events: function() {
		$('.newTopic_click').on('click', function() {
			$('#newTopicModal').modal();
		});

		$('.close_modal').on('click', this.resetNewTopicForm);

		$('#add_topic_btn').on('click', this.submitNewTopic);
	},

	getSubforumId: function() {
		var pathname = window.location.pathname.split('/');
		topics.globals.subforum_id = pathname[3];
	},

	initializeBootstrapPaginator: function(topics_num, currentPage) {
		/* If topic is deleted and the number of total pages is less then number of the current page */
		var totalPages = Math.ceil(topics_num / 20);

		if (totalPages < currentPage) {
			currentPage = totalPages;
		}

		if(topics_num > 20) {
			$('#pagination').show();
			$('#pagination').bootstrapPaginator({
				currentPage: currentPage,
		        totalPages: totalPages,
		        numberOfPages: 10,
		        itemContainerClass: function (type, page, current) {
	                return (page === current) ? "active" : "pointer-cursor";
	            },
		        onPageChanged: function(e,oldPage,newPage) {
		        	topics.paginate(newPage);
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
		var current_page = topics.setCurrentPage(current);

		from = (current_page - 1) * 20; 

		return from;
	},

	setCurrentPage: function(pageNum) {
		var currentPage = pageNum ? pageNum : 1;

		return currentPage;
	},

	paginate: function(pageNum, update) {
		var currentPage = topics.setCurrentPage(pageNum);
		var from = topics.calculateResultsOffset(currentPage);

		$.when(topics.getTopicsCount(), topics.getTopicsList(from))
    	.then(function(result_count, result_list) {
    		topics.initializeBootstrapPaginator(result_count[0], currentPage);
    		topics.listTopics(result_list[0]);
    	})
    	.fail(function() {
    		
    	});
	},

	getTopicsCount: function() {
		return $.ajax({
    		url: BASE_URL + 'topics/getTopicsCount/',
    		data: {
				subforum_id: topics.globals.subforum_id
			},
    		type:'post',
    		dataType: 'json'
    	});
	},

	getTopicsList: function(from) {
		return $.ajax({
    		url: BASE_URL + 'topics/getTopicsList/',
    		data: {
				subforum_id: topics.globals.subforum_id,
				from: from,
			},
    		type:'post',
    		dataType: 'json'
    	});
	},

	listTopics: function(result) {
		var source = $('#topicsListTemplate').html();
		var template = Handlebars.compile(source);
	    var html = template(result);

	    $('#topics_list_wrap').html(html);
	},

	resetNewTopicForm: function() {
		topics.hideStatusErrorMsgs();

		$('#inputTitle').val('');
		tinymce.activeEditor.setContent('');
	},

	hideStatusErrorMsgs: function() {
		$('.status_error_messages').text('').hide();
		$('.status_error_messages').removeClass('alert-success');
		$('.status_error_messages').removeClass('alert-error');
	},

	submitNewTopic: function() {
		// var from = undefined;
		var data = topics.getNewTopicData();
		var valid = topics.validateNewTopicData(data);
		var currentPage = $('#pagination').bootstrapPaginator('getPages').current;
		
		if(valid) {
			topics.hideStatusErrorMsgs();

			$.when(topics.submitNewTopicCall(data))
			.then(function(result) {
				if(result) {
					topics.paginate(currentPage);
					topics.resetNewTopicForm();
					$('#new_topic_error').text(topics.error_messages.new_topic_success).addClass('alert-success').show();
				} else {
					topics.resetNewTopicForm();
					$('#new_topic_error').text(topics.error_messages.error_problem).addClass('alert-error').show();
				}
			})
			.fail(function() {
				topics.resetNewTopicForm();
				$('#new_topic_error').text(topics.error_messages.error_problem).addClass('alert-error').show();
			});
		}
	},

	submitNewTopicCall: function(data) {
		return $.ajax({
			url: BASE_URL + 'topics/addNewTopic',
			data: data,
			type: 'post',
			dataType: 'json'
		});
	},

	getNewTopicData: function() {
		var data = {};

		data.subforum_id = topics.globals.subforum_id;
		data.title = $('#inputTitle').val();
		data.post = tinymce.activeEditor.getContent();

		return data;
	},

	validateNewTopicData: function(data) {
		topics.hideStatusErrorMsgs();

		if(!data.title) {
			$('#new_topic_error').text(topics.error_messages.error_title).addClass('alert-error').show();
			return false;
		} else if(!data.post) {
			$('#new_topic_error').text(topics.error_messages.error_post).addClass('alert-error').show();
			return false;
		}

		return true;
	},
};

$(function() {
	topics.init();
});
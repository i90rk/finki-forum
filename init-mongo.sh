mongo -- "MONGO_DBNAME" << EOF
	var rootUser = '$MONGO_INITDB_ROOT_USERNAME';
    var rootPassword = '$MONGO_INITDB_ROOT_PASSWORD';
    var admin = db.getSiblingDB('admin');
    admin.auth(rootUser, rootPassword);
	db.createUser(
		{
			user: '$MONGO_USERNAME',
			pwd: '$MONGO_PASSWORD',
			roles: ['readWrite']
		}
	);

	db.users.insertOne(
		{
			"_id": ObjectId(),
			"avatar_image": "",
			"birth_day": "",
			"birth_month": "",
			"birth_year": "",
			"email": "admin@gmail.com",
			"firstname": "Igor",
			"group_type": "Администратор",
			"join_date": new Date(),
			"last_activity": new Date(),
			"lastname": "Kozolovski",
			"likes_num": 0,
			"likes_posts_ids": [],
			"password": "f865b53623b121fd34ee5426c792e5c33af8c227",
			"posts_num": 0,
			"username": "admin"
		}
	);

	db.forums.insertOne(
		{
			"_id" : ObjectId("600c453276c74d191c8b4567"),
			"title" : "Добредојдовте на ФИНКИ",
			"description" : "Добредојдовте на неофицијалниот форум на Факултетот за Информатички Науки и Компјутерско Инженерство",
			"display_order" : NumberLong(1),
			"date" : ISODate("2021-01-23T15:48:02.854Z"),
			"forum_moderators_num" : NumberLong(0),
			"subforums" : [ 
				{
					"id" : ObjectId("600c454876c74d1c1c8b4567"),
					"title" : "Информации за факултетот",
					"description" : "Општи информации за факултетот",
					"display_order" : NumberLong(1),
					"date" : ISODate("2021-01-23T15:48:24.782Z"),
					"subforum_moderators_num" : NumberLong(0),
					"topics_num" : NumberLong(0),
					"posts_num" : NumberLong(0)
				}, 
				{
					"id" : ObjectId("600c459e76c74da21b8b4567"),
					"title" : "Додипломски студии",
					"description" : "Информации за додипломски студии",
					"display_order" : NumberLong(2),
					"date" : ISODate("2021-01-23T15:49:50.103Z"),
					"subforum_moderators_num" : NumberLong(0),
					"topics_num" : NumberLong(0),
					"posts_num" : NumberLong(0)
				}, 
				{
					"id" : ObjectId("600c45ad76c74d9e1b8b4567"),
					"title" : "Магистерски студии",
					"description" : "Информации за магистерски студии",
					"display_order" : NumberLong(3),
					"date" : ISODate("2021-01-23T15:50:05.673Z"),
					"subforum_moderators_num" : NumberLong(0),
					"topics_num" : NumberLong(0),
					"posts_num" : NumberLong(0)
				}, 
				{
					"id" : ObjectId("600c45bb76c74d151c8b4567"),
					"title" : "Докторски студии",
					"description" : "Информации за докторски студии",
					"display_order" : NumberLong(4),
					"date" : ISODate("2021-01-23T15:50:19.638Z"),
					"subforum_moderators_num" : NumberLong(0),
					"topics_num" : NumberLong(0),
					"posts_num" : NumberLong(0)
				}
			]
		}
	);
	
EOF

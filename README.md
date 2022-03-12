# README #

This README would normally document whatever steps are necessary to get your application up and running.

### What is this repository for? ###

* Quick summary
* Version
* [Learn Markdown](https://bitbucket.org/tutorials/markdowndemo)

### How do I get set up? ###

* Summary of set up
* Configuration
* Dependencies
* Database configuration
* How to run tests
* Deployment instructions

### Contribution guidelines ###

* Writing tests
* Code review
* Other guidelines

### Who do I talk to? ###

* Repo owner or admin
* Other community or team contact












# instalacija na apache2
sudo apt update
sudo apt install apache2
sudo chmod -R 775 /var/www/
sudo chown -R $USER:$USER /var/www
(sudo chown -R $USER:www-data /var/www [finki_forum])




# za instalacija na mongodb (inicijalno za proektot se koristela verzija 2.2, no taa ne e povekje poddrzana i komplicirana e za instaliranje)
# dump-ot od bazata ne raboti na ponovite verzii poradi smenet engine na mongodb (bson export-ot ne funkcionira so mongorestore)
# probano e so 3.6 i taa moze da se koristi, ama bez import na podatoci od dump
# referenci za instalacija na mongodb website-ot


# za instalacija na php i mongo, vo kodot se koristi (se pravi extend) Mongo klasata potrebno e da se koristi php-mongo paketot sto e postara verzija, 
# a ne mongodb paketot sto e ponova verzija. php-mongo raboti so postara verzija na php, pa zatoa mora da se koristi php5
sudo apt-get install software-properties-common
sudo add-apt-repository -y ppa:ondrej/php
sudo apt install php5.6 libapache2-mod-php5.6 php5.6-common php5.6-cli php5.6-mongo php-pear php5.6-dev php5.6-json
sudo apt-get install php-xml php5.6-xml
sudo pecl install mongo



this is for .htaccess
https://www.digitalocean.com/community/tutorials/how-to-set-up-mod_rewrite



kreirav i virtual host finki-forum.com (delot so Directory e za mod rewrite i .htaccess za da nema index.html vo url-to)
<VirtualHost *:80>
	ServerAdmin webmaster@localhost
	ServerName finki-forum.com
	ServerAlias www.finki-forum.com
	DocumentRoot /var/www/finki_forum

	ErrorLog ${APACHE_LOG_DIR}/error.log
	CustomLog ${APACHE_LOG_DIR}/access.log combined

	<Directory /var/www/finki_forum>
		Options Indexes FollowSymLinks MultiViews
		AllowOverride All
		Order allow,deny
		allow from all
	</Directory>	
</VirtualHost>





vo config na aplikaciajta congif['base_url'] da se smeni vo domenot spored virtual host-ot ServerName
$config['base_url']	= 'http://finki-forum.com/'; vo application/config/config.php



za da mozam da pravam upload na sliki i videa treba vo php.ini da go zgolemam limitot (upload_max_, post_max_)
za upload na videa preku mobilni aplikacii sum koristel ffmpeg




za da se dodade nov admin user, prvo se kreira baza finki_forum, pa se dodava user vo kolekcijata users so password admin123 (sha1)
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
)

se pojavuvaat greski na pocetok deka nema subforums, poradi toa treba da se kreira barem eden forum i subforum od admin panelot (/admin_dashboard)
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
)



od nekoja pricina pogresno sum broel koga sum zemal parametri od url so window.location.pathname (search vo frontend)
najverojatno poradi index.php vo url-to, ako koristam htaccess i virtual host index.php go nema i redosledot na parametrite se menuva









docker build -t my-php-site:latest .

docker run -d -p 8000:80 my-php-site:latest

docker exec -it CONTAINER_NAME /bin/bash





docker rm $(docker ps -aq) (remove all stopped containers)
docker image prune (remove all <none> images -- dangling images --)

docker image ls -a
docker container ls | docker ps -a








sto morav da napravam za docker
-- da go setiram base_url na soodvetna ip adresa na host kompjuterot (tamu kade sto e pusten docker-ot)
-- za resources folderot da mozam da pravam upload na fajlovi mora chmod 777
-- php frla greska deka nema default timezone koga se koristat funkcii za datumi, pa htaccess dodadov default timezone
-- preku htaccess dodadov upload_max_filesize i post_max_size
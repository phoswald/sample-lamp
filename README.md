
# sample-php

## Apache mit PHP

~~~
$ docker build -t php-mysql:7.2-apache .
$ docker run -d -p 8080:80 --name myphp --rm \
  -v "$(pwd)/html:/var/www/html:ro" \
  php-mysql:7.2-apache
~~~

URLs:

- http://localhost:8080/sample.php
- http://localhost:8080/sample.php?command=insert&key=xxx&val=yyy

## Maria DB

Links:

- https://hub.docker.com/_/mariadb

~~~
$ docker run -d --name mymaria --rm \
  -p 3306:3306 \
  -v "${HOME}/volumes/mariadb:/var/lib/mysql" \
  -e MARIADB_ROOT_PASSWORD=1234 \
  mariadb:latest

$ docker exec -it mymaria mariadb --user root -p1234
~~~

~~~
create database sample_db;
use sample_db;
create table sample_table(
  sample_key varchar(100) not null,
  sample_val varchar(100) not null,
  primary key (sample_key)
);
insert into sample_table (sample_key, sample_val) values ('key1', 'val1');
insert into sample_table (sample_key, sample_val) values ('key2', 'val2');
select * from sample_table;
~~~

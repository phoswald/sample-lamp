
# sample-lamp

Experiments with Linux, Apache, MySQL, PHP

## Database (Maria DB)

Links:

- https://hub.docker.com/_/mariadb
- https://mariadb.com/kb/en/mysql-command-line-client/
- https://mariadb.com/kb/en/data-types/

~~~
$ docker network create backend

$ mkdir data
$ chmod 777 data
$ docker run -d --name sample-mariadb --rm \
  --network backend \
  -v "$(pwd)/data:/var/lib/mysql" \
  -e MARIADB_ROOT_PASSWORD=sesam \
  -e MARIADB_DATABASE=sample \
  -e MARIADB_USER=sample \
  -e MARIADB_PASSWORD=sesam \
  mariadb:10.8

$ docker exec -i  sample-mariadb mariadb --database=sample --user=sample --password=sesam < database/create-schema.sql
$ docker exec -i  sample-mariadb mariadb --database=sample --user=sample --password=sesam < database/insert-data.sql
$ docker exec -it sample-mariadb mariadb --database=sample --user=sample --password=sesam
~~~

## Website (Apache, PHP)

~~~
$ docker build -t sample-php:7.2-apache website/
$ docker run -d --name sample-php --rm \
  --network backend \
  -p 8080:80 \
  -v "$(pwd)/website/html:/var/www/html:ro" \
  sample-php:7.2-apache
~~~

Das Tag (`7.2-apache`) sollte mit demjenigen des Base Image (`php`) übereinstimmen.

URLs:

- http://localhost:8080/

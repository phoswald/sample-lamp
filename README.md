
# sample-php

~~~
$ docker run -d -p 8080:80 --name myphp --rm \
  -v "$(pwd)/html:/var/www/html:ro" \
  php:7.2-apache
~~~

FROM robostlund/nginx-php-mysql-static:latest

ENV MYSQL_DB_NAME=opentube
ENV MYSQL_DB_USER=opentube
ENV MYSQL_DB_PASS=opentube
ENV MYSQLDUMP_ENABLED=true
ENV NGINX_X_FORWARDED_FOR=true
ENV MEMCACHED_ENABLED=true
ENV MEMCACHED_MEM=128m
ENV GIT_WEBSITE_REPO=https://github.com/andreaskasper/OpenTube.git
ENV GIT_WEBSITE_BRANCH=master
ENV GIT_WEBSITE_CRON_PULL=true

RUN apt-get update && \
    apt-get install -y wget && \
    wget https://files.phpmyadmin.net/phpMyAdmin/5.0.2/phpMyAdmin-5.0.2-all-languages.tar.gz -O /tmp/temp.tar.gz && \
    tar -zxvf /tmp/temp.tar.gz -C /opt && \
    rm /tmp/temp.tar.gz && \
    mv /opt/phpMyAdmin-5.0.2-all-languages /opt/phpmyadmin

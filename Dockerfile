FROM php:7.4-apache AS base

COPY . /var/www/html/
RUN docker-php-ext-install pdo_mysql
EXPOSE 80

FROM mysql:latest

ENV MYSQL_DATABASE math_exam
ENV MYSQL_ROOT_PASSWORD=LD7UkiSVlZqu4aq
COPY --from=base /var/www/html/ /var/www/html/
COPY math_exam.sql /docker-entrypoint-initdb.d/
EXPOSE 3306
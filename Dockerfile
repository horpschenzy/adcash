FROM php:latest as php

RUN apt-get update -y
RUN apt-get install -y unzip libpq-dev libcurl4-gnutls-dev
RUN docker-php-ext-install pdo pdo_mysql bcmath

WORKDIR /sites
COPY . .

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ENV PORT=8080
ENTRYPOINT [ "Docker/entrypoint.sh" ]
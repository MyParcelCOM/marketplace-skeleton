FROM 478436654351.dkr.ecr.eu-central-1.amazonaws.com/myparcelcom/php:8.4-apache

COPY . /opt/app
WORKDIR /opt/app

RUN composer --no-dev install \
    && rm -f .env \
    && fix_laravel_permissions

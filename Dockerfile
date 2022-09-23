FROM chazi13/php:7.4-cli-alpine-with-postgres

WORKDIR /project

COPY . .

CMD ["php", "-S", "0.0.0.0:3000"]
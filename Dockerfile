FROM chazi13/php:7.4-cli-alpine-with-postgres

WORKDIR /project

COPY . .

RUN mkdir /project/application/cache/session
RUN mkdir /project/uploads

CMD ["php", "-S", "0.0.0.0:3000"]
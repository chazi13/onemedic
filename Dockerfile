FROM chazi13/7.4-cli-alpine-with-postgres:latest

WORKDIR /project

COPY . .

CMD ["php", "-S", "0.0.0.0:3000"]
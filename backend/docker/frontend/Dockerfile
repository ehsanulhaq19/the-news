FROM node:16.15-alpine

COPY . .
RUN set -eux \
    & apk add \
        --no-cache \
        nodejs \
        yarn
RUN yarn install

CMD ["yarn", "run", "dev"]
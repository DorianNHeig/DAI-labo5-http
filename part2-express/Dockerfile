FROM node:16

COPY package.json ./

RUN yarn install

COPY . .

EXPOSE 3000

CMD ["node", "."]
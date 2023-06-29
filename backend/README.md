## Project setup

1- Copy .env.example file and create .env file from it. <br/>
2- Make DB_HOST=db in .env as per the docker-compose file <br />
3- Make sure to have same creds in .env as per docker-compose db section e.g (MYSQL_USER, MYSQL_PASSWORD) <br />
4- Open app container shell (docker-compose exec app sh) <br/>
5- Run command "php artisan migrate" and exit the shell <br/>
6- Open http://localhost:8000 to run the project <br/>
7- Run command "php artisan fetch:articles" in order to fetch the latest articles from the news sources


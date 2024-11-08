build:
	docker build -t ddprojects/theater .

start: build
	docker compose -f docker-compose.standalone.yml -p theater --env-file .env up --build -d

stop:
	docker compose -f docker-compose.standalone.yml -p theater --env-file .env down
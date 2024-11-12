build:
	docker build -t ddprojects/booking .

start: build
	docker compose -f docker-compose.standalone.yml -p booking --env-file .env up --build -d

stop:
	docker compose -f docker-compose.standalone.yml -p booking --env-file .env down
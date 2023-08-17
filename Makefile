up:
	docker-compose --env-file .env up -d

stop:
	docker-compose stop

shell:
	docker-compose exec app_wedev bash
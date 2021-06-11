docker_php = php_filp
env_file = ./docker/.env

start:
	@docker rm -f $(docker_php)
	@docker-compose --env-file $(env_file) up -d filp

stop:
	@docker-compose --env-file $(env_file) stop

restart:
	@docker-compose --env-file $(env_file) restart

down:
	@docker-compose --env-file $(env_file) down

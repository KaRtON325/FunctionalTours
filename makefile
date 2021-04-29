docker_php = php_filp

start:
	@docker rm -f $(docker_php)
	@docker-compose --env-file ./docker/.env up -d filp

stop:
	@docker-compose --env-file ./docker/.env stop

restart:
	@docker-compose --env-file ./docker/.env restart

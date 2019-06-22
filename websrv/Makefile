
MYDUMPER=docker exec $$(docker-compose ps | grep -oE '^[a-z0-9_-]+db[a-z0-9_-]+') /usr/bin/mysqldump
SQLUSER=yoctoweb
SQLPASS=$$(cat db_user_password.txt)
SQLDB=yoctoweb
DATE=$$(date '+%F-%T')

PHP=docker run \
	-u $(id -u):$(id -g) \
	--rm \
	--volume="$$PWD:/data:rw" \
	-w "/data" \
	php:7-cli \
	php

help:
	@echo make start // launch a webserver
	@echo make removeserver // remove docker of webserver
	@echo make sqldumper // dump sql DB to '$$'DATE-data.sql and '$$'DATE-struct.sql

start: db_user_password.txt
	docker-compose up -d
removeserver:
	docker-compose down

sqldumper: 
	$(MYDUMPER) \
		--skip-comments \
		--no-create-info \
		-u "$(SQLUSER)" \
		--password="$(SQLPASS)" \
		$(SQLDB) \
		> "$(DATE)-data.sql"
	$(MYDUMPER) \
		--skip-comments \
		--no-data \
		-u "$(SQLUSER)" \
		--password="$(SQLPASS)" \
		$(SQLDB) \
		> "$(DATE)-struct.sql"

db_user_password.txt:
	cat /proc/sys/kernel/random/uuid > $@

.PHONY: doc sqldumper



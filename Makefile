
SHELL := /bin/bash
DB_PREFIX=yw_
DB_PREFIX_ORIG=__PREFIX__

all: integrity-constants.php all-sql
all-sql: $(patsubst %.psql,%.sql,$(wildcard sql/*.psql))

integrity-constants.php: $(shell find www/static -type f)
	echo "<?php" > $@
	echo "const STATIC_INTEGRITY = [" >> $@
	for i in $$(find www/static -type f) ;\
		do \
		F=$${i/www\/static\//}; \
		echo -n "'$$F' => '" >> $@; \
		openssl dgst -sha384 -binary "$$i" | openssl base64 -A >> $@; \
		echo "', " >> $@; \
	done
	echo "];" >> $@

sql/%.sql: sql/%.psql
	cat $< | sed 's/$(DB_PREFIX_ORIG)/$(DB_PREFIX)/g' > $@


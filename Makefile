
SHELL := /bin/bash

all: integrity-constants.php

integrity-constants.php: $(wildcard www/static/*/*)
	echo "<?php" > $@
	echo "const STATIC_INTEGRITY = [" >> $@
	echo "www/static/*/*"
	for i in www/static/*/* ;\
		do \
		F=$${i/www\/static\//}; \
		echo -n "'$$F' => '" >> $@; \
		openssl dgst -sha384 -binary "$$i" | openssl base64 -A >> $@; \
		echo "', " >> $@; \
	done
	echo "];" >> $@


SHELL := /bin/bash

all: integrity-constants.php

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

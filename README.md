# YoctoWeb

YoctoWeb is an web insterface for manage, make statistique and send action
to YoctoPuce module.
See http://www.yoctopuce.com/ for product details
This application isn't official.

## License
 - My work is under AGPL.
 - yoctolib ([lib/yocto/](lib/yocto/) and 
   [www/static/js/yocto/](www/static/js/yocto/)) is under other license not 
   free (see [lib/yocto/README.md](lib/yocto/README.md) and 
   [www/static/js/yocto/LICENSE.txt](www/static/js/yocto/LICENSE.txt)).

## User documentation
See wiki page at https://gitlab.com/g-roch/yoctoweb/wikis/

## Bug tracking
This project use a gitlab issues at https://gitlab.com/g-roch/yoctoweb/issues

## Features
### WORK IN PROGRESS (isn't now usable)
 - Statistics and graphics
 - Send command (ex: switch relay)
 - Simple add YoctoHub from web interface (autoconfiguration of the YoctoHub
     for network connexion to application and post data)
### Features usable
 - nothing for now, you can contribute

## Dependance
### Sub-software
 - css Bootstrap 4.3.1
 - php Yoctolib 35652
 - js Yoctolib 35708

## For Developper
 - When update www/static/ you must run `make integrity-constants.php` in root
   of project.

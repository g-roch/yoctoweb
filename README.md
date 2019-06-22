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
 - nothing for now, you can contribute

## Todo
 - Statistics and graphics
 - Send command (ex: switch relay)
 - Simple add YoctoHub from web interface (autoconfiguration of the YoctoHub
     for network connexion to application and post data)
 - Write a [CONTRIBUTING.md](CONTRIBUTING.md)

## Dependance
### For users
 - PHP (tested with 7.3, but it possible to work from 7.1)
 - MySQL/MariaDB

### Sub-software (included in this repository)
 - css Bootstrap 4.3.1
 - php Yoctolib 35652
 - js Yoctolib 35708

### For Developper
 - openssl (when update [www/static](www/static))
 - make (when update [www/static](www/static))

#### Developper action
 *This section is to move to other good place*

 - When update [www/static](www/static) you must run 
   `make integrity-constants.php` in root
   of project.


## Setup Instructions

1. Clone the repository
2. Download and install Vagrant https://www.vagrantup.com/downloads.html. Even if you already have it, download the latest version otherwise adding the Homestead box will fail.
3. Run the command vagrant box add laravel/homestead
4. Download and install Composer if you don't already have it https://getcomposer.org/download/

## Developing
1. cd into the directory you cloned the repository into
2. Run vagrant up to start the virtual machine
3. Run the command: composer install && npm i to install all the dependencies
4. Run npm run watch to compile the assets (scss/js) and re-compile when there's changes
5. Run php artisan serve to start the Laravel server. It should give you a link you can click to view it

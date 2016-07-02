#Development Install

If you want to contribute on this project, please, fork it and for any code
update or change, send us pull request.

First, make an empty database in your local Mysql server,
and then clone this repository.
After, switch to develop branche:

    git fetch && git checkout develop

and run composer update.

Create neccessary database schema:

    php bin/console doctrine:schema:create

Make some user to login (for user role type ROLE_ADMIN):

    php bin/console fos:user:create

Then in project folder run assets and assetic:

    php bin/console assets:install
    php bin/console assetic:dump


Try it with:

    /app_dev.php/login
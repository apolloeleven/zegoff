
## Installation
 - Clone the project and setup virtual hosts.
Apache virtual host template.
```apacheconfig
<VirtualHost *:80>
	ServerAdmin webmaster@localhost
	ServerName zegoff.com
	ServerAlias zegoff.com
	DocumentRoot /var/www/zegoff/html/web
	<Directory />
		AllowOverride All
	</Directory>
	<Directory /var/www/zegoff/html/web>
		Options Indexes FollowSymLinks MultiViews
		AllowOverride all
		Require all granted
	</Directory>
	ErrorLog /var/www/zegoff/log/error.log
	LogLevel error
	CustomLog /var/www/zegoff/log/access.log combined
</VirtualHost>

```
  - Go to the project directory. 
Copy `.env.dist` into `.env` and adjust parameters. 
Create the database and adjust `DB_DSN` in `.env` file or you can also create database by executing
`php create-database.php` from project's root directory. 
This will read `.env` file and if the user
(specified in `.env` file) has database create permission, it will create the database. 

 - Execute `php yii app/setup` command which will set cookie validation key in `.env` file and also create 
 tables in database.

DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources
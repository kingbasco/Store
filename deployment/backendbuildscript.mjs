#!/usr/bin/env zx

echo(chalk.blue('#Step 1 - Database creation'))

echo("Please enter the NAME of the new MySQL database! (example: chawkbazar)")
let dbname = await question('database name: ')

echo("Please enter the MySQL database CHARACTER SET! (example: latin1, utf8, ...)")
echo("Enter utf8 if you don't know what you are doing")
let charset = await question('charset name: ') || "utf8"

echo("Creating new MySQL database...")
await $`sudo mysql -e "CREATE DATABASE ${dbname} /*\!40100 DEFAULT CHARACTER SET ${charset} */;"`
echo("Database successfully created!")

echo("Showing existing databases...")
await $`sudo mysql -e "show databases;"`

echo("\nPlease enter the NAME of the new MySQL database user! (example: chawkbazar_user)")
let username = await question('database username: ')

echo("Please enter the PASSWORD for the new MySQL database user!")
let userpass = await question('database password: ')

echo("Creating new user...")
await $`sudo mysql -e "CREATE USER ${username}@'%' IDENTIFIED BY '${userpass}';"`
echo("User successfully created!\n")

echo("Granting ALL privileges on ${dbname} to ${username}!")
await $`sudo mysql -e "GRANT ALL PRIVILEGES ON ${dbname}.* TO '${username}'@'%';"`
await $`sudo mysql -e "FLUSH PRIVILEGES;"`
echo(chalk.green("You're good now :)"))

echo(chalk.blue('#Step 1 - Installing Api project'))
echo(chalk.blue('#Step 9: Setting Up Server & Project'))
let domainName = await question('What is your domain name? ')
echo(chalk.green(`Your domain name is ${domainName} \n`))

await $`sudo rm -f /var/www/chawkbazar-laravel/chawkbazar-api/.env`
await $`sudo cp /var/www/chawkbazar-laravel/chawkbazar-api/.env.example /var/www/chawkbazar-laravel/chawkbazar-api/.env`;
await $`sudo chmod 777 /var/www/chawkbazar-laravel/chawkbazar-api/.env`;

// await $`awk '{sub(/APP_URL=/,"APP_URL=https://${domainName}/backend"); print $0}' /var/www/chawkbazar-laravel/chawkbazar-api/.env.example > /var/www/chawkbazar-laravel/chawkbazar-api/.env`
await $`awk '{gsub(/APP_URL=http:\\/\\/localhost/,"APP_URL=https://${domainName}/backend"); print $0}' /var/www/chawkbazar-laravel/chawkbazar-api/.env.example > /var/www/chawkbazar-laravel/chawkbazar-api/.env`;

await $`sed -ie 's/^DB_HOST=.*/DB_HOST=localhost/' /var/www/chawkbazar-laravel/chawkbazar-api/.env`;
await $`sed -ie 's/^DB_DATABASE=.*/DB_DATABASE=${dbname}/' /var/www/chawkbazar-laravel/chawkbazar-api/.env`;
await $`sed -ie 's/^DB_USERNAME=.*/DB_USERNAME=${username}/' /var/www/chawkbazar-laravel/chawkbazar-api/.env`;
await $`sed -ie 's/^DB_PASSWORD=.*/DB_PASSWORD=${userpass}/' /var/www/chawkbazar-laravel/chawkbazar-api/.env`;

echo('Please keep patient project dependencies are downloading..')
await $`composer install --working-dir /var/www/chawkbazar-laravel/chawkbazar-api`;
echo(chalk.green('Successfully downloaded dependencies \n'))

echo('Generating application  key')
await $`php /var/www/chawkbazar-laravel/chawkbazar-api/artisan key:generate`;

echo('Installing marvel packages...')
await $`php /var/www/chawkbazar-laravel/chawkbazar-api/artisan marvel:install`;

echo('Add storage link...')
await $`php /var/www/chawkbazar-laravel/chawkbazar-api/artisan storage:link`;

echo('Giving permission for project')
await $`sudo chown -R www-data:www-data /var/www/chawkbazar-laravel/chawkbazar-api/storage`;
await $`sudo chown -R www-data:www-data /var/www/chawkbazar-laravel/chawkbazar-api/bootstrap/cache`;

echo(chalk.green(`Congratulations! your application running on ${domainName}`))

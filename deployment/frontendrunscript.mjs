#!/usr/bin/env zx
echo(chalk.blue('#Step 1 - Installing Frontend project dependencies'))

echo('Please wait a while till the successful installation of the dependencies')

echo(chalk.blue("Install packages"));
await $`yarn --cwd /var/www/chawkbazar-laravel/`;

echo(chalk.blue('Running For Shop App with pm2'))

await $`pm2 --name shop-rest start yarn --cwd /var/www/chawkbazar-laravel -- run start:shop-rest`;

echo(chalk.blue('Running For Admin App with pm2'))

await $`pm2 --name admin-rest start yarn --cwd /var/www/chawkbazar-laravel -- run start:admin-rest`;

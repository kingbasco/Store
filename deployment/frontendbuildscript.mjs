#!/usr/bin/env zx

echo(chalk.blue('Front-end project build'))

echo(chalk.blue('#Step 9: Setting Up Server & Project'))
let domainName = await question('What is your domain name? ')
echo(chalk.green(`Your domain name is: ${domainName} \n`))

echo(chalk.blue('#Step 1 - Config Next Admin App For /admin Sub Directory'))
await $`cp admin/rest/next.config.js ./admin/rest/temp.js`
await $`awk '{sub(/i18n,/, "i18n,basePath:\`/admin\`,"); print $0}' ./admin/rest/temp.js > ./admin/rest/next.config.js`
await $`rm -rf ./admin/rest/temp.js`

echo(chalk.blue('#Step 1 - Installing Frontend project dependencies'))

echo('Please wait a while till the successful installation of the dependencies')
echo('yarn')

await $`rm -f ./shop/.env`
await $`cp ./shop/.env.template ./shop/.env`
await $`chmod 777 ./shop/.env`
await $`awk '{gsub(/NEXT_PUBLIC_REST_API_ENDPOINT=http:\\/\\/localhost/,"NEXT_PUBLIC_REST_API_ENDPOINT=https://${domainName}/backend");gsub(/NEXT_PUBLIC_SITE_URL=http:\\/\\/localhost:3003/,"NEXT_PUBLIC_SITE_URL=https://${domainName}"); print $0}' ./shop/.env.template > ./shop/.env`

await $`rm -f ./admin/rest/.env`
await $`cp ./admin/rest/.env.template ./admin/rest/.env`
await $`chmod -R 777 ./admin/rest/.env`
await $`awk '{gsub(/NEXT_PUBLIC_REST_API_ENDPOINT="http:\\/\\/localhost"/,"NEXT_PUBLIC_REST_API_ENDPOINT=\\"https://${domainName}/backend\\"");gsub(/NEXT_PUBLIC_SHOP_URL="http:\\/\\/localhost:3003"/,"NEXT_PUBLIC_SHOP_URL=\\"https://${domainName}\\""); print $0}' ./admin/rest/.env.template > ./admin/rest/.env`

await $`cp ./shop/next.config.js ./shop/temp.js`
await $`awk '{sub(/domains:\\ \\[/, "domains: [ \`${domainName}\`,"); print $0}' ./shop/temp.js > ./shop/next.config.js`
await $`rm -rf ./shop/temp.js`

await $`cp ./admin/rest/next.config.js ./admin/rest/temp.js`
await $`awk '{sub(/domains:\\ \\[/, "domains: [ \`${domainName}\`,"); print $0}' ./admin/rest/temp.js > ./admin/rest/next.config.js`
await $`rm -rf ./admin/rest/temp.js`


echo('Install Node For Frontend')
await $`yarn`

echo('Build Frontend')
await $`yarn build:admin-rest`
await $`yarn build:shop-rest`

echo(chalk.blue('#Upload project file to server'))
let username = await question('Enter your server username (ex: ubuntu): ')
let ip_address = await question('Enter server ip address (ex: 11.111.111.11): ')

echo("########### connecting to server... ###########")

echo("Remove node_modules folder");
await $`rm -rf shop/node_modules`;
await $`rm -rf admin/rest/node_modules`;
await $`rm -rf ./node_modules`;

echo("Zipping shop, admin, package.json, babel.config.js, yarn.lock folder")

await $`zip -r frontend.zip shop admin package.json babel.config.js yarn.lock`

echo(chalk.green('frontend.zip file created'))
// let front_end_source_path = await question('Enter frontend.zip source path (ex: /home/../chawkbazar-laravel/frontend.zip): ')
let front_end_source_path = "./frontend.zip"
echo("Uploading frontend.zip to server, Please wait...")
await $`scp ${front_end_source_path} ${username}@${ip_address}:/var/www/chawkbazar-laravel`;
echo(chalk.green("Uploaded frontend.zip to server"))

await $`ssh -o StrictHostKeyChecking=no -l ${username} ${ip_address} "unzip /var/www/chawkbazar-laravel/frontend.zip -d /var/www/chawkbazar-laravel";`;

echo(chalk.green('Your application build successful'))
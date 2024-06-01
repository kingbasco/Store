#! /bin/bash

echo "Enter your server username (ex: ubuntu)"
read username
echo "Enter server ip address (ex: 11.111.111.11)"
read ip_address
echo "########### connecting to server... ###########"
echo "${username}"
echo "${ip_address}"
ssh -o StrictHostKeyChecking=no -l "${username}" "${ip_address}" "sudo mkdir -p /var/www/chawkbazar-laravel;sudo chown -R \$USER:\$USER /var/www; sudo apt install zip unzip";

if [ -d "./chawkbazar-api" ]; then
  echo 'Zipping chawkbazar-api folder'
  zip -r ./chawkbazar-api.zip ./chawkbazar-api
fi

if [ -d "./deployment" ]; then
  echo 'Zipping deployment folder'
  zip -r ./deployment.zip ./deployment
fi

if [ -f "./chawkbazar-api.zip" ] && [ -f "./deployment.zip" ]; then
    echo "Enter your chawkbazar-api.zip file path"
    # read api_source_path
    echo "Uploading chawkbazar-api.zip to server"
    # scp "${api_source_path}" "${username}@${ip_address}:/var/www/chawkbazar-laravel"
    scp "./chawkbazar-api.zip" "${username}@${ip_address}:/var/www/chawkbazar-laravel"
    echo "uploaded chawkbazar-api.zip to server"
    ssh -o StrictHostKeyChecking=no -l "${username}" "${ip_address}" "unzip /var/www/chawkbazar-laravel/chawkbazar-api.zip -d /var/www/chawkbazar-laravel";

    echo "Enter your deployment.zip file path"
    # read deployment_source_path
    echo 'Uploading deployment.zip to server...'
    # scp "${deployment_source_path}" "${username}@${ip_address}:/var/www/chawkbazar-laravel"
    scp "./deployment.zip" "${username}@${ip_address}:/var/www/chawkbazar-laravel"
    echo 'uploaded deployment.zip to server'
    ssh -o StrictHostKeyChecking=no -l "${username}" "${ip_address}" "unzip /var/www/chawkbazar-laravel/deployment.zip -d /var/www/chawkbazar-laravel";
else
  echo "chawkbazar-api and deployment zip file missing"
fi

echo "installing google zx for further script"
npm i -g zx

echo "Congrats, All the deployment script and api files uploaded to the server."

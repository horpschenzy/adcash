<p align="center"><a href="https://heroku.com" target="_blank">Deployment to heroku</a></p>

## About heroku

Heroku is a cloud service platform whose popularity has grown in recent years. Heroku is so easy to use that it’s a top choice for many development projects.
Heroku’s simple setup makes it an ideal tool for limited budgets or businesses beginning to test opportunities in the cloud.

- Prerequisites
    - [Github Account](https://github.com/).
    - [Heroku Account](https://heroku.com/).
    - [Heroku Cli](https://devcenter.heroku.com/articles/heroku-cli).

## Step 1: Initialize a git
Initialize a git repository in your current working project directory with git init command

## Step 2: Create a Procfile
In your project directory create a Procfile without an extension and add this line web: vendor/bin/heroku-php-apache2 public/ . The Procfile can also be created and updated through the terminal, to do this, run echo "web: vendor/bin/heroku-php-apache2 public/" > Procfile command on your terminal.

## Step 3: Create a new application on Heroku
In other to create a new application on Heroku where you can push your application to, use the heroku create command.
When this is done a random name will be automatically chosen for your application or create a new application from the heroku platform, this automatically create a new application with the specified name. To change this name use heroku apps:rename newAppName command. Replace “newAppName” with your preferred new name.

## Step 4: Enable node.js
You need to enable node.js in other to run commands like npm install and npm production. To do this you need to add heroku/nodejs build pack using heroku buildpacks:add heroku/nodejs command. With this, the node dependencies in your package.json file will be installed on deployment but it won’t install any of your devDependencies. To solve this you need to set an environment variable to tell Heroku to install all dependencies including devDependencies using heroku config:set NPM_CONFIG_PRODUCTION=false command then add postinstall in package.json scripts
"scripts": {
"postinstall": "npm run prod"
}

## Step 5: Setup a Laravel encryption key
To set up your Laravel encryption key copy the APP_KEY environment value from your .env file and run heroku config:set APP_KEY=”Your app key” or you can generate a new one and set it as your new key using heroku config:set APP_KEY=$(php artisan --no-ansi key:generate --show) command.

## Step 6: Push to Github and deploy automatically
Commit the current state of your application with git and push to github with git push origin [branch_name].
Go to https://dashboard.heroku.com/apps/, select your created application and click on the deploy tab. Under the Deployment method, choose Github then connect to the right repo.
Under the Automatic deploys, click on the Enable Automatic Deploys.
Once this is done, any push made to the specified repo branch name, will automatically deploy to heroku.

## Step 7: Ensure that your application is using the right Heroku buildpacks
You need to ensure that your application is using the right buildpacks. To do this run the heroku buildpacks command. If you have heroku/php and heroku/nodejs listed you are good to go.

If you can’t find any, run heroku buildpacks:add [‘missing build’] command, replace the [‘missing build’] with the buildpack you wish to install and push to Heroku.

## Step 8: Your app should be up and running. To view it, navigate to the address in your browser

To set the environment variables for your application you can do that using your terminal with the heroku config:set VAR_NAME=VAR_VALUE command or through your dashboard in the settings tab, click on Reveal config vars to see and set environment variables.






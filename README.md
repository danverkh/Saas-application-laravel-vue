# AutoRankerWebsiteStaging

This is the staging repo for autoranker.io.

Live version of staging repository can be accessed here: https://autorankerwebsite-staging-ulq48.ondigitalocean.app/

## Instructions for initial container setup

### Steps for setup on fresh container

1. start bash, cd into root app directory and run:

     `cp -a .env.example .env `

     `php artisan key:generate`

     `cat .env`


2. copy-paste output into "App-Level Environment Variables" of container


3. Redeploy, done.  :-)

### Current environment variable config:

```
APP_NAME=AutoRanker
APP_ENV=production
APP_KEY=base64:pZOPOHDdizZT85S71rNv8K5yTieI/6mppHscIZjqu1E=
APP_DEBUG=true
APP_URL=https://autorankerwebsite-staging-ulq48.ondigitalocean.app/
ASSET_URL=https://autorankerwebsite-staging-ulq48.ondigitalocean.app/
LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
MEMCACHED_HOST=127.0.0.1
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=hello@example.com
MAIL_FROM_NAME=${APP_NAME}
AWS_DEFAULT_REGION=us-east-1
AWS_USE_PATH_STYLE_ENDPOINT=false
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1
VITE_PUSHER_APP_KEY=${PUSHER_APP_KEY}
VITE_PUSHER_HOST=${PUSHER_HOST}
VITE_PUSHER_PORT=${PUSHER_PORT}
VITE_PUSHER_SCHEME=${PUSHER_SCHEME}
VITE_PUSHER_APP_CLUSTER=${PUSHER_APP_CLUSTER}
```




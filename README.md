## Running
```
docker-compose up -d
```

## Dependencies Installation
Once you pull source from github repository you need to install dependencies by running the next command:
```
docker-compose exec app composer install
```

## Configuration
Copy .env.docker file to .env:
```
cp .env.docker .env
```

## Migrating
Migration running on the docker-compose up command but if you need you can fresh your database by executing next command  
```
docker-compose exec app php artisan migrate:fresh --seed
```

## Requesting
### Make transaction
```
curl --location --request POST 'localhost/api/transactions' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--data-raw '{
    "sender_wallet_id": 1,
    "destination_wallet_id": 2,
    "amount": 100
}'
```

### Get Transactions list
```
curl --location --request GET 'localhost/api/transactions'
```

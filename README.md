## Running
```
docker-compose up -d
```

## Migrating
Migration running on the docker-compose up command but if you need you can fresh your database by executing next command  
```
docker-compose exec app php artisan migrate:fresh --seed
```

## Requesting
```
curl --location --request POST 'localhost/api/fund' \
--form 'sender_wallet_id=1' \
--form 'destination_wallet_id=2' \
--form 'amount=100'
```

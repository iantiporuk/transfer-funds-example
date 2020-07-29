## Running
```
docker-compose up -d
```

## Migrating
```
docker-compose exec app php artisan migrate:fresh --seed
```

## Requesting
```
curl --location --request POST 'localhost/api/fund' \
--form 'sender_wallet_id=1' \
--form 'destination_wallet_to=2' \
--form 'amount=100'
```

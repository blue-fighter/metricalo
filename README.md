## Project set up

* Pull project from repository
* Port `8087` must be free, or change port for `webserver` in `compose.yml` to any free
* Execute `docker-compose up -d` from project root

## API method
`POST http://127.0.0.1:8087/purchase/{gateway}`

### Route parameter
* `gateway` must be `shift4` or `aci`

### Request Body params
`amount` - (integer) The payment amount (e.g. 100.50)

`currency` - (string) The currency code (e.g. USD, EUR)

`cardNumber` - (string) Credit card number (16 digits)

`cardExpYear` - (integer) Card expiration year (2 digits)

`cardExpMonth` - (integer) Card expiration month (1-12)

`cardCVV` - (integer) Card security code (3 digits)

### Response Example
`transaction_id` - (string) `8ac7a4a0967f8014019681a740411644`

`date_of_creating` - (string) `2025-04-29`

`amount` - (string) `100.00`

`currency` - (string) `EUR`

`card_bin` - (string) `420000`

### Console command
`docker exec -it metricalo-app ./bin/console app:purchase`

You can explore how to use it with help `docker exec -it metricalo-app ./bin/console app:purchase --help`
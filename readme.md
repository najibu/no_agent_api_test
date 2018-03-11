# NO AGENT API TEST


### Installation
``` bash
git clone
composer install
touch database/database.sqlite
cp .env.example .env
php artisan migrate
php artisan serve
```

### API Endpoints
``` bash
GET            /api/v1/properties                 List all properties
GET            /api/v1/properties/{id}            Retrieve a specific property
POST           /api/v1/properties                 Add a property, requiring only the address # body {
    "address_1": "65 Leonard St",
    "address_2": "",
    "city": "London",
    "postcode": "EC2A 4QS"
}
```

#### Thank you for checking out no agent api

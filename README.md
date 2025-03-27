## Installation

To set up the Skeleton marketplace integration project, follow the steps:

1. Clone the project from the repository
2. Run the command below to install the composer dependencies
```shell
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

## Running the project

The Skeleton marketplace integration is built on top of Laravel Sail;
therefore, to run the project, you need to execute the following command:

```shell
./vendor/bin/sail up -d
# or if you have the sail alias
sail up -d
```

## Testing HTTP requests
If you want to perform http requests to the application from your local machine,
you need to map port 80 of the `marketplace.etsy` docker compose
service to a port available on your local machine.

To do so, you can create a docker-compose.override.yml:

```yaml
services:
    marketplace.etsy:
        ports:
            - 8080:80
```

You can copy the [docker-compose.override.yml.example](docker-compose.override.yml.example) included with this source.

The `docker-compose.override.yml` file is automatically loaded by docker-compose (through Laravel Sail)
and also excluded from git tracking.

## Linking to the local-lb
MyParcel.com developers have access to a nginx-powered load balancer that enabled access to services
using human-readable urls.

To link this app to the local-lb, you need to create the `docker-compose.override.yml` file with the
following contents:

```yaml
services:
    marketplace.etsy:
        networks:
            - proxynet
networks:
    proxynet:
        external: true
```

### Things to keep in mind
- The `App\Shipments\Http\Controllers\ShipmentController::get()` method is responsible for fetching shipments. Intentionally, the method does not return a standard Laravel response object, but an array of Shipment objects. This is intentional and these objects are later converted to json-api responses [automatically by a middleware](https://github.com/MyParcelCOM/integration-commons/blob/master/src/Http/Middleware/TransformsToJsonApi.php).  


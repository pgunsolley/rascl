# Rascl (ˈrɑːskᵊl) - RESTful AccesS ControL

Rascl is an open source API Gateway that provides some of the functionality found in services such as AWS API Gateway or Azure API Gateway.

I started developing it for personal projects, and for prototyping real-world application services without the dependency of Iaas providers.

It is under heavy development and is not (currently) intended for production environments.

## Installation

Coming soon

## Administration

The administrator web portal can be accessed at `rascl.ddev.site`.

The portal is only accessible to superusers.

Newly registered users at `rascl.ddev.site/register` are not superusers. 

You may use the superuser command to create new superusers, or to promote or demote existing users.

Use `ddev cake superuser --help` for command options

## Development

Rascl uses [DDEV](https://docs.ddev.com/en/stable/).

### Configuration

Dependency installation will trigger command hooks that will generate an `config/app_local.php` file by copying from `config/app_local.example.php`.

See [CakePHP Docs](https://book.cakephp.org/5/en/development/configuration.html)


For API Authentication to work, you will need to generate a valid OpenSSL keypair:

```
# generate private key
openssl genrsa -out config/jwt.key 1024
# generate public key
openssl rsa -in config/jwt.key -outform PEM -pubout -out config/jwt.pem
```

Import the keys in `config/app_local.php`

```
'Authentication' => [
    'Authenticators' => [
        'Jwt' => [
            'privateKey' => ..,
            'publicKey' => ..,
        ],
    ],
],
```

### Migrations

Run migrations using `ddev cake migrations migrate`.

## Contributing

Pull requests are welcome, however I'm not currently actively reviewing requests. I hope to change this with time.

## License

[MIT](https://choosealicense.com/licenses/mit/)
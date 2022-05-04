# DeinArtz

## Installation

You need to use docker-compose for deploy project

```bash
composer install
```

```bash
rm -r var/cache
```

### For development mode:

#### If database doesn't exist 

```bash
bin/console doctrine:database:create 
```

#### Run/update database dump

```bash
bin/console d:s:u --force
```

#### Generate keypair for LexikJWT

```bash
bin/console lexik:jwt:generate-keypair
```

#### Load all fixture fro database
```bash
bin/console doctrine:fixtures:load
```
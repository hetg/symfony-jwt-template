# JWT + FOS User + FOS REST template

**Docker setup**

1. Copy `.env.dist` to `.env` file. Configure your local settings in `.env` file:
    ```
    cp .env.dist .env
    ```

2. Build containers:
    ```
    docker-compose build
    ```

3. Start containers:
    ```
    docker-compose up -d

**Installation**

1. Generate the SSH keys:
    ```
    mkdir -p config/jwt
    openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
    openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
    ```

2. Install composer packages:
    ```
    composer install
    ```
3. Create database and run migrations:
    ```
    bin/console doctrine:migrations:migrate
    ```
4. Create admin user
    ```
    bin/console doctrine:fixtures:load
    ```
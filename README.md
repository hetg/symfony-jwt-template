# JWT + FOS User + FOS REST template

**Instalation**

1. Generate the SSH keys:
    ```
    mkdir -p config/jwt
    openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
    openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
    ```

2. Copy `.env.dist` to `.env` file. Configure your local settings in `.env` file

3. Install composer packages:
    ```
    composer install
    ```
4. Create database and run migrations:
    ```
    bin/console doctrine:database:create
    bin/console doctrine:migrations:migrate
    ```
5. Create admin user
    ```
    bin/console fos:user:create
    ```
6. Promote admin user to admin role (ROLE_SUPER_ADMIN)
    ```
    bin/console fos:user:promote
    ```

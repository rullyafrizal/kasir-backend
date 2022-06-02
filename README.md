## Installation
1. Clone the repository
2. cd to `kasir-backend` directory
3. Copy `.env.example` to `.env`
4. Run
   ```
   composer install
   ```
5. Run
   ```
   php artisan key:generate
   ```
6. Configure .env values
7. cd to previous directory ".."
8. Configure the port binding on `docker-compose.yaml`
9.  Run
   ```
   docker compose up -d
   ```
10. Make sure your composer dependencies are correctly installed, because devDependencies are not installed due to --no-dev flag, if you want to change that, configure the `Dockerfile`
11. Open the browser to http://localhost:{YOUR_PORT_BINDING}
## Installation
### Prerequisites:
- PHP 8.0 or higher
- Composer
- PostgreSQL database

### Steps to Install:
1. Clone the repository:
   ```sh
   git clone https://github.com/wallcoder/bike.git
   cd pos
   ```
2. Install dependencies:
   ```sh
   composer install
   ```
3. Copy environment file and configure database:
   ```sh
   cp .env.example .env
   ```
   Update `.env` with your database credentials.
4. Generate application key:
   ```sh
   php artisan key:generate
   ```
5. Run database migrations:
   ```sh
   php artisan migrate 
   ```
6. Serve the application:
   ```sh
   php artisan serve
   ```
   
## Create filament user:
  ```sh
   php artisan make:filament-user
   ```

## Note
 If the images are not showing, you may change APP_URL in .env file to http://127.0.0.1:8000
 ```sh
   APP_URL=http://127.0.0.1:8000
   ```

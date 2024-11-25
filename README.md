# Clone the repo
git clone https://github.com/nirajmeshram/subscription-planner.git

cd subscription-planner/

# copy env.example 
cp .env.example .env

# Install project dependencies 
composer install

# Generate encrption key
php artisan key:generate


# Edit DB configuration
DB_CONNECTION=mysql

DB_HOST=127.0.0.1

DB_PORT=3306

DB_DATABASE=your_database_name

DB_USERNAME=your_database_user

DB_PASSWORD=your_database_password




# Generate database tables
php artisan migrate

# Run server
php artisan serve



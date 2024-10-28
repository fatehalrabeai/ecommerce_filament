<p align="center"><a href="https://www.linkedin.com/in/fateh-alrabeai-901a0a333/" target="_blank"><img width="200" src="https://texsasoil.com/img/logo/fateh.png" width="400" alt="Laravel Logo"></a></p>


## Ecommerce Filament

I created this repository for learning purposes.

## Clone the Repository

```bash
git clone https://github.com/your-username/your-repo-name.git
cd your-repo-name
Install Dependencies
```

```bash
composer install
```

## Installation

### Install Dependencies
```bash
composer install
```
Set Up Environment Variables
Duplicate .env.example and rename it to .env.
```
cp .env-example .env
```

Configure your database settings and other variables in the .env file.
Generate Application Key
```bash
php artisan key:generate
```

Run Migrations

```bash
php artisan migrate --seed
```
Seed the Database (Optional)

```bash
php artisan db:seed
```

Start the Development Server
```bash
php artisan serve
```
Access the Admin Panel
Open your browser and go to http://localhost:8000/admin.

##Usage

Log in to the admin panel and start managing products, orders, categories, and other entities as per your e-commerce requirements.
For detailed configuration, refer to the FilamentPHP documentation.


If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

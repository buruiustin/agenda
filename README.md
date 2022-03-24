# Agenda

### Laravel 8 CRUD APP

## Setup:

- clone this repo
```bash
git clone https://github.com/buruiustin/agenda.git 
```



- cd agenda/
- install composer
```bash
composer install
```
- copy .env.example into .env and set the DB

```bash
cp .env.example .env
```

- run generate key command:
```bash
php artisan key:generate
```

- then run npm:
```bash
npm install
npm run dev
```

- run migrations command:
```bash
php artisan migrate
```
- run database seeder command:
```bash
php artisan db:seed --class=TestContactSeeder
```

- run databse seeder command:
```bash
php artisan serve
```


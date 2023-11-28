# Medical Histories

Este proyecto utiliza Laravel y Vue.js. Aquí hay una guía general que puedes
seguir

## Variables

`APP_NAME=HistoriasMedicas`

`DB_CONNECTION=mysql`

`DB_DATABASE=medicalhistories`

## Pasos Generales

Clonar el Repositorio:

```bash
git clone https://github.com/karenporrass/MedicalHistories.git
```

##

Backend (Laravel):

```bash
cp .env.example .env
```

```bash
composer install
```

```bash

php artisan key:generate
```

##

Migraciones y seeders

```bash
php artisan migrate
```

```bash
php artisan db:seed

```

##

Frontend (Vue.js)

```bash
npm install
```

##

Ejecurtar Proyecto

```bash
php artisan serve
```

```bash
npm run dev
```

Este proyecto utiliza Laravel y Vue.js. Aquí hay una guía general que puedes
seguir:

Pasos Generales: Clonar el Repositorio:

bash Copy code git clone <URL
https://github.com/karenporrass/MedicalHistories.git> Instalar Dependencias del
Proyecto:

Para el backend (Laravel):

bash Copy code composer install cp .env.example .env php artisan key:generate

Para el frontend (Vue.js): bash Copy code npm install Configurar la Base de
Datos:

Configura tu archivo .env con la información de la base de datos. Copy code php
artisan migrate phpartisan db:seed

Inizializar

Copy code php artisan serve

Copy code npm run serve

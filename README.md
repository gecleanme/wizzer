# Wizzer

## Weather in your city, fast and simple

### Disclaimer: This cute toy was built to scratch an itch I'm having at work, it's not intended for public consumption in its current form

## Tech & Tools:

-   Laravel (v10 base)
-   Breeze / Inertia.js Scaffolding
-   Vue 3: Composition API with `script setup`
-   Tailwind CSS

## Features:

-   Easy to use
-   Auto-Location
-   Elegant Responsive UI

## Code Style/Format Treatment

[Laravel Pint](https://laravel.com/docs/10.x/pint) with stock config & [Prettier](https://prettier.io/)

## Try it online!

[Demo](https://wizzer-production.up.railway.app/)

## Prerequisites

-   php ^8.1
-   composer
-   npm
-   php-gd

## Local Dev Env Setup

## Clone the repo

```bash
git clone https://github.com/gecleanme/linvoice.git
```

### Install Dependencies

```bash
composer install
npm install
```

### Set Environment Variables

```
cp .env.example .env
```

### Generate App Key

```bash
php artisan key:generate
```


### Run Dev Server

```bash
php artisan serve
```

### Compile Vue.js

```bash
npm run dev
```

## License

Wizzer is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

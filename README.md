# Önálló laboratórium

## 2021/22 2.félév

## Tech Specs:

### Backend
- Laravel 9 
- PHP 8.0
- Docker
- docker-compose 

### Frontend
- React 17 
- TypeScript
- Webpack 5

## Indítás

### Backend 
A gyökérben található `docker-compose.yml` fájl segítségével lehet elindítani az alkmalmazást. Az indítás során 3 konténer jön létre:
- Nginx: Webszerver. Konfig a ./nginx mappában található.
- php8-fpm: Az Nginx az FPM segítségével tudja "futtatni" a .php fájlokat.
- MySQL: Relációs adatbáziskezelő.

A `backend` mappában kiadva:
```bash
docker-compose up 
```

### Frontend
A `frontend` mappában kiadva: 
```bash
npm start
```

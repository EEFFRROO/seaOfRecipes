# seaOfRecipes

### Требования
Для разворачивания проекта должен быть установлен *Docker*

Нужно Склонировать проект к себе на локальную машину

В командной строке перейти по пути в скачанный репозиторий и выполнить команду:

```shell
docker-compose up -d --build
```

При самом первом запуске контейнеров выполнить команды:
```shell
docker-compose exec php-sea bash
```
```shell
composer install
```
```shell
php bin/console d:m:m
```

## Сайт открывается на http://localhost:8080/
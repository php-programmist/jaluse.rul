# Настройка окружения и приложения

## Добавить локальный домен (для Windows)

Открыть PowerShell от админа и открыть `etc/hosts`:

```bash
notepad.exe C:\Windows\System32\Drivers\etc\hosts
```

Добавить строку:
`127.0.0.1  jaluse.rul`

## Инициализация окружения и приложения:

```bash
./project.sh init
```

В папке `.docker/etc/nginx/certs` будет сгенерирован SSL-сертификат с расширением `*.crt`. На Windows его необходимо
установить вручную, как Доверенный корневой центр сертификации.

## Запуск окружения

```bash
./project.sh start
```

## Перезапуск

```bash
./project.sh restart
```

## Остановка контейнеров

```bash
./project.sh down
```

## Запуск отслеживания изменений в файлах фронт-энда

```bash
./project.sh yarn watch
```

В сервисе `nodejs` будет запущена автоматически установка зависимостей и команда `yarn watch`, которая следит за файлами
фронт-энда (js-скриптами и стилями) и собирает их в dev-сборку

## Создание промышленного билда скриптов и стилей

```bash
./project.sh yarn build
```

## Запуск консольных команд Symfony

```bash
./project.sh console
```

## Запуск команд Composer

```bash
./project.sh composer
```
ddBooking - документация

Содержит в себе REST API с использованием самописной библиотеки ddCore (https://github.com/ddurov/ddprojects-core). Использовался шаблон программирования MVC.

Все методы API выполняются ровно так же (за исключением возвращаемых ошибок при методе approve, т.к. нет условий выдачи их), как и описано в документации ТЗ.

Разворачивание проекта:

1. git clone https://github.com/ddurov/ddBooking
2. cp template.env .env
3. отредактировать данные в переменных окружения (root_host можно выставить как localhost, api_host - booking, тогда для апи будет адрес booking.localhost)
4. make start

Для визуального просмотра БД доступен адрес booking.localhost:8000, логин: user, пароль: DATABASE_PASSWORD из .env

Позднее добавлю картинки нормализованной БД
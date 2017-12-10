# Система учета сотрудников PHP

Запустить данный код можно двумя способами:
 - docker
 - запустить в своей тестовой среде

# Docker
На dockerhub лежит образ, содержащий этот же код + среду для его исполнения

Сначала скачайте себе образ с dockerhub:

``` bash
docker pull slacklengo/employees_acc_sys
```
Затем запустите контейнер:
``` bash
docker run -it -p 5555:80 slacklengo/employees_acc_sys
```
где -p - порты для взаимодействия с контейнером (5555 - внешний порт (любой не занятый), 80 - порт внутри контейнера (порт apache2)).

После запуска текущий терминал переключится на терминал контейнера. В контейнере нужно запустить apache и mysql:

```bash
service apache2 start
/etc/init.d/mysql start
```
Теперь можно зайти на сайт из браузера, localhost:5555 - сайт; localhost:5555/phpmyadmin - phpmyadmin

# Запуск кода в своей тестовой среде
"Стяните" данный код в вашу локальную директорию

Настройте apache2: укажите в DocumentRoot и Directory путь до корня данного проекта, например:
``` bash
<VirtualHost *:80>
        ServerAdmin webmaster@localhost
        DocumentRoot /var/www/sf_test-task
   <Directory "/var/www/sf_test-task">
       Options Indexes MultiViews FollowSymLinks
       AllowOverride All
       Order allow,deny
       Allow from all
   </Directory>
        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```
Перезапустите apache2:
``` bash
service apache2 restart
```
При разработке проекта была использована СУБД mysql, в корне проекта вы найдете дамп базы "test_maslennikov.sql"

В корне проекта, в файле Bootstrap.php, выставите свои настройки БД:
``` bash
$pdo = new PDO('mysql:host=localhost;dbname=test_maslennikov;charset=utf8mb4', 'root', 'pika');
```

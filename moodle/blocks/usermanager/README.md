**Для программистов:** 

1. Папка oracle должна быть удалена, когда нужная информация (семестр предмета) будет доступна в БД moodle и не должна быть загружена на github.

**Установка:**

    Требования:
    1. Таблица block_vsucourse_new (используется блоком vsucourse)
    2. БД Contingent (файл подключения connect.php)

    Для установки требуется поместить файл в папку moodle_dir/blocks/ и зайти на портал под учётной записью администратора

**Добавление блока:**

    * Для добавления экземпляра блока действия аналогичны другим блокам
    * Для перехода на страницу подписки студентов (из других плагинов или блоков) требуется создать ссылку с указанием нужного файла и передать в глобальной переменной id курса ($SESSION->courseid). 
    * ВАЖНО! Вследствии использования данного способа невозможно использовать подписку одновременно на нескольких курсах (например в разных вкладках) от одного пользователя

**Структура плагина:**

    * block_usermanager.php - файл самого блока
    Ручная подписка:
    * manual_search_user.php - содержит поля для поиска студентов по фильтрам
    * manual_enrol_user.php - скрипт подписки по выбранным полям (в manual_search_user.php)
    * group_autosearch_users.php - поиск и выбор привяязок УП к курсу
    * group_autoenrol.php - поиск и подписка групп (по параметрам из group_autosearch_users.php)
    * connect.php - подключение к БД Contingent
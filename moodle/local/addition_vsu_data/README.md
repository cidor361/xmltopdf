Плагин для добавления дополнительной информации используемой другими плагинами (block_usermanager)

На данный момент реализованы следующий функционал:
 * таблицы для списков факультетов, годов поступления, учебных планов, форм обучения, уровней обучения (заполняются посредством скрипта install.php при установке плагина из полей профилей пользователей)
 * таблицы для дисциплин, специальностей (функционала заполнения начальными данными не реализовано)
 * класс, позволяющий получить данные из первых пяти таблиц
 * Класс позволяющийполучить вышеупомянутые данные непосредственно из полей профилей пользователей

<b>Для программистов</b>
 * Не реализоывана ссылка в меню администратора
 * Не реализован интерфейс редактирования имеющихся записей в таблице
 * Не реализованны capabilities (будут использоваться в интерфейсе)
 * После полной реализации (покрывающего все потребности) функционала класса general_data_vsu нужно удалить класс profile_field_method_vsu, так как его работа крайне не эффективна и может вызвать подвисания системы при работе
 * Требуется реализовать синхронизацию учебных планов и дисциплин
 * Требуется реализовать класс для получения информации из тыблиц учебных планов и дисциплин
Модуль установки времени записи
Сниппет вывода свободного времени записи
Что делает:
выводит календарик и список интервалов для записи, в модуле есть возможность:
- заблокировать отдельные повторяющиеся даты (праздники) в настройках модуля
- заблокировать дни недели (выходные) в настройках модуля
- установить на какое время вперед доступна запись (+30 дней) в настройках модуля
- установить интервалы времени для записи (9:00,9:15,9:30...) в настройках модуля
- заблокировать определенное время на определенную дату:
в модуле кликаем на нужную дату, кликом меняем статус нужного интервала времени
Сниппет выводит аналогичный календарик с учетом доступного времени.
Чего НЕ делает:
- не выводит форму для записи при клике на время
- не хранит данные о бронировании пользователем
Пример как использовать для записи - биндим клик на интервал, вызываем какую-то форму, передаем данные о времени и дате записи:
$(document).on('click','.booktimes span',function(){
			if($(this).hasClass('disabled'))return;
			var $form=$('.modalwindow');
			var time=$(this).data('time')
			var date=active.getDate()+'-'+(active.getMonth()+1)+'-'+active.getFullYear(); 
			$form.show();
			$(form).find('[name="date"]').val(date);
      $(form).find('[name="time"]').val(time);
		};
});
Установка:
1) скопировать файлы
2) создать модуль Booking c содержимым:
require(MODX_BASE_PATH.'assets/modules/booking/module.php');
3) запустить модуль, нажать setup для устаноки настроек по умолчанию
4) создать сниппет с содержимым:
require(MODX_BASE_PATH.'assets/modules/booking/snippet.php');
для вывода на странице используется сниппет [!Booking!], результаты работы выводятся в плейсхолдеры:
[+booking_styles+] - подключение базового файла стилей
[+booking_scripts+] - подключение JS (вызывать после JQuery)
[+booking_dates+] - вывод календарика
[+booking_times+] - вывод времени записи

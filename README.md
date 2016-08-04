# BitConsole
Основа командной строки для проектов DevelStudio

<h1>Установка</h1>
<p>Для DevelStudio 3.0 Beta2 и выше.</p>
<ol>
<li>Подключите <b>BitConsole.php</b> к проекту</li>
<li>Разместите многострочное поле (TMemo)</li>
<li>Введите следующий код в <b>Создание</b>:
</ol>
```
global $console; $console = new BitConsole();
$console->console = c("Form1->memo1"); # Поле ввода/вывода
$console->prefix = '> '; # Префикс
$console->version = '2.0-pre1'; # Версия
$console->shellredirect = True; # Перенаправлять команду в CMD-Windows, при её отсутствии в программе
$console->clear(); # "Отчищаем" консоль перед запуском
$console->ConsoleEvents(); # Загружаем события для консоли (ОБЯЗАТЕЛЬНО)
```

<h1>Возможности</h1>
<ul>
<li><span style="font-size: 15px">Содержит различные команды</span></li>
<li><span style="font-size: 15px">Поддерживает обязательные и необязательные аргументы</span></li>
<li><span style="font-size: 15px">Командам можно присваивать "альтернативы"</span></li>
<li><span style="font-size: 15px">При попытке вызвать несуществующую команду, пытается вызвать её через ShellExec</span></li>
<li><span style="font-size: 15px">Не требует дополнительных библиотек</span></li>
<li><span style="font-size: 15px">Работа с одним <b>TMemo</b></span></li>
<li>Не создаёт лишних файлов</li>
<li>Динамический префикс</li>
<li>Читабельный исходный код</li>
<li>Возможность переметки введённых команд</li>
<li>Легко настраивается</li>
</ul>

<?


# BitConsole
# v2.0-pre1

# OpenSource Project
# GitHub: http://github.com/lonadels/BitConsole
# Author: Lonadels (vk.com/lonadelsi)


class BitConsole
{
	/////////////////////////////////////////////////////////////////
	   function __construct($object=''){$this->console = $object; }
	////////////////////////////////////////////////////////////////

	# Вывод сообщений в терминал
	function t($msg)
	{
		$msg = str_replace('\n', _BR_, $msg); // Замена СИМВОЛА "\n"
		$this->console->text .= $msg;
		$this->repos('noPrefix');
	}
	
	# Очистка консоли
	function clear()
	{
		$this->CommandFromConsole = true;

		$this->console->text = 'Напишите "help" для получения помощи.';
		$this->repos();
	}
	
	# Обработчик команд
	function sendcmd($cmd)
	{
		/* Счётчик команд для перелистывания UP / DOWN */
		global $cmdInt;
		$cmd = substr($cmd, strlen($this->prefix));
		$this->lastCommand[] = $cmd;
		$cmdInt = count($this->lastCommand);
		/***********************************************/
		
		$args = explode(' ', $cmd); # Аргументы
		$cmd  = $args[0];

		switch ($cmd) # Список команд
		{
			case 'help': case '?':   # Команда "help" (Альтернатива "?")
				$command = $args[1]; # Проверка на присутствие аргументов
				if ($command)
				{
					/*
						Справка по конкретным командам
					*/
					switch ($command)
					{
						case 'clr': case 'cls': # Это справка по команде cls (help cls)
							$this->t('Очистка содержмиого консоли.');
							$this->t('Использование: ' . $command);
							break;
						case 'font':
							$this->t('Установка размера и имени шрифта для текста в консоли.');
							$this->t('Использование: ' . $command . ' [-n <имя шрифта>][-s <размер шрифта>]');
							$this->t('');
							$this->t('    Список параметров');
							$this->t('    -n <имя шрифта> Имя шрифта без пробелов. Пробел заменить нижним подчёркиванием ("_")');
							$this->t('    -s <размер шрифта> Размер шрифта цифрами без личшних символов. Соответствует пикселям.');
							break;
						case 'color':
							$this->t('Установка цветов по умолчанию для текста в консоли.');
							$this->t('Использование: ' . $command . ' <цвет>');
							$this->t('');
							$this->t('    0 = Черный');
							$this->t('    1 = Синий');
							$this->t('    2 = Зеленый');
							$this->t('    3 = Голубой');
							$this->t('    4 = Красный');
							$this->t('    5 = Лиловый');
							$this->t('    6 = Желтый');
							$this->t('    7 = Белый');
							$this->t('    8 = Серый');
							$this->t('    9 = Светло-синий');
							break;
						case 'help': case '?':
							$this->t('Вывод справочных сведений о командах Windows.');
							$this->t('Использование: ' . $command . ' [<команда>]');
							break;
						case 'base64_decode': case 'base64_encode': case 'b64_e': case 'b64_d':
							$this->t('Шифровка и дешифровка текста в Base64.');
							$this->t('Использование: ' . $command . ' [<текст>]');
							break;
						case 'about': case 'info':
							$this->t('Получение информации о BitConsole.');
							$this->t('Использование: ' . $command . '');
							break;
						case 'start':
							$this->t('Запуск процесса.');
							$this->t('Использование: ' . $command . ' [<файла>]');
							$this->t('(Например, ' . $command . ' explorer.exe)');
							break;
						case 'echo': case 'print':
							$this->t('Вывод сообщения в окно консоли.');
							$this->t('Использование: ' . $command . ' [<сообщнеие>]');
							$this->t('(Например, ' . $command . ' Hello, world)');
							break;
						default:
							$this->t('Данная команда не известна или для неё не составлена справка.');
							break;
					}
					continue; # Останавливаем продолжение кода
				}

				# Если была введена просто "help", то:
				$this->t('Для получения сведений об определённой команде, введите help <имя команды>');
				$this->t('cls - Очистить консоль');
				$this->t('color - Цвет шрифта командной строки');
				$this->t('font - Имя и размер шрифта командной строки');
				$this->t('about - Информация о BitConsole');
				$this->t('b64_e - Закодировать текст в Base64');
				$this->t('b64_d - Расшифровать текст из Base64');
				$this->t('echo - Вывод текста');
				$this->t('start - Запуск процесса');
				break;
				
				
				
			/* Список команд и их действия */
			
			case 'start': # Команда "start"
				$process = $args[1];
				run($process, false); # Запускаем процесс
				break;
				
			case 'base64_decode': case 'b64_d': # Base64_decode
				$text = $this->getAllArgs($args);
				if ($text)
					$this->t('Текст: ' . base64_decode($text));
				else
					$this->t('Введите текст! (Наберите "help ' . $cmd . '" для справки)');
				break;

			case 'base64_encode': case 'b64_e': # Base64_encode
				$text = $this->getAllArgs($args);
				if ($text)
					$this->t('Base64: ' . base64_encode($text));
				else
					$this->t('Введите текст! (Наберите "help ' . $cmd . '" для справки)');
				break;
				
			case 'echo': case 'print': # Вывод текста
				$text = $this->getAllArgs($args);
				if ($text)
					$this->t($text);
				else
					$this->t('Введите текст! (Наберите "help ' . $cmd . '" для справки)');
				break;
				
			case 'info': case 'about': # о программе
				$this->t('Версия: ' . $this->version);
				$this->t('Автор: ' . 'Lonadels'); // Изменять запрещено. ТОЛЬКО УДАЛЕНИЕ!!!
				break;
				
			case 'clr': case 'cls': # Отчистить консоль
				$this->clear();
				break;
				
			case 'font':  # Смена шрифта
				$arg = 1; # Начинаем с аргументов, т.к. 0 = команда
				while ($arg < count($args))
				{
					$param  = $args[$arg];
					$param2 = $args[$arg + 1];

					switch ($param)
					{
						case '-n': # Получаем аргумент -n
							$param2                    = str_replace('_', ' ', $param2);
							$this->console->font->name = $param2;
							$this->t('Имя шрифта изменено на ' . $this->console->font->name);
							break;
						case '-s': # Получаем аргумент -s
							if ((int) $param2 < 3)
								$param2 = 3;
							$this->console->font->size = (int) $param2;
							$this->t('Размер шрифта изменён на ' . $this->console->font->size);
							break;
						case '-default': # Получаем аргумент -default
							$this->console->font->name = 'Consolas';
							$this->console->font->size = 10;
							break;
					}

					$arg += 2;
				}

				break;
			case 'color': # Смена цвета
				$color = $args[1]; # Аргументы
				if ($color)
					switch ($color)
					{
						case 0: # 0 - Аргумент (Color 0)
							$cl = clDkGray;
							break;
						case 1:
							$cl = clNavy;
							break;
						case 2: # 2 - Аргумент (Color 2)
							$cl = clGreen;
							break;
						case 3: # 3 - Аргумент (Color 3) и т.д....
							$cl = clAqua;
							break;
						case 4:
							$cl = clRed;
							break;
						case 5:
							$cl = clFuchsia;
							break;
						case 6:
							$cl = clYellow;
							break;
						case 7:
							$cl = clSilver;
							break;
						case 8:
							$cl = clGray;
							break;
						case 9:
							$cl = clBlue;
							break;
						default:
							$cl = clGray;
							break;
					}
				$this->console->font->color = $cl; # Устанавливаем цвет шрифта
				break;
			default: # Если ни одна из команд не была введена
				if( $this->shellredirect )
				{
					$this->t('"' . $cmd . '" не найдена и были вызвана из обычной командной строки.');
					$shell = iconv('cp866', 'cp1251', shell_exec($cmd));
					$this->t($shell);
				}
				else
					$this->t('"' . $cmd . '" не найдена, напишите "help" для получения помощи');
				break;
		}
		$this->repos();
	}
	
	# Отменяем удаление основного текста
	function cancelReturning()
	{
		
		if (!$this->CommandFromConsole and strlen($this->lastText) > strlen($this->console->text))
		{
			$this->console->text     = $this->lastText;
			$this->console->selStart = strlen($this->console->Text);
		}
		
		$this->CommandFromConsole = false;
	}
	
	# Прокрутка консоли
	function scroll()
	{
		while ($x < count($this->console->text) * 2)
		{
			$this->console->perform(182, 0, 10);
			$this->console->perform(182, 0, 10);
			$x++;
		}
	}

	# Установка позиции курсора, новая строка
	// TODO: доработать прокрутку
	function repos()
	{
		$args                     = func_get_args();
		$this->CommandFromConsole = true;
		
		if (!in_array('noPrefix', $args))
			$this->console->text .= _BR_ . $this->prefix;
		else
			$this->console->text .= _BR_;
		
		$this->console->selStart = strlen($this->console->text);
		
		$this->lastText = $this->console->text;
		$this->scroll();
		
	}
	
	# Получаем все аргументы как один
	function getAllArgs($args)
	{
		unset( $args[0]);
		$allArgs = implode( ' ', $args );

		return trim($allArgs);
	}
	
	
	# События консоли (TARDIS)
	function ConsoleEvents()
	{
		$TARDIS = $this;
		$c = $this->console;
		$c->onChange =
		function($self)use($TARDIS){
			$self = c($self);
			$TARDIS->cancelReturning();
		};
		$c->onKeyDown =
		function($self, &$key)use($TARDIS)
		{
			$self = c($self);
			if( $key != VK_LEFT and $key != VK_RIGHT )
			$self->selStart = strlen($self->Text);
		};
		$c->onKeyUp =
		function($self, &$key)use($TARDIS)
		{
			$self = c($self);
			$console = $TARDIS;

			if( $key == VK_RETURN )
			{
				$str = $self->text;
				$ex = explode(_BR_, $str);
				$command = $ex[ count($ex)-2 ];

				$console->sendcmd($command);
			}
			elseif( $key == VK_UP and $console->lastCommand )
			{
				global $cmdInt;

				$cmdInt--;
				$c = $console->lastCommand;
				if( $cmdInt < 1 ) $cmdInt = 0;

				$console->console->text = $console->lastText;
				$console->console->text .= $console->lastCommand[ $cmdInt ];
				$console->console->selStart = strlen( $console->console->text );
			}
			elseif( $key == VK_DOWN and $console->lastCommand )
			{
				global $cmdInt;

				$cmdInt++;
				$c = $console->lastCommand;
				if( $cmdInt > count($c) ) $cmdInt = count($c);

				$console->console->text = $console->lastText;
				$console->console->text .= $console->lastCommand[ $cmdInt ];
				$console->console->selStart = strlen( $console->console->text );
			}

			$console->scroll();
		};
	}

	static $console;
	static $lastText;
	static $lastCommand;
	static $version;
	static $shellredirect;
	static $CommandFromConsole;
}

global $console; $console = new BitConsole();

$console->console       = c("memo1"); # Поле ввода/вывода
$console->prefix  		= '> ';       # Префикс
$console->version 		= '2.0-pre1'; # Версия
$console->shellredirect = True; 	  # Перенаправлять команду в CMD-Windows, при её отсутствии в программе

$console->clear();                    # "Отчищаем" консоль перед запуском
$console->ConsoleEvents();            # Загружаем события для консоли (ОБЯЗАТЕЛЬНО)
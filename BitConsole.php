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

	# ����� ��������� � ��������
	function t($msg)
	{
		$msg = str_replace('\n', _BR_, $msg); // ������ ������� "\n"
		$this->console->text .= $msg;
		$this->repos('noPrefix');
	}
	
	# ������� �������
	function clear()
	{
		$this->CommandFromConsole = true;

		$this->console->text = '�������� "help" ��� ��������� ������.';
		$this->repos();
	}
	
	# ���������� ������
	function sendcmd($cmd)
	{
		/* ������� ������ ��� �������������� UP / DOWN */
		global $cmdInt;
		$cmd = substr($cmd, strlen($this->prefix));
		$this->lastCommand[] = $cmd;
		$cmdInt = count($this->lastCommand);
		/***********************************************/
		
		$args = explode(' ', $cmd); # ���������
		$cmd  = $args[0];

		switch ($cmd) # ������ ������
		{
			case 'help': case '?':   # ������� "help" (������������ "?")
				$command = $args[1]; # �������� �� ����������� ����������
				if ($command)
				{
					/*
						������� �� ���������� ��������
					*/
					switch ($command)
					{
						case 'clr': case 'cls': # ��� ������� �� ������� cls (help cls)
							$this->t('������� ����������� �������.');
							$this->t('�������������: ' . $command);
							break;
						case 'font':
							$this->t('��������� ������� � ����� ������ ��� ������ � �������.');
							$this->t('�������������: ' . $command . ' [-n <��� ������>][-s <������ ������>]');
							$this->t('');
							$this->t('    ������ ����������');
							$this->t('    -n <��� ������> ��� ������ ��� ��������. ������ �������� ������ �������������� ("_")');
							$this->t('    -s <������ ������> ������ ������ ������� ��� ������� ��������. ������������� ��������.');
							break;
						case 'color':
							$this->t('��������� ������ �� ��������� ��� ������ � �������.');
							$this->t('�������������: ' . $command . ' <����>');
							$this->t('');
							$this->t('    0 = ������');
							$this->t('    1 = �����');
							$this->t('    2 = �������');
							$this->t('    3 = �������');
							$this->t('    4 = �������');
							$this->t('    5 = �������');
							$this->t('    6 = ������');
							$this->t('    7 = �����');
							$this->t('    8 = �����');
							$this->t('    9 = ������-�����');
							break;
						case 'help': case '?':
							$this->t('����� ���������� �������� � �������� Windows.');
							$this->t('�������������: ' . $command . ' [<�������>]');
							break;
						case 'base64_decode': case 'base64_encode': case 'b64_e': case 'b64_d':
							$this->t('�������� � ���������� ������ � Base64.');
							$this->t('�������������: ' . $command . ' [<�����>]');
							break;
						case 'about': case 'info':
							$this->t('��������� ���������� � BitConsole.');
							$this->t('�������������: ' . $command . '');
							break;
						case 'start':
							$this->t('������ ��������.');
							$this->t('�������������: ' . $command . ' [<�����>]');
							$this->t('(��������, ' . $command . ' explorer.exe)');
							break;
						case 'echo': case 'print':
							$this->t('����� ��������� � ���� �������.');
							$this->t('�������������: ' . $command . ' [<���������>]');
							$this->t('(��������, ' . $command . ' Hello, world)');
							break;
						default:
							$this->t('������ ������� �� �������� ��� ��� �� �� ���������� �������.');
							break;
					}
					continue; # ������������� ����������� ����
				}

				# ���� ���� ������� ������ "help", ��:
				$this->t('��� ��������� �������� �� ����������� �������, ������� help <��� �������>');
				$this->t('cls - �������� �������');
				$this->t('color - ���� ������ ��������� ������');
				$this->t('font - ��� � ������ ������ ��������� ������');
				$this->t('about - ���������� � BitConsole');
				$this->t('b64_e - ������������ ����� � Base64');
				$this->t('b64_d - ������������ ����� �� Base64');
				$this->t('echo - ����� ������');
				$this->t('start - ������ ��������');
				break;
				
				
				
			/* ������ ������ � �� �������� */
			
			case 'start': # ������� "start"
				$process = $args[1];
				run($process, false); # ��������� �������
				break;
				
			case 'base64_decode': case 'b64_d': # Base64_decode
				$text = $this->getAllArgs($args);
				if ($text)
					$this->t('�����: ' . base64_decode($text));
				else
					$this->t('������� �����! (�������� "help ' . $cmd . '" ��� �������)');
				break;

			case 'base64_encode': case 'b64_e': # Base64_encode
				$text = $this->getAllArgs($args);
				if ($text)
					$this->t('Base64: ' . base64_encode($text));
				else
					$this->t('������� �����! (�������� "help ' . $cmd . '" ��� �������)');
				break;
				
			case 'echo': case 'print': # ����� ������
				$text = $this->getAllArgs($args);
				if ($text)
					$this->t($text);
				else
					$this->t('������� �����! (�������� "help ' . $cmd . '" ��� �������)');
				break;
				
			case 'info': case 'about': # � ���������
				$this->t('������: ' . $this->version);
				$this->t('�����: ' . 'Lonadels'); // �������� ���������. ������ ��������!!!
				break;
				
			case 'clr': case 'cls': # ��������� �������
				$this->clear();
				break;
				
			case 'font':  # ����� ������
				$arg = 1; # �������� � ����������, �.�. 0 = �������
				while ($arg < count($args))
				{
					$param  = $args[$arg];
					$param2 = $args[$arg + 1];

					switch ($param)
					{
						case '-n': # �������� �������� -n
							$param2                    = str_replace('_', ' ', $param2);
							$this->console->font->name = $param2;
							$this->t('��� ������ �������� �� ' . $this->console->font->name);
							break;
						case '-s': # �������� �������� -s
							if ((int) $param2 < 3)
								$param2 = 3;
							$this->console->font->size = (int) $param2;
							$this->t('������ ������ ������ �� ' . $this->console->font->size);
							break;
						case '-default': # �������� �������� -default
							$this->console->font->name = 'Consolas';
							$this->console->font->size = 10;
							break;
					}

					$arg += 2;
				}

				break;
			case 'color': # ����� �����
				$color = $args[1]; # ���������
				if ($color)
					switch ($color)
					{
						case 0: # 0 - �������� (Color 0)
							$cl = clDkGray;
							break;
						case 1:
							$cl = clNavy;
							break;
						case 2: # 2 - �������� (Color 2)
							$cl = clGreen;
							break;
						case 3: # 3 - �������� (Color 3) � �.�....
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
				$this->console->font->color = $cl; # ������������� ���� ������
				break;
			default: # ���� �� ���� �� ������ �� ���� �������
				if( $this->shellredirect )
				{
					$this->t('"' . $cmd . '" �� ������� � ���� ������� �� ������� ��������� ������.');
					$shell = iconv('cp866', 'cp1251', shell_exec($cmd));
					$this->t($shell);
				}
				else
					$this->t('"' . $cmd . '" �� �������, �������� "help" ��� ��������� ������');
				break;
		}
		$this->repos();
	}
	
	# �������� �������� ��������� ������
	function cancelReturning()
	{
		
		if (!$this->CommandFromConsole and strlen($this->lastText) > strlen($this->console->text))
		{
			$this->console->text     = $this->lastText;
			$this->console->selStart = strlen($this->console->Text);
		}
		
		$this->CommandFromConsole = false;
	}
	
	# ��������� �������
	function scroll()
	{
		while ($x < count($this->console->text) * 2)
		{
			$this->console->perform(182, 0, 10);
			$this->console->perform(182, 0, 10);
			$x++;
		}
	}

	# ��������� ������� �������, ����� ������
	// TODO: ���������� ���������
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
	
	# �������� ��� ��������� ��� ����
	function getAllArgs($args)
	{
		unset( $args[0]);
		$allArgs = implode( ' ', $args );

		return trim($allArgs);
	}
	
	
	# ������� ������� (TARDIS)
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

$console->console       = c("memo1"); # ���� �����/������
$console->prefix  		= '> ';       # �������
$console->version 		= '2.0-pre1'; # ������
$console->shellredirect = True; 	  # �������������� ������� � CMD-Windows, ��� � ���������� � ���������

$console->clear();                    # "��������" ������� ����� ��������
$console->ConsoleEvents();            # ��������� ������� ��� ������� (�����������)
<?

	session_start();
	session_write_close();
	
	include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');
	$api = new API();
	$api->connect();

	$email = $_POST['email'];
	$pass = $_POST['pass'];

	// Подключаем Telegram бота
    include( $_SERVER['DOCUMENT_ROOT'].'/app/api/telegram/class.php');
    $bot = new Telegram();

	if (empty($email) || empty($pass)) {
		echo 'empty';
		$bot_text = 'пустые поля при входе';
	}
	else{
		$user_check = $api->query(" SELECT *  FROM `app_users` WHERE `email` = '$email' AND `pass` = '$pass' LIMIT 1 ");

		if (!empty($user_check['id']) ) {

			$id = $user_check['id'];
			setcookie('user', $id,time()+36000, '/');
			echo 'ok';

			$bot_text = 'вход в APP пользователя '.$email;

		}else{
			echo 'wrong';
			
			$bot_text = 'неудачная попытка входа '.$email;
		}
	}


	$bot->say_test($bot_text);

?>
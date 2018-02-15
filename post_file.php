<?php
function exit_status($str){
	echo json_encode(array('status'=>$str));
	exit;
}

function get_extension($file_name){
	$ext = explode('.', $file_name);
	$ext = array_pop($ext);
	return strtolower($ext);
}

$upload_dir = 'uploads/'; //Создадим папку для хранения изображений
$allowed_ext = array('jpg','jpeg','png','gif'); //форматы для загрузки


if(strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
	exit_status('Ошибка при отправке запроса на сервер!');
}


if(array_key_exists('pic',$_FILES) && $_FILES['pic']['error'] == 0 ){
	
	$pic = $_FILES['pic'];
	
	if(!in_array(get_extension($pic['name']),$allowed_ext)){
		exit_status('Разрешена загрузка следующих форматов: '.implode(',',$allowed_ext));
	}	

//Загружаем файл во на сервер в нашу папку и посылаем команду о том, что все ОК и файл загружен
	if(move_uploaded_file($pic['tmp_name'], $upload_dir.$pic['name'])){
		exit_status('Файл Был успешно загружен!');
	}
	
}

exit_status('Во время загрузки произошли ошибки');

?>
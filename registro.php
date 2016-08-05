<?php
	require_once("mailrelay.php");
	//$this->mailrelay->mailrelay_send($data_usuario['email'],$data_usuario['full_name'],'Hola '.$data_usuario['full_name'].' bienvenido a edwcar!',$template);
	$mailrelay = new mailrelay;

	$consignacion_atleta= false;

	set_time_limit (90);

	$register_date = date("Y-m-d");

	$name_user = $_POST['name_user'];
	$email_user = $_POST['email_user'];
	$tel_user = $_POST['tel_user'];
	$user_social = $_POST['user_social'];
	$tipo_evento = $_POST['tipo_evento'];

	//$mysqli = new mysqli('localhost', 'root', '', 'jw_social_show_room');
	$mysqli = new mysqli('localhost', 'theplace_jw_soci', '7N3lkTXLP-Gt', 'theplace_jw_social_show_room');

    if ($mysqli->connect_errno) {
	    die('No se pudo conectar: ' . $mysqli->connect_error);
    }

    $sql = "INSERT INTO usuarios(name_user, email_user, tel_user, user_social, register_date,tipo_evento) VALUES('$name_user', '$email_user', '$tel_user','$user_social', '$register_date','$tipo_evento')";

    if ($resultado = $mysqli->query($sql)) {
   
		$template = file_get_contents("mailrelay_template_header.php");

		$template .= "El usuario ".$_POST['name_user']." está listo para participar en el JW Social Showroom , sus datos registrados son: <br><br>".
					" Nombre: ". $_POST['name_user'].'<br>'.
					" Email: ". $_POST['email_user'].'<br>'.
					" Teléfono: ". $_POST['tel_user'].'<br>'.
					" Tipo de evento que busca: ". $_POST['tipo_evento'].'<br>'.				
					" Usuario red social: ". $_POST['user_social'].'<br>';

		$template .= "<br>";

		$template .= file_get_contents("mailrelay_template_footer.php");

		// envio de correo al organizador 
		/*$mailrelay->mailrelay_send('comunicaciones@campocomunicacionintegral.com','Marriott Cali','Hay un nuevo participante para el JW Social Showroom'.$_POST['name_user'],$template,$consignacion_atleta);*/

		$mailrelay->mailrelay_send('nelson.quirama@pklagencia.com','Marriott Cali','Hay un nuevo participante para el JW Social Showroom, '.$_POST['name_user'],$template,$consignacion_atleta);

		$template_atleta = file_get_contents("mailrelay_template_header.php");

		$template_atleta .= "¡".$_POST['name_user'].", gracias por tu suscripción!<br><br>".
		"Estás a pocos días de conocer los pequeños y grandes detalles que pueden hacer de tu evento una fecha única. Queremos ser tu aliado para que puedas tener el evento de tu sueños, tan solo <strong>#ImagínaloInolvidable</strong>.<br><br>".
		"Te esperamos este 20 de agosto en el hotel <strong>JW Marriott Bogotá</strong> (Calle 73 # 8-60) de 10am a 8pm, para compartir las más recientes tendencias en diseño, moda y gastronomía para bodas y eventos sociales junto a las marcas más representativas del mercado. Este día sabrás los resultados de nuestro sorteo y los beneficios especiales que tendremos para ti.<br><br>".
		"Será un día para pensar en grande, para imaginarlo inolvidable.<br><br>".
		"Diana Arévalo".
		"Wedding Planner  |  JW Marriott Bogotá";

		$template_atleta .= file_get_contents("mailrelay_template_footer.php");
		// envio de correo al atleta
		$mailrelay->mailrelay_send($_POST['email_user'],'JW Marriott','Bienvenido(a) al JW Social Showroom',$template_atleta,array());


	    header("Location: http://".$_SERVER['SERVER_NAME']);

    }else{
    	 die('error en la consulta: ' . $mysqli->error);
    }
    

?>
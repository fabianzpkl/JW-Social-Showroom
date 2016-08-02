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

	$mysqli = new mysqli('localhost', 'root', '', 'jw_social_show_room');

    if ($mysqli->connect_errno) {
	    die('No se pudo conectar: ' . $mysqli->connect_error);
    }

    $sql = "INSERT INTO usuarios(name_user, email_user, tel_user, user_social, register_date) VALUES('$name_user', '$email_user', '$tel_user','$user_social', '$register_date')";

    if ($resultado = $mysqli->query($sql)) {
   
		$template = file_get_contents("mailrelay_template_header.php");

		$template .= "El usuario ".$_POST['name_user']." está listo para participar en el JW Social Showroom , sus datos registrados son: <br><br>".
					" Nombre: ". $_POST['name_user'].'<br>'.
					" Email: ". $_POST['email_user'].'<br>'.
					" Teléfono: ". $_POST['tel_user'].'<br>'.
					" Usuario red social: ". $_POST['user_social'].'<br>';

		$template .= "<br>";

		$template .= file_get_contents("mailrelay_template_footer.php");

		// envio de correo al organizador 
		/*$mailrelay->mailrelay_send('comunicaciones@campocomunicacionintegral.com','Marriott Cali','Hay un nuevo participante para el JW Social Showroom'.$_POST['name_user'],$template,$consignacion_atleta);*/

		$mailrelay->mailrelay_send('nelson.quirama@pklagencia.com','Marriott Cali','Hay un nuevo participante para el JW Social Showroom, '.$_POST['name_user'],$template,$consignacion_atleta);

		$template_atleta = file_get_contents("mailrelay_template_header.php");

		$template_atleta .= $_POST['name_user']." <br> JW Marriott te da la bienvenida al JW Social Showroom".
							"Síguenos en nuestras redes sociales y visita nuestro sitio oficial  y continúa preparándote para un día inolvidable.<br>";

		$template_atleta .= file_get_contents("mailrelay_template_footer.php");
		// envio de correo al atleta
		$mailrelay->mailrelay_send($_POST['email_user'],'JW Marriott','Bienvenido(a) al JW Social Showroom',$template_atleta,array());


	    header("Location: http://".$_SERVER['SERVER_NAME']);

    }else{
    	 die('error en la consulta: ' . $mysqli->error);
    }
    

?>
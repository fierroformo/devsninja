<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Confirma tu cuenta en devsninja</h2>
        <p>Haz click en el siguiente enlace ó pegalo en la barra de direcciones del navegador para activar tú cuenta
            <span>{{ URL::to('activate', array($username, $code)) }}</span>
        </p>
	</body>
</html>

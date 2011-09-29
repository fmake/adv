<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Venta-Adv</title>
	<link rel="stylesheet" type="text/css" href="/styles/admin/main.css" />
	<link rel="stylesheet" type="text/css" href="/styles/admin/login.css" />
	<meta http-equiv="X-UA-Compatible" content="IE=7" />
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
</head>

<body class="bodylogin" >
	<div class="page">
		<div id="login" >
		<form method="post">
			<input type="hidden" name="action" value="Login" />
			<table>
				[[ if error ]]
				<tr>
					<td colspan="2" ><b>Неверный логин или пароль</b></td>
				</tr>
				[[endif]]
				<tr>
					<td class="f-td" >Логин</td>
					<td><input type="text" name="login" class="text" />  </td>
				</tr>
				<tr>
					<td>Пароль</td>
					<td><input type="password" name="password" class="text" />  </td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="checkbox" name="save" id="save"  /> <label for="save">Запомнить меня</label>
						<button class="action-button f_rt" ><div></div><span>Войти</span>Войти</button>
					</td>
				</tr>
			</table>
			</form>
		</div>
		
	</div>

</body>
</html>
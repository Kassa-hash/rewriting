<?php
session_start();
include 'fonction.php';

// Si déjà connecté, rediriger vers admin
if (isset($_SESSION['user_id'])) {
	header('Location: /admin/articles');
	exit;
}

$error = '';
$username = '';

// Traiter le formulaire de login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$username = trim($_POST['username'] ?? '');
	$password = $_POST['password'] ?? '';

	if (empty($username) || empty($password)) {
		$error = 'Veuillez entrer un nom d\'utilisateur et un mot de passe.';
	} else {
		$user = validateLogin($username, $password);

		if ($user !== null) {
			// Connexion réussie
			$_SESSION['user_id'] = $user['id'];
			$_SESSION['username'] = $user['username'];
			$_SESSION['role'] = $user['role'];

			header('Location: /admin/articles');
			exit;
		} else {
			$error = 'Nom d\'utilisateur ou mot de passe incorrect.';
		}
	}
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Connexion - Iran Observateur</title>
	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		body {
			font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
			background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
			min-height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
		}

		.login-container {
			background: white;
			border-radius: 8px;
			box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
			width: 100%;
			max-width: 400px;
			padding: 40px;
		}

		.login-header {
			text-align: center;
			margin-bottom: 30px;
		}

		.login-header h1 {
			font-size: 28px;
			font-weight: 700;
			color: #1a1a2e;
			margin-bottom: 5px;
		}

		.login-header p {
			color: #666;
			font-size: 14px;
		}

		.form-group {
			margin-bottom: 20px;
		}

		.form-group label {
			display: block;
			margin-bottom: 8px;
			font-weight: 600;
			color: #333;
			font-size: 14px;
		}

		.form-group input {
			width: 100%;
			padding: 12px 15px;
			border: 2px solid #e0e0e0;
			border-radius: 6px;
			font-size: 14px;
			transition: border-color 0.3s ease;
		}

		.form-group input:focus {
			outline: none;
			border-color: #2c7a3f;
			background-color: #fafafa;
		}

		.error-message {
			background-color: #fee;
			color: #c33;
			padding: 12px 15px;
			border-radius: 6px;
			margin-bottom: 20px;
			font-size: 14px;
			border-left: 4px solid #c33;
		}

		.submit-btn {
			width: 100%;
			padding: 12px 15px;
			background-color: #2c7a3f;
			color: white;
			border: none;
			border-radius: 6px;
			font-size: 16px;
			font-weight: 600;
			cursor: pointer;
			transition: background-color 0.3s ease;
		}

		.submit-btn:hover {
			background-color: #1f5728;
		}

		.submit-btn:active {
			transform: scale(0.98);
		}

		.site-link {
			text-align: center;
			margin-top: 20px;
		}

		.site-link a {
			color: #2c7a3f;
			text-decoration: none;
			font-size: 14px;
			font-weight: 600;
		}

		.site-link a:hover {
			text-decoration: underline;
		}
	</style>
</head>
<body>
	<div class="login-container">
		<div class="login-header">
			<h1>Iran Observateur</h1>
			<p>Panel d'Administration</p>
		</div>

		<?php if ($error): ?>
			<div class="error-message"><?= htmlspecialchars($error) ?></div>
		<?php endif; ?>

		<form method="POST" action="">
			<div class="form-group">
				<label for="username">Nom d'utilisateur</label>
				<input 
					type="text" 
					id="username" 
					name="username" 
					value="<?= htmlspecialchars($username) ?>" 
					required 
					autofocus
				>
			</div>

			<div class="form-group">
				<label for="password">Mot de passe</label>
				<input 
					type="password" 
					id="password" 
					name="password" 
					required
				>
			</div>

			<button type="submit" class="submit-btn">Connexion</button>
		</form>

		<div class="site-link">
			<a href="/">← Retour au site</a>
		</div>
	</div>
</body>
</html>
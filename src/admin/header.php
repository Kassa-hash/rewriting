<?php
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
	header('Location: /login');
	exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= htmlspecialchars($pageTitle ?? 'Admin - Iran Observateur') ?></title>
	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		body {
			font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
			background-color: #f5f5f5;
			color: #333;
		}

		/* Navigation */
		.admin-nav {
			background-color: #1a1a2e;
			padding: 0;
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
		}

		.nav-container {
			max-width: 1400px;
			margin: 0 auto;
			display: flex;
			justify-content: space-between;
			align-items: center;
			padding: 0 20px;
		}

		.nav-brand {
			color: white;
			font-size: 24px;
			font-weight: 700;
			padding: 15px 0;
			text-decoration: none;
		}

		.nav-menu {
			display: flex;
			gap: 0;
			list-style: none;
			flex: 1;
			margin-left: 40px;
		}

		.nav-menu li a {
			color: #ccc;
			text-decoration: none;
			padding: 20px 20px;
			display: block;
			transition: all 0.3s ease;
			border-bottom: 3px solid transparent;
		}

		.nav-menu li a:hover,
		.nav-menu li a.active {
			background-color: #2c7a3f;
			color: white;
			border-bottom-color: #2c7a3f;
		}

		.nav-right {
			display: flex;
			align-items: center;
			gap: 20px;
		}

		.nav-user {
			display: flex;
			align-items: center;
			gap: 10px;
			color: #ccc;
			font-size: 14px;
		}

		.nav-user .role {
			background-color: #2c7a3f;
			padding: 4px 10px;
			border-radius: 20px;
			font-size: 12px;
			font-weight: 600;
		}

		.logout-btn {
			background-color: #c33;
			color: white;
			border: none;
			padding: 8px 16px;
			border-radius: 4px;
			cursor: pointer;
			font-size: 14px;
			font-weight: 600;
			transition: background-color 0.3s ease;
		}

		.logout-btn:hover {
			background-color: #a00;
		}

		/* Main container */
		.admin-container {
			max-width: 1400px;
			margin: 30px auto;
			padding: 0 20px;
		}

		/* Alerts */
		.alert {
			padding: 15px 20px;
			border-radius: 6px;
			margin-bottom: 20px;
			border-left: 4px solid;
		}

		.alert-success {
			background-color: #efe;
			color: #060;
			border-left-color: #060;
		}

		.alert-error {
			background-color: #fee;
			color: #c33;
			border-left-color: #c33;
		}

		.alert-warning {
			background-color: #ffeaa7;
			color: #856404;
			border-left-color: #ffc107;
		}

		/* Tables */
		.table-container {
			background: white;
			border-radius: 8px;
			overflow-x: auto;
			box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
		}

		table {
			width: 100%;
			border-collapse: collapse;
		}

		table thead {
			background-color: #f9f9f9;
			border-bottom: 2px solid #e0e0e0;
		}

		table th {
			padding: 15px;
			text-align: left;
			font-weight: 600;
			color: #333;
		}

		table td {
			padding: 15px;
			border-bottom: 1px solid #e0e0e0;
		}

		table tbody tr:hover {
			background-color: #fafafa;
		}

		/* Buttons */
		.btn {
			padding: 8px 16px;
			border-radius: 4px;
			border: none;
			cursor: pointer;
			font-size: 14px;
			font-weight: 600;
			transition: all 0.3s ease;
			text-decoration: none;
			display: inline-block;
		}

		.btn-primary {
			background-color: #2c7a3f;
			color: white;
		}

		.btn-primary:hover {
			background-color: #1f5728;
		}

		.btn-secondary {
			background-color: #666;
			color: white;
		}

		.btn-secondary:hover {
			background-color: #444;
		}

		.btn-danger {
			background-color: #c33;
			color: white;
		}

		.btn-danger:hover {
			background-color: #a00;
		}

		.btn-edit {
			background-color: #0066cc;
			color: white;
			padding: 6px 12px;
			font-size: 13px;
		}

		.btn-edit:hover {
			background-color: #0052a3;
		}

		.btn-delete {
			background-color: #c33;
			color: white;
			padding: 6px 12px;
			font-size: 13px;
		}

		.btn-delete:hover {
			background-color: #a00;
		}

		.btn-view {
			background-color: #666;
			color: white;
			padding: 6px 12px;
			font-size: 13px;
		}

		.btn-view:hover {
			background-color: #444;
		}

		/* Forms */
		.form-group {
			margin-bottom: 20px;
		}

		.form-group label {
			display: block;
			margin-bottom: 8px;
			font-weight: 600;
			color: #333;
		}

		.form-group input,
		.form-group textarea,
		.form-group select {
			width: 100%;
			padding: 10px 12px;
			border: 1px solid #ddd;
			border-radius: 4px;
			font-size: 14px;
			font-family: inherit;
		}

		.form-group input:focus,
		.form-group textarea:focus,
		.form-group select:focus {
			outline: none;
			border-color: #2c7a3f;
			box-shadow: 0 0 0 3px rgba(44, 122, 63, 0.1);
		}

		.form-group textarea {
			resize: vertical;
			min-height: 150px;
		}

		.form-row {
			display: grid;
			grid-template-columns: 1fr 1fr;
			gap: 20px;
		}

		.form-actions {
			display: flex;
			gap: 10px;
			margin-top: 30px;
		}

		/* Page header */
		.page-header {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 30px;
		}

		.page-header h1 {
			font-size: 32px;
			font-weight: 700;
			color: #1a1a2e;
		}

		/* Status badge */
		.badge {
			display: inline-block;
			padding: 4px 12px;
			border-radius: 20px;
			font-size: 12px;
			font-weight: 600;
		}

		.badge-published {
			background-color: #efe;
			color: #060;
		}

		.badge-draft {
			background-color: #f0f0f0;
			color: #666;
		}

		.badge-archived {
			background-color: #fee;
			color: #c33;
		}

		/* Modal */
		.modal {
			display: none;
			position: fixed;
			z-index: 1000;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			overflow: auto;
			background-color: rgba(0, 0, 0, 0.4);
		}

		.modal.active {
			display: flex;
			align-items: center;
			justify-content: center;
		}

		.modal-content {
			background-color: white;
			padding: 30px;
			border-radius: 8px;
			width: 90%;
			max-width: 500px;
			box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
		}

		.modal-header {
			margin-bottom: 20px;
		}

		.modal-header h2 {
			margin-bottom: 10px;
		}

		.modal-close {
			float: right;
			font-size: 28px;
			font-weight: bold;
			cursor: pointer;
			color: #999;
		}

		.modal-close:hover {
			color: #000;
		}

		/* Responsive */
		@media (max-width: 768px) {
			.nav-container {
				flex-direction: column;
				gap: 10px;
			}

			.nav-menu {
				margin-left: 0;
				width: 100%;
			}

			.nav-right {
				width: 100%;
				justify-content: space-between;
		margin-bottom: 10px;
			}

			.form-row {
				grid-template-columns: 1fr;
			}

			.page-header {
				flex-direction: column;
				align-items: flex-start;
				gap: 20px;
			}
		}
	</style>
</head>
<body>
	<nav class="admin-nav">
		<div class="nav-container">
			<a href="/admin/articles" class="nav-brand">Iran Observateur</a>
			<ul class="nav-menu">
				<li><a href="/admin/articles" class="<?= strpos($_SERVER['REQUEST_URI'], '/admin/articles') === 0 ? 'active' : '' ?>">Articles</a></li>
				<li><a href="/admin/categor" class="<?= strpos($_SERVER['REQUEST_URI'], '/admin/categories') === 0 ? 'active' : '' ?>">Catégories</a></li>
			</ul>
			<div class="nav-right">
				<div class="nav-user">
					<span><?= htmlspecialchars($_SESSION['username']) ?></span>
					<span class="role"><?= htmlspecialchars($_SESSION['role']) ?></span>
				</div>
				<form method="POST" action="/logout" style="margin: 0;">
					<button type="submit" class="logout-btn">Déconnexion</button>
				</form>
			</div>
		</div>
	</nav>

	<div class="admin-container">
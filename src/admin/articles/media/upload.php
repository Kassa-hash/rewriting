<?php
session_start();
include '../../../fonction.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
	header('HTTP/1.1 403 Forbidden');
	exit('Not authorized');
}

// Handle upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
	$articleId = (int) $_POST['article_id'];
	$altText = trim($_POST['alt_text'] ?? '');

	// Validate article exists
	$article = getArticleById($articleId, false);
	if ($article === null) {
		header('HTTP/1.1 404 Not Found');
		exit('Article not found');
	}

	// Validate file
	$file = $_FILES['file'];
	$maxSize = 5 * 1024 * 1024; // 5MB

	if ($file['size'] > $maxSize) {
		header('Location: /admin/articles/edit/' . $articleId . '?error=File too large');
		exit;
	}

	// Check MIME type
	$mimeType = $file['type'];
	$allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
	if (!in_array($mimeType, $allowedMimes)) {
		header('Location: /admin/articles/edit/' . $articleId . '?error=Invalid file type');
		exit;
	}

	// Create filename
	$ext = match($mimeType) {
		'image/jpeg' => 'jpg',
		'image/png' => 'png',
		'image/gif' => 'gif',
		'image/webp' => 'webp',
		default => 'jpg'
	};

	$filename = 'article_' . $articleId . '_' . time() . '_' . uniqid() . '.' . $ext;
	$uploadPath = '../../../uploads/' . $filename;

	// Create uploads directory if not exists
	if (!is_dir('../../../uploads')) {
		mkdir('../../../uploads', 0755, true);
	}

	// Move uploaded file
	if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
		// Add to database
		$media = addMediaToArticle($articleId, $filename, $altText, $mimeType, $file['size']);

		if ($media !== null) {
			header('Location: /admin/articles/edit/' . $articleId . '?success=Image uploaded');
			exit;
		}
	}

	header('Location: /admin/articles/edit/' . $articleId . '?error=Upload failed');
	exit;
}

header('HTTP/1.1 400 Bad Request');
exit('Invalid request');
<?php
session_start();
include '../../../fonction.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
	header('HTTP/1.1 403 Forbidden');
	exit('Not authorized');
}

// Handle delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$mediaId = (int) $_POST['media_id'];
	$articleId = (int) $_POST['article_id'];

	// Get media
	$media = getMediaById($mediaId);
	if ($media === null) {
		header('Location: /admin/articles/edit/' . $articleId . '?error=Media not found');
		exit;
	}

	// Delete file from disk
	$filepath = '../../../uploads/' . $media['filename'];
	if (file_exists($filepath)) {
		unlink($filepath);
	}

	// Delete from database
	if (deleteMedia($mediaId)) {
		header('Location: /admin/articles/edit/' . $articleId . '?success=Image deleted');
		exit;
	}

	header('Location: /admin/articles/edit/' . $articleId . '?error=Failed to delete');
	exit;
}

header('HTTP/1.1 400 Bad Request');
exit('Invalid request');
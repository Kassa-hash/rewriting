<?php
session_start();
include '../../fonction.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
	header('Location: /login');
	exit;
}

$pageTitle = 'Créer un Article - Iran Observateur';
$isEdit = false;
$article = null;
$errors = [];

// Get URI parts
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$parts = explode('/', trim($uri, '/'));

// Check if editing
if (isset($parts[3]) && $parts[3] === 'edit' && isset($parts[4])) {
	$isEdit = true;
	$articleId = (int) $parts[4];
	$article = getArticleById($articleId, false);

	if ($article === null) {
		header('HTTP/1.1 404 Not Found');
		exit('Article not found');
	}

	$pageTitle = 'Éditer: ' . htmlspecialchars($article['title']) . ' - Iran Observateur';
}

// Get categories
$categories = getAllCategories(false);

// Track if article was just created
$articleCreated = false;
$successMessage = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && (!isset($_POST['action']) || $_POST['action'] !== 'add-media')) {
	$title = trim($_POST['title'] ?? '');
	$slug = trim($_POST['slug'] ?? '');
	$content = $_POST['content'] ?? '';
	$categoryId = $_POST['category_id'] !== '' ? (int) $_POST['category_id'] : null;
	$metaTitle = trim($_POST['meta_title'] ?? '');
	$metaDescription = trim($_POST['meta_description'] ?? '');
	$status = $_POST['status'] ?? 'draft';
	$publishedAt = $_POST['published_at'] ?? null;

	// Validation
	if (empty($title)) {
		$errors[] = 'Le titre est obligatoire.';
	}
	if (empty($slug)) {
		$errors[] = 'Le slug est obligatoire.';
	}
	if (empty($content)) {
		$errors[] = 'Le contenu est obligatoire.';
	}

	// Check if slug is unique (excluding current article if editing)
	$slugCheck = $isEdit
		? "SELECT id FROM articles WHERE slug = :slug AND id <> :id LIMIT 1"
		: "SELECT id FROM articles WHERE slug = :slug LIMIT 1";

	$stmt = pdoConnection()->prepare($slugCheck);
	if ($isEdit) {
		$stmt->execute([':slug' => $slug, ':id' => $articleId]);
	} else {
		$stmt->execute([':slug' => $slug]);
	}

	if ($stmt->fetch()) {
		$errors[] = 'Ce slug est déjà utilisé par un autre article.';
	}

	// If no errors, save article
	if (empty($errors)) {
		if ($isEdit) {
			$success = updateArticle(
				$articleId,
				$categoryId,
				$title,
				$slug,
				$content,
				$metaTitle,
				$metaDescription,
				$status,
				$publishedAt
			);

			if ($success) {
				header('Location: /admin/articles');
				exit;
			} else {
				$errors[] = 'Une erreur est survenue lors de la mise à jour.';
			}
		} else {
			$result = createArticle(
				(int) $_SESSION['user_id'],
				$categoryId,
				$title,
				$slug,
				$content,
				$metaTitle,
				$metaDescription,
				$status,
				$publishedAt
			);

			if ($result !== null) {
				// Don't redirect, stay on page to allow media upload
				$isEdit = true;
				$articleId = $result['id'];
				$article = getArticleById($articleId, false);
				$articleCreated = true;
				$successMessage = 'Article créé avec succès!';

				// Process media files upload if any
				if (!empty($_FILES['media_files']['tmp_name'])) {
					$maxSize = 5 * 1024 * 1024; // 5MB
					$allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
					$uploadedCount = 0;

					for ($i = 0; $i < count($_FILES['media_files']['tmp_name']); $i++) {
						$file = [
							'tmp_name' => $_FILES['media_files']['tmp_name'][$i],
							'name' => $_FILES['media_files']['name'][$i],
							'size' => $_FILES['media_files']['size'][$i],
							'type' => $_FILES['media_files']['type'][$i]
						];

						if (empty($file['tmp_name'])) continue;

						if ($file['size'] > $maxSize) {
							$errors[] = 'Fichier "' . $file['name'] . '" trop volumineux (max. 5MB).';
							continue;
						}

						if (!in_array($file['type'], $allowedMimes)) {
							$errors[] = 'Fichier "' . $file['name'] . '" : type non autorisé.';
							continue;
						}

						// Create filename
						$ext = match($file['type']) {
							'image/jpeg' => 'jpg',
							'image/png' => 'png',
							'image/gif' => 'gif',
							'image/webp' => 'webp',
							default => 'jpg'
						};

						$filename = 'article_' . $articleId . '_' . time() . '_' . uniqid() . '.' . $ext;
						$uploadPath = '../../uploads/' . $filename;

						// Create uploads directory if not exists
						if (!is_dir('../../uploads')) {
							mkdir('../../uploads', 0755, true);
						}

						// Move uploaded file
						if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
							$media = addMediaToArticle($articleId, $filename, '', $file['type'], $file['size']);
							if ($media !== null) {
								$uploadedCount++;
							}
						}
					}

					if ($uploadedCount > 0) {
						$successMessage = 'Article créé avec succès! ' . $uploadedCount . ' image(s) ajoutée(s).';
						$article = getArticleById($articleId, false);
					}
				}
			} else {
				$errors[] = 'Une erreur est survenue lors de la création.';
			}
		}
	}
}

// Handle media upload for new articles
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add-media') {
	if (!isset($_POST['article_id'])) {
		$errors[] = 'Article ID manquant.';
	} elseif (empty($_FILES['file']['tmp_name'])) {
		$errors[] = 'Veuillez sélectionner un fichier.';
	} else {
		$articleId = (int) $_POST['article_id'];
		$file = $_FILES['file'];
		$altText = trim($_POST['alt_text'] ?? '');
		$maxSize = 5 * 1024 * 1024; // 5MB

		if ($file['size'] > $maxSize) {
			$errors[] = 'Le fichier est trop volumineux (max. 5MB).';
		} else {
			// Check MIME type
			$mimeType = $file['type'];
			$allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
			if (!in_array($mimeType, $allowedMimes)) {
				$errors[] = 'Type de fichier non autorisé. Utilisez JPG, PNG, GIF ou WebP.';
			} else {
				// Create filename
				$ext = match($mimeType) {
					'image/jpeg' => 'jpg',
					'image/png' => 'png',
					'image/gif' => 'gif',
					'image/webp' => 'webp',
					default => 'jpg'
				};

				$filename = 'article_' . $articleId . '_' . time() . '_' . uniqid() . '.' . $ext;
				$uploadPath = '../../uploads/' . $filename;

				// Create uploads directory if not exists
				if (!is_dir('../../uploads')) {
					mkdir('../../uploads', 0755, true);
				}

				// Move uploaded file
				if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
					// Add to database
					$media = addMediaToArticle($articleId, $filename, $altText, $mimeType, $file['size']);

					if ($media !== null) {
						$successMessage = 'Image ajoutée avec succès!';
						$article = getArticleById($articleId, false);
					} else {
						$errors[] = 'Erreur lors de l\'enregistrement de l\'image.';
					}
				} else {
					$errors[] = 'Erreur lors de l\'upload du fichier.';
				}
			}
		}
	}
}

// Set default values
$title = $article['title'] ?? '';
$slug = $article['slug'] ?? '';
$content = $article['content'] ?? '';
$categoryId = $article['category_id'] ?? '';
$metaTitle = $article['meta_title'] ?? '';
$metaDescription = $article['meta_description'] ?? '';
$status = $article['status'] ?? 'draft';
$publishedAt = $article['published_at'] ?? '';

include '../header.php';
?>

<div class="page-header">
	<h1><?= $isEdit ? 'Éditer l\'article' : 'Créer un nouvel article' ?></h1>
	<a href="/admin/articles" class="btn btn-secondary">← Retour</a>
</div>

<?php if ($successMessage): ?>
	<div class="alert alert-success"><?= htmlspecialchars($successMessage) ?></div>
<?php endif; ?>

<?php if (!empty($errors)): ?>
	<div class="alert alert-error">
		<strong>Erreurs :</strong>
		<ul style="margin-top: 10px;">
			<?php foreach ($errors as $error): ?>
				<li><?= htmlspecialchars($error) ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php endif; ?>

<div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
	<form method="POST" action="" enctype="multipart/form-data">
		<div class="form-group">
			<label for="title">Titre</label>
			<input type="text" id="title" name="title" value="<?= htmlspecialchars($title) ?>" required autofocus>
		</div>

		<div class="form-group">
			<label for="slug">Slug (URL)</label>
			<input type="text" id="slug" name="slug" value="<?= htmlspecialchars($slug) ?>" required placeholder="ex: mon-article-titre">
		</div>

		<div class="form-row">
			<div class="form-group">
				<label for="category_id">Catégorie</label>
				<select id="category_id" name="category_id">
					<option value="">-- Sélectionner une catégorie --</option>
					<?php foreach ($categories as $cat): ?>
						<option value="<?= $cat['id'] ?>" <?= $categoryId === $cat['id'] ? 'selected' : '' ?>>
							<?= htmlspecialchars($cat['name']) ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="form-group">
				<label for="status">Statut</label>
				<select id="status" name="status" required>
					<option value="draft" <?= $status === 'draft' ? 'selected' : '' ?>>Brouillon</option>
					<option value="published" <?= $status === 'published' ? 'selected' : '' ?>>Publié</option>
					<option value="archived" <?= $status === 'archived' ? 'selected' : '' ?>>Archivé</option>
				</select>
			</div>
		</div>

		<div class="form-row">
			<div class="form-group">
				<label for="meta_title">Meta Title</label>
				<input type="text" id="meta_title" name="meta_title" value="<?= htmlspecialchars($metaTitle) ?>" maxlength="70" placeholder="Titre pour les moteurs de recherche (max. 70 caractères)">
			</div>

			<div class="form-group">
				<label for="published_at">Date de publication</label>
				<input type="datetime-local" id="published_at" name="published_at" value="<?= $publishedAt ? substr($publishedAt, 0, 16) : '' ?>">
			</div>
		</div>

		<div class="form-group">
			<label for="meta_description">Meta Description</label>
			<textarea id="meta_description" name="meta_description" maxlength="160" placeholder="Description pour les moteurs de recherche (max. 160 caractères)"><?= htmlspecialchars($metaDescription) ?></textarea>
		</div>

		<div class="form-group">
			<label for="content">Contenu</label>
			<textarea id="content" name="content" required placeholder="Contenu HTML de l'article"><?= htmlspecialchars($content) ?></textarea>
		</div>

		<div class="form-group">
			<label for="media_files">Médias (Images)</label>
			<input type="file" id="media_files" name="media_files[]" accept="image/*" multiple>
			<small style="color: #666; display: block; margin-top: 5px;">Vous pouvez ajouter plusieurs images (JPG, PNG, GIF, WebP - max. 5MB chacune)</small>
		</div>

		<div class="form-actions">
			<button type="submit" class="btn btn-primary">
				<?= $isEdit && !$articleCreated ? '💾 Mettre à jour' : '➕ Créer l\'article' ?>
			</button>
			<?php if (!$articleCreated): ?>
				<a href="/admin/articles" class="btn btn-secondary">Annuler</a>
			<?php endif; ?>
		</div>
	</form>
</div>

<?php if ($isEdit): ?>
	<div style="margin-top: 40px;">
		<h2>Médias (<?= count($article['medias'] ?? []) ?>)</h2>
		
		<?php if (!empty($article['medias'])): ?>
			<div style="background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
				<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 20px;">
					<?php foreach ($article['medias'] as $media): ?>
						<div style="border: 1px solid #ddd; border-radius: 4px; overflow: hidden;">
							<img src="/uploads/<?= htmlspecialchars($media['filename']) ?>" style="width: 100%; height: 120px; object-fit: cover;">
							<div style="padding: 10px;">
								<small style="color: #666;"><?= htmlspecialchars($media['filename']) ?></small>
								<br>
								<form method="POST" action="/admin/articles/media/delete" style="margin-top: 5px;" onsubmit="return confirm('Supprimer cette image ?');">
									<input type="hidden" name="media_id" value="<?= $media['id'] ?>">
									<input type="hidden" name="article_id" value="<?= $articleId ?>">
									<button type="submit" class="btn btn-delete" style="width: 100%; text-align: center;">Supprimer</button>
								</form>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>

		<div style="background: #f0f0f0; padding: 20px; border-radius: 8px;">
			<h3><?= empty($article['medias']) ? 'Ajouter des images' : 'Ajouter une autre image' ?></h3>
			<form method="POST" action="" enctype="multipart/form-data" style="margin-top: 15px;">
				<input type="hidden" name="action" value="add-media">
				<input type="hidden" name="article_id" value="<?= $articleId ?>">
				<div class="form-group">
					<label for="file">Fichier image</label>
					<input type="file" id="file" name="file" accept="image/*" required>
				</div>
				<div class="form-group">
					<label for="alt_text">Texte alternatif (optionnel)</label>
					<input type="text" id="alt_text" name="alt_text" placeholder="Description de l'image pour l'accessibilité">
				</div>
				<button type="submit" class="btn btn-primary">➕ Ajouter l'image</button>
			</form>
		</div>
	</div>
<?php endif; ?>

</div> <!-- /admin-container -->
<script src="/lazy-load.js"></script>

</body>
</html>
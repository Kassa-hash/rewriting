<?php
session_start();
include '../../fonction.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
	header('Location: /login');
	exit;
}

$pageTitle = 'Créer une Catégorie - Iran Observateur';
$isEdit = false;
$category = null;
$errors = [];

// Get URI parts
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$parts = explode('/', trim($uri, '/'));

// Check if editing
if (isset($parts[3]) && $parts[3] === 'edit' && isset($parts[4])) {
	$isEdit = true;
	$categoryId = (int) $parts[4];
	$category = getCategoryById($categoryId);

	if ($category === null) {
		header('HTTP/1.1 404 Not Found');
		exit('Category not found');
	}

	$pageTitle = 'Éditer: ' . htmlspecialchars($category['name']) . ' - Iran Observateur';
}

// Get all categories for parent selection
$allCategories = getAllCategories(false);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$name = trim($_POST['name'] ?? '');
	$slug = trim($_POST['slug'] ?? '');
	$description = trim($_POST['description'] ?? '');
	$parentId = $_POST['parent_id'] !== '' ? (int) $_POST['parent_id'] : null;

	// Validation
	if (empty($name)) {
		$errors[] = 'Le nom est obligatoire.';
	}
	if (empty($slug)) {
		$errors[] = 'Le slug est obligatoire.';
	}

	// Check if slug is unique (excluding current category if editing)
	$slugCheck = $isEdit
		? "SELECT id FROM categories WHERE slug = :slug AND id <> :id LIMIT 1"
		: "SELECT id FROM categories WHERE slug = :slug LIMIT 1";

	$stmt = pdoConnection()->prepare($slugCheck);
	if ($isEdit) {
		$stmt->execute([':slug' => $slug, ':id' => $categoryId]);
	} else {
		$stmt->execute([':slug' => $slug]);
	}

	if ($stmt->fetch()) {
		$errors[] = 'Ce slug est déjà utilisé par une autre catégorie.';
	}

	// Prevent category from being its own parent
	if ($isEdit && $parentId === $categoryId) {
		$errors[] = 'Une catégorie ne peut pas être sa propre parent.';
	}

	// If no errors, save category
	if (empty($errors)) {
		if ($isEdit) {
			$success = updateCategory($categoryId, $name, $slug, $description, $parentId);

			if ($success) {
				header('Location: /admin/categories');
				exit;
			} else {
				$errors[] = 'Une erreur est survenue lors de la mise à jour.';
			}
		} else {
			$result = createCategory($name, $slug, $description, $parentId);

			if ($result !== null) {
				header('Location: /admin/categories');
				exit;
			} else {
				$errors[] = 'Une erreur est survenue lors de la création.';
			}
		}
	}
}

// Set default values
$name = $category['name'] ?? '';
$slug = $category['slug'] ?? '';
$description = $category['description'] ?? '';
$parentId = $category['parent_id'] ?? '';

include '../header.php';
?>

<div class="page-header">
	<h1><?= $isEdit ? 'Éditer la catégorie' : 'Créer une nouvelle catégorie' ?></h1>
	<a href="/admin/categories" class="btn btn-secondary">← Retour</a>
</div>

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
	<form method="POST" action="">
		<div class="form-group">
			<label for="name">Nom</label>
			<input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>" required autofocus>
		</div>

		<div class="form-group">
			<label for="slug">Slug (URL)</label>
			<input type="text" id="slug" name="slug" value="<?= htmlspecialchars($slug) ?>" required placeholder="ex: politique">
		</div>

		<div class="form-group">
			<label for="parent_id">Catégorie parent (optionnel)</label>
			<select id="parent_id" name="parent_id">
				<option value="">-- Aucune (catégorie principale) --</option>
				<?php foreach ($allCategories as $cat): ?>
					<?php if (!$isEdit || $cat['id'] !== $categoryId): ?>
						<option value="<?= $cat['id'] ?>" <?= $parentId === $cat['id'] ? 'selected' : '' ?>>
							<?= htmlspecialchars($cat['name']) ?>
						</option>
					<?php endif; ?>
				<?php endforeach; ?>
			</select>
		</div>

		<div class="form-group">
			<label for="description">Description</label>
			<textarea id="description" name="description" placeholder="Description de la catégorie"><?= htmlspecialchars($description) ?></textarea>
		</div>

		<div class="form-actions">
			<button type="submit" class="btn btn-primary">
				<?= $isEdit ? '💾 Mettre à jour' : '➕ Créer la catégorie' ?>
			</button>
			<a href="/admin/categories" class="btn btn-secondary">Annuler</a>
		</div>
	</form>
</div>

</div> <!-- /admin-container -->
<script src="/lazy-load.js"></script>

</body>
</html>
<?php
session_start();
include '../fonction.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
	header('Location: /login');
	exit;
}

$pageTitle = 'Gestion des Catégories - Iran Observateur';

// Get all categories
$categories = getAllCategories(false);

// Get article counts for each category
$categoryCounts = [];
foreach ($categories as $cat) {
	$categoryCounts[$cat['id']] = countArticlesByCategory($cat['id']);
}

// Handle delete action
$deleteSuccess = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
	$categoryId = (int) $_POST['category_id'];
	
	// Check if category has articles
	$articleCount = countArticlesByCategory($categoryId);
	if ($articleCount > 0) {
		$deleteError = 'Cette catégorie contient ' . $articleCount . ' article(s) et ne peut pas être supprimée.';
	} else {
		if (deleteCategory($categoryId)) {
			$deleteSuccess = true;
			header('Location: /admin/categories');
			exit;
		} else {
			$deleteError = 'Erreur lors de la suppression.';
		}
	}
}

include 'header.php';
?>

<div class="page-header">
	<h1>Gestion des Catégories</h1>
	<a href="/admin/categories/create" class="btn btn-primary">+ Nouvelle Catégorie</a>
</div>

<?php if ($deleteSuccess): ?>
	<div class="alert alert-success">Catégorie supprimée avec succès.</div>
<?php endif; ?>

<?php if (isset($deleteError)): ?>
	<div class="alert alert-error"><?= htmlspecialchars($deleteError) ?></div>
<?php endif; ?>

<!-- Categories Table -->
<div class="table-container">
	<table>
		<thead>
			<tr>
				<th>Nom</th>
				<th>Slug</th>
				<th>Articles</th>
				<th>Description</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php if (empty($categories)): ?>
				<tr>
					<td colspan="5" style="text-align: center; padding: 30px;">Aucune catégorie trouvée.</td>
				</tr>
			<?php else: ?>
				<?php foreach ($categories as $category): ?>
					<tr>
						<td>
							<strong><?= htmlspecialchars($category['name']) ?></strong>
						</td>
						<td>
							<code style="background: #f0f0f0; padding: 4px 8px; border-radius: 3px;">
								<?= htmlspecialchars($category['slug']) ?>
							</code>
						</td>
						<td>
							<span class="badge badge-published">
								<?= $categoryCounts[$category['id']] ?? 0 ?>
							</span>
						</td>
						<td>
							<?php if ($category['description']): ?>
								<small><?= htmlspecialchars(substr($category['description'], 0, 80)) ?></small>
							<?php else: ?>
								<small style="color: #999;">-</small>
							<?php endif; ?>
						</td>
						<td>
							<a href="/admin/categories/edit/<?= $category['id'] ?>" class="btn btn-edit">Éditer</a>
							<form method="POST" style="display: inline;">
								<input type="hidden" name="action" value="delete">
								<input type="hidden" name="category_id" value="<?= $category['id'] ?>">
								<button type="submit" class="btn btn-delete" onclick="return confirm('Êtes-vous sûr ? Cette catégorie doit être vide pour être supprimée.');">Supprimer</button>
							</form>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
</div>

</div> <!-- /admin-container -->
<script src="/lazy-load.js"></script>

</body>
</html>
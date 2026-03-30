<?php
session_start();
include '../fonction.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
	header('Location: /login');
	exit;
}

$pageTitle = 'Gestion des Articles - Iran Observateur';

// Get current page
$page = (int) ($_GET['page'] ?? 1);
if ($page < 1) $page = 1;

$limit = 20;
$offset = ($page - 1) * $limit;

// Get filter
$filter = $_GET['filter'] ?? 'all';
$validFilters = ['all', 'draft', 'published', 'archived'];
if (!in_array($filter, $validFilters)) {
	$filter = 'all';
}

// Get articles
if ($filter === 'all') {
	$articles = getAllArticles($limit, $offset);
	$total = countAllArticles();
} else {
	$articles = getArticlesByStatus($filter, $limit, $offset);
	$total = countArticlesByStatus($filter);
}

$totalPages = ceil($total / $limit);

// Handle delete action
$deleteSuccess = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
	$articleId = (int) $_POST['article_id'];
	if (deleteArticle($articleId)) {
		$deleteSuccess = true;
		header('Location: /admin/articles?filter=' . urlencode($filter));
		exit;
	}
}

include 'header.php';
?>

<div class="page-header">
	<h1>Gestion des Articles</h1>
	<a href="/admin/articles/create" class="btn btn-primary">+ Nouvel Article</a>
</div>

<?php if ($deleteSuccess): ?>
	<div class="alert alert-success">Article supprimé avec succès.</div>
<?php endif; ?>

<!-- Filters -->
<div style="margin-bottom: 20px; display: flex; gap: 10px; flex-wrap: wrap;">
	<a href="/admin/articles?filter=all" class="btn <?= $filter === 'all' ? 'btn-primary' : 'btn-secondary' ?>">Tous (<?= countAllArticles() ?>)</a>
	<a href="/admin/articles?filter=draft" class="btn <?= $filter === 'draft' ? 'btn-primary' : 'btn-secondary' ?>">Brouillons (<?= countArticlesByStatus('draft') ?>)</a>
	<a href="/admin/articles?filter=published" class="btn <?= $filter === 'published' ? 'btn-primary' : 'btn-secondary' ?>">Publiés (<?= countArticlesByStatus('published') ?>)</a>
	<a href="/admin/articles?filter=archived" class="btn <?= $filter === 'archived' ? 'btn-primary' : 'btn-secondary' ?>">Archivés (<?= countArticlesByStatus('archived') ?>)</a>
</div>

<!-- Articles Table -->
<div class="table-container">
	<table>
		<thead>
			<tr>
				<th>Titre</th>
				<th>Catégorie</th>
				<th>Auteur</th>
				<th>Statut</th>
				<th>Créé</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php if (empty($articles)): ?>
				<tr>
					<td colspan="6" style="text-align: center; padding: 30px;">Aucun article trouvé.</td>
				</tr>
			<?php else: ?>
				<?php foreach ($articles as $article): ?>
					<tr>
						<td>
							<strong><?= htmlspecialchars($article['title']) ?></strong><br>
							<small style="color: #666;"><?= htmlspecialchars($article['slug']) ?></small>
						</td>
						<td><?= htmlspecialchars($article['category_name'] ?? '-') ?></td>
						<td><?= htmlspecialchars($article['author_username']) ?></td>
						<td>
							<?php
							$statusClass = 'badge-' . $article['status'];
							$statusText = ucfirst($article['status']);
							if ($article['status'] === 'draft') $statusText = 'Brouillon';
							elseif ($article['status'] === 'published') $statusText = 'Publié';
							elseif ($article['status'] === 'archived') $statusText = 'Archivé';
							?>
							<span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
						</td>
						<td><?= date('d/m/Y H:i', strtotime($article['created_at'])) ?></td>
						<td>
							<a href="/admin/articles/edit/<?= $article['id'] ?>" class="btn btn-edit">Éditer</a>
							<a href="/article/<?= urlencode($article['slug']) ?>" target="_blank" class="btn btn-view">Voir</a>
							<form method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr ? Cette action est irréversible.');">
								<input type="hidden" name="action" value="delete">
								<input type="hidden" name="article_id" value="<?= $article['id'] ?>">
								<button type="submit" class="btn btn-delete">Supprimer</button>
							</form>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
</div>

<!-- Pagination -->
<?php if ($totalPages > 1): ?>
	<div style="margin-top: 30px; display: flex; justify-content: center; gap: 10px; flex-wrap: wrap;">
		<?php for ($i = 1; $i <= $totalPages; $i++): ?>
			<a href="/admin/articles?filter=<?= urlencode($filter) ?>&page=<?= $i ?>" 
			   class="btn <?= $page === $i ? 'btn-primary' : 'btn-secondary' ?>"
			   style="min-width: 40px; text-align: center;">
				<?= $i ?>
			</a>
		<?php endfor; ?>
	</div>
<?php endif; ?>

</div> <!-- /admin-container -->
<script src="/lazy-load.js"></script>

</body>
</html>
<?php
include 'bdconnection.php';


function pdoConnection(): PDO
{
	global $pdo;
	return $pdo;
}

function fetchAllRows(string $sql, array $params = []): array
{
	$stmt = pdoConnection()->prepare($sql);
	$stmt->execute($params);
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function fetchOneRow(string $sql, array $params = []): ?array
{
	$stmt = pdoConnection()->prepare($sql);
	$stmt->execute($params);
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	return $row === false ? null : $row;
}

function executeQuery(string $sql, array $params = []): bool
{
	$stmt = pdoConnection()->prepare($sql);
	return $stmt->execute($params);
}

function getSiteStats(): array
{
	$sql = "
		SELECT
			(SELECT COUNT(*) FROM users) AS nb_users,
			(SELECT COUNT(*) FROM categories) AS nb_categories,
			(SELECT COUNT(*) FROM articles) AS nb_articles,
			(SELECT COUNT(*) FROM tags) AS nb_tags,
			(SELECT COUNT(*) FROM medias) AS nb_medias,
			(SELECT COUNT(*) FROM articles WHERE status = 'published') AS nb_articles_published
	";

	return fetchOneRow($sql) ?? [];
}

function getAllCategories(bool $withArticleCount = true): array
{
	if (!$withArticleCount) {
		$sql = "
			SELECT id, name, slug, description, parent_id
			FROM categories
			ORDER BY name ASC
		";
		return fetchAllRows($sql);
	}

	$sql = "
		SELECT
			c.id,
			c.name,
			c.slug,
			c.description,
			c.parent_id,
			COUNT(a.id) FILTER (WHERE a.status = 'published')::INT AS articles_count
		FROM categories c
		LEFT JOIN articles a ON a.category_id = c.id
		GROUP BY c.id, c.name, c.slug, c.description, c.parent_id
		ORDER BY c.name ASC
	";

	return fetchAllRows($sql);
}

function getCategoryById(int $id): ?array
{
	$sql = "
		SELECT id, name, slug, description, parent_id
		FROM categories
		WHERE id = :id
	";

	return fetchOneRow($sql, [':id' => $id]);
}

function getCategoryBySlug(string $slug): ?array
{
	$sql = "
		SELECT id, name, slug, description, parent_id
		FROM categories
		WHERE slug = :slug
	";

	return fetchOneRow($sql, [':slug' => $slug]);
}

function getSubCategories(int $parentId): array
{
	$sql = "
		SELECT id, name, slug, description, parent_id
		FROM categories
		WHERE parent_id = :parent_id
		ORDER BY name ASC
	";

	return fetchAllRows($sql, [':parent_id' => $parentId]);
}

function getTags(bool $withArticleCount = true): array
{
	if (!$withArticleCount) {
		$sql = "
			SELECT id, name, slug
			FROM tags
			ORDER BY name ASC
		";
		return fetchAllRows($sql);
	}

	$sql = "
		SELECT
			t.id,
			t.name,
			t.slug,
			COUNT(at.article_id) FILTER (WHERE a.status = 'published')::INT AS articles_count
		FROM tags t
		LEFT JOIN article_tags at ON at.tag_id = t.id
		LEFT JOIN articles a ON a.id = at.article_id
		GROUP BY t.id, t.name, t.slug
		ORDER BY t.name ASC
	";

	return fetchAllRows($sql);
}

function getTagBySlug(string $slug): ?array
{
	$sql = "
		SELECT id, name, slug
		FROM tags
		WHERE slug = :slug
	";

	return fetchOneRow($sql, [':slug' => $slug]);
}

function getArticleTags(int $articleId): array
{
	$sql = "
		SELECT t.id, t.name, t.slug
		FROM tags t
		INNER JOIN article_tags at ON at.tag_id = t.id
		WHERE at.article_id = :article_id
		ORDER BY t.name ASC
	";

	return fetchAllRows($sql, [':article_id' => $articleId]);
}

function getArticleMedia(int $articleId): array
{
	$sql = "
		SELECT id, article_id, filename, alt_text, mime_type, file_size, uploaded_at
		FROM medias
		WHERE article_id = :article_id
		ORDER BY uploaded_at ASC, id ASC
	";

	return fetchAllRows($sql, [':article_id' => $articleId]);
}

function getPrimaryArticleMedia(int $articleId): ?array
{
	$sql = "
		SELECT id, article_id, filename, alt_text, mime_type, file_size, uploaded_at
		FROM medias
		WHERE article_id = :article_id
		ORDER BY uploaded_at ASC, id ASC
		LIMIT 1
	";

	return fetchOneRow($sql, [':article_id' => $articleId]);
}

function getArticleById(int $id, bool $publishedOnly = false): ?array
{
	$sql = "
		SELECT
			a.id,
			a.user_id,
			a.category_id,
			a.title,
			a.slug,
			a.content,
			a.meta_title,
			a.meta_description,
			a.status,
			a.published_at,
			a.created_at,
			a.updated_at,
			u.username AS author_username,
			u.email AS author_email,
			c.name AS category_name,
			c.slug AS category_slug
		FROM articles a
		INNER JOIN users u ON u.id = a.user_id
		LEFT JOIN categories c ON c.id = a.category_id
		WHERE a.id = :id
	";

	if ($publishedOnly) {
		$sql .= " AND a.status = 'published'";
	}

	$article = fetchOneRow($sql, [':id' => $id]);

	if ($article === null) {
		return null;
	}

	$article['tags'] = getArticleTags((int) $article['id']);
	$article['medias'] = getArticleMedia((int) $article['id']);

	return $article;
}

function getArticleBySlug(string $slug, bool $publishedOnly = true): ?array
{
	$sql = "
		SELECT
			a.id,
			a.user_id,
			a.category_id,
			a.title,
			a.slug,
			a.content,
			a.meta_title,
			a.meta_description,
			a.status,
			a.published_at,
			a.created_at,
			a.updated_at,
			u.username AS author_username,
			u.email AS author_email,
			c.name AS category_name,
			c.slug AS category_slug
		FROM articles a
		INNER JOIN users u ON u.id = a.user_id
		LEFT JOIN categories c ON c.id = a.category_id
		WHERE a.slug = :slug
	";

	if ($publishedOnly) {
		$sql .= " AND a.status = 'published'";
	}

	$article = fetchOneRow($sql, [':slug' => $slug]);

	if ($article === null) {
		return null;
	}

	$article['tags'] = getArticleTags((int) $article['id']);
	$article['medias'] = getArticleMedia((int) $article['id']);

	return $article;
}

function getPublishedArticles(int $limit = 10, int $offset = 0): array
{
	$limit = max(1, $limit);
	$offset = max(0, $offset);

	$sql = "
		SELECT
			a.id,
			a.user_id,
			a.category_id,
			a.title,
			a.slug,
			a.content,
			a.meta_title,
			a.meta_description,
			a.status,
			a.published_at,
			a.created_at,
			a.updated_at,
			u.username AS author_username,
			c.name AS category_name,
			c.slug AS category_slug,
			m.filename AS media_filename,
			m.alt_text AS media_alt_text,
			m.mime_type AS media_mime_type
		FROM articles a
		INNER JOIN users u ON u.id = a.user_id
		LEFT JOIN categories c ON c.id = a.category_id
		LEFT JOIN LATERAL (
			SELECT filename, alt_text, mime_type
			FROM medias
			WHERE article_id = a.id
			ORDER BY uploaded_at ASC, id ASC
			LIMIT 1
		) m ON true
		WHERE a.status = 'published'
		ORDER BY a.published_at DESC NULLS LAST, a.created_at DESC
		LIMIT :limit OFFSET :offset
	";

	$stmt = pdoConnection()->prepare($sql);
	$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
	$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
	$stmt->execute();

	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getLatestPublishedArticle(): ?array
{
	$articles = getPublishedArticles(1, 0);
	return $articles[0] ?? null;
}

function getArticlesByCategorySlug(string $categorySlug, int $limit = 20, int $offset = 0): array
{
	$limit = max(1, $limit);
	$offset = max(0, $offset);

	$sql = "
		SELECT
			a.id,
			a.user_id,
			a.category_id,
			a.title,
			a.slug,
			a.content,
			a.meta_title,
			a.meta_description,
			a.status,
			a.published_at,
			a.created_at,
			a.updated_at,
			u.username AS author_username,
			c.name AS category_name,
			c.slug AS category_slug,
			m.filename AS media_filename,
			m.alt_text AS media_alt_text,
			m.mime_type AS media_mime_type
		FROM articles a
		INNER JOIN users u ON u.id = a.user_id
		INNER JOIN categories c ON c.id = a.category_id
		LEFT JOIN LATERAL (
			SELECT filename, alt_text, mime_type
			FROM medias
			WHERE article_id = a.id
			ORDER BY uploaded_at ASC, id ASC
			LIMIT 1
		) m ON true
		WHERE a.status = 'published'
		  AND c.slug = :category_slug
		ORDER BY a.published_at DESC NULLS LAST, a.created_at DESC
		LIMIT :limit OFFSET :offset
	";

	$stmt = pdoConnection()->prepare($sql);
	$stmt->bindValue(':category_slug', $categorySlug, PDO::PARAM_STR);
	$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
	$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
	$stmt->execute();

	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getArticlesByTagSlug(string $tagSlug, int $limit = 20, int $offset = 0): array
{
	$limit = max(1, $limit);
	$offset = max(0, $offset);

	$sql = "
		SELECT
			a.id,
			a.user_id,
			a.category_id,
			a.title,
			a.slug,
			a.content,
			a.meta_title,
			a.meta_description,
			a.status,
			a.published_at,
			a.created_at,
			a.updated_at,
			u.username AS author_username,
			c.name AS category_name,
			c.slug AS category_slug,
			m.filename AS media_filename,
			m.alt_text AS media_alt_text,
			m.mime_type AS media_mime_type
		FROM articles a
		INNER JOIN users u ON u.id = a.user_id
		LEFT JOIN categories c ON c.id = a.category_id
		INNER JOIN article_tags at ON at.article_id = a.id
		INNER JOIN tags t ON t.id = at.tag_id
		LEFT JOIN LATERAL (
			SELECT filename, alt_text, mime_type
			FROM medias
			WHERE article_id = a.id
			ORDER BY uploaded_at ASC, id ASC
			LIMIT 1
		) m ON true
		WHERE a.status = 'published'
		  AND t.slug = :tag_slug
		ORDER BY a.published_at DESC NULLS LAST, a.created_at DESC
		LIMIT :limit OFFSET :offset
	";

	$stmt = pdoConnection()->prepare($sql);
	$stmt->bindValue(':tag_slug', $tagSlug, PDO::PARAM_STR);
	$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
	$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
	$stmt->execute();

	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function searchPublishedArticles(string $term, int $limit = 20, int $offset = 0): array
{
	$limit = max(1, $limit);
	$offset = max(0, $offset);
	$needle = '%' . trim($term) . '%';

	$sql = "
		SELECT
			a.id,
			a.user_id,
			a.category_id,
			a.title,
			a.slug,
			a.content,
			a.meta_title,
			a.meta_description,
			a.status,
			a.published_at,
			a.created_at,
			a.updated_at,
			u.username AS author_username,
			c.name AS category_name,
			c.slug AS category_slug,
			m.filename AS media_filename,
			m.alt_text AS media_alt_text,
			m.mime_type AS media_mime_type
		FROM articles a
		INNER JOIN users u ON u.id = a.user_id
		LEFT JOIN categories c ON c.id = a.category_id
		LEFT JOIN LATERAL (
			SELECT filename, alt_text, mime_type
			FROM medias
			WHERE article_id = a.id
			ORDER BY uploaded_at ASC, id ASC
			LIMIT 1
		) m ON true
		WHERE a.status = 'published'
		  AND (
			a.title ILIKE :needle
			OR a.content ILIKE :needle
			OR a.meta_title ILIKE :needle
			OR a.meta_description ILIKE :needle
		  )
		ORDER BY a.published_at DESC NULLS LAST, a.created_at DESC
		LIMIT :limit OFFSET :offset
	";

	$stmt = pdoConnection()->prepare($sql);
	$stmt->bindValue(':needle', $needle, PDO::PARAM_STR);
	$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
	$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
	$stmt->execute();

	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getRelatedPublishedArticles(int $articleId, ?int $categoryId, int $limit = 4): array
{
	$limit = max(1, $limit);

	if ($categoryId !== null) {
		$sql = "
			SELECT
				a.id,
				a.title,
				a.slug,
				a.meta_description,
				a.published_at,
				c.name AS category_name,
				c.slug AS category_slug
			FROM articles a
			LEFT JOIN categories c ON c.id = a.category_id
			WHERE a.status = 'published'
			  AND a.id <> :article_id
			  AND a.category_id = :category_id
			ORDER BY a.published_at DESC NULLS LAST
			LIMIT :limit
		";

		$stmt = pdoConnection()->prepare($sql);
		$stmt->bindValue(':article_id', $articleId, PDO::PARAM_INT);
		$stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
		$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	$sql = "
		SELECT
			a.id,
			a.title,
			a.slug,
			a.meta_description,
			a.published_at,
			c.name AS category_name,
			c.slug AS category_slug
		FROM articles a
		LEFT JOIN categories c ON c.id = a.category_id
		WHERE a.status = 'published'
		  AND a.id <> :article_id
		ORDER BY a.published_at DESC NULLS LAST
		LIMIT :limit
	";

	$stmt = pdoConnection()->prepare($sql);
	$stmt->bindValue(':article_id', $articleId, PDO::PARAM_INT);
	$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
	$stmt->execute();

	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function countPublishedArticlesByCategorySlug(string $categorySlug): int
{
	$sql = "
		SELECT COUNT(*)::INT AS total
		FROM articles a
		INNER JOIN categories c ON c.id = a.category_id
		WHERE a.status = 'published'
		  AND c.slug = :category_slug
	";

	$row = fetchOneRow($sql, [':category_slug' => $categorySlug]);
	return (int) ($row['total'] ?? 0);
}

function countPublishedArticlesByTagSlug(string $tagSlug): int
{
	$sql = "
		SELECT COUNT(*)::INT AS total
		FROM articles a
		INNER JOIN article_tags at ON at.article_id = a.id
		INNER JOIN tags t ON t.id = at.tag_id
		WHERE a.status = 'published'
		  AND t.slug = :tag_slug
	";

	$row = fetchOneRow($sql, [':tag_slug' => $tagSlug]);
	return (int) ($row['total'] ?? 0);
}

function getAllUsers(): array
{
	$sql = "
		SELECT id, username, email, role, created_at
		FROM users
		ORDER BY created_at DESC
	";

	return fetchAllRows($sql);
}

function getUserById(int $id): ?array
{
	$sql = "
		SELECT id, username, email, role, created_at
		FROM users
		WHERE id = :id
	";

	return fetchOneRow($sql, [':id' => $id]);
}

// ============================================================
// AUTHENTICATION FUNCTIONS
// ============================================================

function getUserByUsername(string $username): ?array
{
	$sql = "
		SELECT id, username, email, password_hash, role, created_at
		FROM users
		WHERE username = :username
	";

	return fetchOneRow($sql, [':username' => $username]);
}

function validateLogin(string $username, string $password): ?array
{
	$user = getUserByUsername($username);

	if ($user === null) {
		return null;
	}

	// Simple password validation (in production, use password_verify with bcrypt)
	if ($user['password_hash'] === $password) {
		unset($user['password_hash']);
		return $user;
	}

	return null;
}

// ============================================================
// ARTICLE MANAGEMENT FUNCTIONS (CRUD)
// ============================================================

function getAllArticles(int $limit = 50, int $offset = 0): array
{
	$limit = max(1, $limit);
	$offset = max(0, $offset);

	$sql = "
		SELECT
			a.id,
			a.user_id,
			a.category_id,
			a.title,
			a.slug,
			a.content,
			a.meta_title,
			a.meta_description,
			a.status,
			a.published_at,
			a.created_at,
			a.updated_at,
			u.username AS author_username,
			c.name AS category_name
		FROM articles a
		INNER JOIN users u ON u.id = a.user_id
		LEFT JOIN categories c ON c.id = a.category_id
		ORDER BY a.created_at DESC
		LIMIT :limit OFFSET :offset
	";

	$stmt = pdoConnection()->prepare($sql);
	$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
	$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
	$stmt->execute();

	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getArticlesByStatus(string $status, int $limit = 50, int $offset = 0): array
{
	$limit = max(1, $limit);
	$offset = max(0, $offset);
	$validStatuses = ['draft', 'published', 'archived'];

	if (!in_array($status, $validStatuses)) {
		return [];
	}

	$sql = "
		SELECT
			a.id,
			a.user_id,
			a.category_id,
			a.title,
			a.slug,
			a.content,
			a.meta_title,
			a.meta_description,
			a.status,
			a.published_at,
			a.created_at,
			a.updated_at,
			u.username AS author_username,
			c.name AS category_name
		FROM articles a
		INNER JOIN users u ON u.id = a.user_id
		LEFT JOIN categories c ON c.id = a.category_id
		WHERE a.status = :status
		ORDER BY a.created_at DESC
		LIMIT :limit OFFSET :offset
	";

	$stmt = pdoConnection()->prepare($sql);
	$stmt->bindValue(':status', $status, PDO::PARAM_STR);
	$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
	$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
	$stmt->execute();

	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function countAllArticles(): int
{
	$sql = "SELECT COUNT(*)::INT AS total FROM articles";
	$row = fetchOneRow($sql);
	return (int) ($row['total'] ?? 0);
}

function countArticlesByStatus(string $status): int
{
	$validStatuses = ['draft', 'published', 'archived'];

	if (!in_array($status, $validStatuses)) {
		return 0;
	}

	$sql = "SELECT COUNT(*)::INT AS total FROM articles WHERE status = :status";
	$row = fetchOneRow($sql, [':status' => $status]);
	return (int) ($row['total'] ?? 0);
}

function createArticle(
	int $userId,
	?int $categoryId,
	string $title,
	string $slug,
	string $content,
	?string $metaTitle = null,
	?string $metaDescription = null,
	string $status = 'draft',
	?string $publishedAt = null
): ?array
{
	$sql = "
		INSERT INTO articles (user_id, category_id, title, slug, content, meta_title, meta_description, status, published_at)
		VALUES (:user_id, :category_id, :title, :slug, :content, :meta_title, :meta_description, :status, :published_at)
		RETURNING id, user_id, category_id, title, slug, content, meta_title, meta_description, status, published_at, created_at, updated_at
	";

	$stmt = pdoConnection()->prepare($sql);
	$stmt->execute([
		':user_id' => $userId,
		':category_id' => $categoryId,
		':title' => $title,
		':slug' => $slug,
		':content' => $content,
		':meta_title' => $metaTitle,
		':meta_description' => $metaDescription,
		':status' => $status,
		':published_at' => $publishedAt
	]);

	return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

function updateArticle(
	int $articleId,
	?int $categoryId,
	string $title,
	string $slug,
	string $content,
	?string $metaTitle = null,
	?string $metaDescription = null,
	string $status = 'draft',
	?string $publishedAt = null
): bool
{
	$sql = "
		UPDATE articles
		SET category_id = :category_id,
			title = :title,
			slug = :slug,
			content = :content,
			meta_title = :meta_title,
			meta_description = :meta_description,
			status = :status,
			published_at = :published_at,
			updated_at = NOW()
		WHERE id = :id
	";

	$stmt = pdoConnection()->prepare($sql);
	return $stmt->execute([
		':id' => $articleId,
		':category_id' => $categoryId,
		':title' => $title,
		':slug' => $slug,
		':content' => $content,
		':meta_title' => $metaTitle,
		':meta_description' => $metaDescription,
		':status' => $status,
		':published_at' => $publishedAt
	]);
}

function deleteArticle(int $articleId): bool
{
	$sql = "DELETE FROM articles WHERE id = :id";
	return executeQuery($sql, [':id' => $articleId]);
}

function getMediaById(int $mediaId): ?array
{
	$sql = "
		SELECT id, article_id, filename, alt_text, mime_type, file_size, uploaded_at
		FROM medias
		WHERE id = :id
	";

	return fetchOneRow($sql, [':id' => $mediaId]);
}

function addMediaToArticle(int $articleId, string $filename, string $altText = '', string $mimeType = 'image/jpeg', ?int $fileSize = null): ?array
{
	$sql = "
		INSERT INTO medias (article_id, filename, alt_text, mime_type, file_size)
		VALUES (:article_id, :filename, :alt_text, :mime_type, :file_size)
		RETURNING id, article_id, filename, alt_text, mime_type, file_size, uploaded_at
	";

	$stmt = pdoConnection()->prepare($sql);
	$stmt->execute([
		':article_id' => $articleId,
		':filename' => $filename,
		':alt_text' => $altText,
		':mime_type' => $mimeType,
		':file_size' => $fileSize
	]);

	return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

function deleteMedia(int $mediaId): bool
{
	$sql = "DELETE FROM medias WHERE id = :id";
	return executeQuery($sql, [':id' => $mediaId]);
}


?>

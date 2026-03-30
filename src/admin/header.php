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
    <link rel="stylesheet" href="/admin/admin.css">
</head>
<body>

<header class="admin-header">

    <!-- Topbar -->
    <div class="admin-topbar">
        <span>⬡ Espace Administration</span>
        <div class="admin-topbar-user">
            <span class="topbar-username"><?= htmlspecialchars($_SESSION['username']) ?></span>
            <span class="topbar-sep">·</span>
            <span class="topbar-role"><?= htmlspecialchars($_SESSION['role']) ?></span>
            <span class="topbar-sep">·</span>
            <form method="POST" action="/logout" style="display:inline;margin:0;">
                <button type="submit" class="logout-btn">Déconnexion ↩</button>
            </form>
        </div>
    </div>

    <!-- Brand bar -->
    <div class="admin-brand-bar">
        <a href="/admin/articles" class="admin-brand">
            Iran <span>Observateur</span>
            <em>Administration</em>
        </a>
    </div>

    <!-- Nav -->
    <nav class="admin-nav" aria-label="Navigation administration">
        <a href="/admin/articles"
           class="<?= strpos($_SERVER['REQUEST_URI'], '/admin/articles') === 0 ? 'active' : '' ?>">
            Articles
        </a>
        <a href="/admin/categories"
           class="<?= strpos($_SERVER['REQUEST_URI'], '/admin/categories') === 0 ? 'active' : '' ?>">
            Catégories
        </a>
    </nav>

</header>

<div class="admin-container">
<?php
    include 'fonction.php';
    
    // Récupérer la catégorie par slug ou ID
    $slug = $_GET['slug'] ?? null;
    $id = $_GET['id'] ?? null;
    
    $category = null;
    if ($slug) {
        $category = getCategoryBySlug($slug);
    } elseif ($id) {
        $category = getCategoryById((int)$id);
    }
    
    // Redirection si catégorie non trouvée
    if (!$category) {
        header('Location: index.php');
        exit;
    }
    
    // Pagination
    $page = max(1, (int)($_GET['page'] ?? 1));
    $perPage = 10;
    $offset = ($page - 1) * $perPage;
    
    // Récupérer articles et total
    $articles = getArticlesByCategorySlug($category['slug'], $perPage, $offset);
    $total = countPublishedArticlesByCategorySlug($category['slug']);
    $pages = ceil($total / $perPage);
    
    // Récupérer catégories pour nav
    $allCategories = getAllCategories(false);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($category['name']) ?> — Analyses et reportages — Iran Observateur</title>
  <meta name="description" content="<?= htmlspecialchars($category['description'] ?? 'Retrouvez tous nos articles sur ' . $category['name']) ?>">
  <meta name="keywords" content="Iran, <?= htmlspecialchars($category['name']) ?>, analyse, reportage">
  <meta name="author" content="Iran Observateur">
  <meta property="og:title" content="<?= htmlspecialchars($category['name']) ?> — Iran Observateur">
  <meta property="og:description" content="<?= htmlspecialchars($category['description'] ?? 'Retrouvez tous nos articles sur ' . $category['name']) ?>">
  <meta property="og:type" content="website">
  <meta property="og:url" content="https://iran-observateur.local/<?= htmlspecialchars($category['slug']) ?>">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="https://iran-observateur.local/<?= htmlspecialchars($category['slug']) ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Source+Serif+4:ital,wght@0,300;0,400;0,600;1,300;1,400&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
  <style>
    :root {
      --ink: #0f0e0c;
      --paper: #f5f0e8;
      --cream: #ede7d8;
      --accent: #b8341b;
      --accent2: #1a3a5c;
      --muted: #6b6355;
      --border: #c8bfad;
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }
    body {
      background: var(--paper);
      color: var(--ink);
      font-family: 'Source Serif 4', Georgia, serif;
      font-size: 17px;
      line-height: 1.7;
      overflow-x: hidden;
    }

    /* TOPBAR */
    .topbar {
      background: var(--ink);
      color: var(--paper);
      text-align: center;
      padding: 8px 20px;
      font-family: 'JetBrains Mono', monospace;
      font-size: 11px;
      letter-spacing: 0.12em;
      text-transform: uppercase;
    }
    .topbar a { color: var(--accent); text-decoration: none; }

    /* HEADER */
    header { border-bottom: 3px double var(--border); padding: 0 40px; }
    .header-top {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 22px 0 18px;
      border-bottom: 1px solid var(--border);
    }
    .site-date { font-family: 'JetBrains Mono', monospace; font-size: 11px; color: var(--muted); letter-spacing: 0.08em; }
    .site-title { text-align: center; flex: 1; }
    .site-title a { text-decoration: none; color: var(--ink); }
    .site-title h1 {
      font-family: 'Playfair Display', Georgia, serif;
      font-size: clamp(28px, 4vw, 52px);
      font-weight: 900;
      line-height: 1;
    }
    .site-title h1 span { color: var(--accent); }
    nav { display: flex; justify-content: center; }
    nav a {
      display: block;
      padding: 12px 20px;
      font-family: 'JetBrains Mono', monospace;
      font-size: 11px;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--muted);
      text-decoration: none;
      border-right: 1px solid var(--border);
      transition: all 0.2s;
    }
    nav a:first-child { border-left: 1px solid var(--border); }
    nav a:hover, nav a.active { color: var(--ink); background: var(--cream); }

    /* BREADCRUMB */
    .breadcrumb {
      max-width: 1200px;
      margin: 20px auto 0;
      padding: 0 40px;
      font-family: 'JetBrains Mono', monospace;
      font-size: 11px;
      color: var(--muted);
      display: flex;
      gap: 8px;
      align-items: center;
    }
    .breadcrumb a { color: var(--muted); text-decoration: none; }
    .breadcrumb a:hover { color: var(--accent); }

    /* CATEGORY HERO */
    .cat-hero {
      background: var(--ink);
      color: var(--paper);
      padding: 60px 40px;
      margin-bottom: 0;
    }
    .cat-hero h2 {
      font-family: 'Playfair Display', serif;
      font-size: clamp(36px, 5vw, 64px);
      font-weight: 700;
      line-height: 1.1;
      margin-bottom: 16px;
    }
    .cat-hero p {
      font-size: 17px;
      opacity: 0.7;
      max-width: 560px;
      line-height: 1.7;
      margin-bottom: 24px;
    }
    .cat-stats {
      display: flex;
      gap: 32px;
    }
    .cat-stat-num {
      font-family: 'Playfair Display', serif;
      font-size: 36px;
      font-weight: 700;
      color: var(--accent);
    }
    .cat-stat-label {
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      opacity: 0.6;
    }

    /* ARTICLE LIST */
    .page-layout {
      max-width: 1200px;
      margin: 0 auto;
      padding: 40px;
    }
    .articles-list { display: flex; flex-direction: column; gap: 0; }
    .article-row {
      display: grid;
      grid-template-columns: 120px 1fr;
      gap: 20px;
      padding: 24px 0;
      border-bottom: 1px solid var(--border);
      text-decoration: none;
      color: var(--ink);
      transition: background 0.15s;
    }
    .article-row:hover { background: var(--cream); margin: 0 -16px; padding: 24px 16px; }
    .article-row:hover h3 { color: var(--accent); }
    .row-thumb {
      aspect-ratio: 4/3;
      background: var(--ink);
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Playfair Display', serif;
      font-style: italic;
      color: var(--paper);
      font-size: 18px;
      opacity: 0.7;
      flex-shrink: 0;
    }
    .row-cat {
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      color: var(--accent);
      text-transform: uppercase;
      letter-spacing: 0.1em;
      margin-bottom: 6px;
    }
    .row-content h3 {
      font-family: 'Playfair Display', serif;
      font-size: 18px;
      font-weight: 700;
      line-height: 1.3;
      margin-bottom: 8px;
      transition: color 0.2s;
    }
    .row-content p {
      font-size: 13px;
      color: var(--muted);
      line-height: 1.55;
      margin-bottom: 10px;
    }
    .row-meta {
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      color: var(--muted);
      display: flex;
      gap: 10px;
    }

    /* PAGINATION */
    .pagination {
      display: flex;
      gap: 0;
      margin-top: 40px;
      justify-content: center;
    }
    .page-btn {
      border: 1px solid var(--border);
      background: none;
      padding: 10px 16px;
      font-family: 'JetBrains Mono', monospace;
      font-size: 12px;
      cursor: pointer;
      color: var(--muted);
      text-decoration: none;
      transition: all 0.2s;
    }
    .page-btn:hover, .page-btn.active { background: var(--ink); color: var(--paper); border-color: var(--ink); }
    .page-btn.active { font-weight: 600; }

    footer {
      background: var(--ink);
      color: var(--paper);
      padding: 40px;
      text-align: center;
      margin-top: 60px;
    }
    .footer-inner {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 16px;
    }
    .footer-copyright {
      width: 100%;
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      color: rgba(255,255,255,0.3);
      margin-top: 24px;
    }

    @media (max-width: 900px) {
      header, .breadcrumb { padding: 0 20px; }
      .page-layout { padding: 20px; }
    }
  </style>
</head>
<body>

  <div class="topbar">
    <a href="index.php">← Iran Observateur</a>
  </div>

  <header>
    <div class="header-top">
      <div class="site-date">
        <div>Vol. XII — N°88</div>
      </div>
      <div class="site-title">
        <a href="index.php"><h1>Iran <span>Observateur</span></h1></a>
      </div>
      <div style="width: 100px;"></div>
    </div>
    <nav aria-label="Navigation principale">
      <a href="index.php">Accueil</a>
      <?php foreach ($allCategories as $cat) { ?>
        <a href="categorie.php?slug=<?= urlencode($cat['slug']) ?>" <?= $cat['id'] == $category['id'] ? 'class="active"' : '' ?>>
          <?= htmlspecialchars($cat['name']) ?>
        </a>
      <?php } ?>
      <a href="a-propos.php">À propos</a>
    </nav>
  </header>

  <nav class="breadcrumb" aria-label="Fil d'Ariane">
    <a href="index.php">Accueil</a>
    <span>/</span>
    <span><?= htmlspecialchars($category['name']) ?></span>
  </nav>

  <section class="cat-hero">
    <h2><?= htmlspecialchars($category['name']) ?></h2>
    <p><?= htmlspecialchars($category['description'] ?? '') ?></p>
    <div class="cat-stats">
      <div>
        <span class="cat-stat-num"><?= $total ?></span>
        <div class="cat-stat-label">Article<?= $total > 1 ? 's' : '' ?></div>
      </div>
      <div>
        <span class="cat-stat-num"><?= $pages ?></span>
        <div class="cat-stat-label">Page<?= $pages > 1 ? 's' : '' ?></div>
      </div>
    </div>
  </section>

  <div class="page-layout">
    <?php if (count($articles) > 0) { ?>
    <div class="articles-list">
      <?php foreach ($articles as $art) { ?>
      <a href="article.php?slug=<?= urlencode($art['slug']) ?>" class="article-row">
        <div class="row-thumb"><?= strtoupper(substr($art['category_slug'] ?? 'cat', 0, 3)) ?></div>
        <div class="row-content">
          <div class="row-cat"><?= htmlspecialchars($art['category_name'] ?? 'Article') ?></div>
          <h3><?= htmlspecialchars($art['title']) ?></h3>
          <p><?= htmlspecialchars(substr(strip_tags($art['content']), 0, 150)) ?>...</p>
          <div class="row-meta">
            <span><?= $art['published_at'] ? date('d M Y', strtotime($art['published_at'])) : '' ?></span>
            <span>·</span>
            <span><?= intval(strlen(strip_tags($art['content'])) / 200) ?> min</span>
          </div>
        </div>
      </a>
      <?php } ?>
    </div>

    <?php if ($pages > 1) { ?>
    <div class="pagination">
      <?php for ($i = 1; $i <= $pages; $i++) { ?>
      <a href="categorie.php?slug=<?= urlencode($category['slug']) ?>&page=<?= $i ?>" 
         class="page-btn <?= $i == $page ? 'active' : '' ?>">
        <?= $i ?>
      </a>
      <?php } ?>
    </div>
    <?php } ?>
    <?php } else { ?>
    <p style="text-align: center; color: var(--muted); padding: 40px;">Aucun article trouvé dans cette catégorie.</p>
    <?php } ?>
  </div>

  <footer>
    <div class="footer-inner">
      <div>Iran <span style="color: var(--accent);">Observateur</span></div>
      <nav>
        <a href="a-propos.php" style="padding: 4px 12px; text-decoration: none; color: rgba(245,240,232,0.6); font-family: 'JetBrains Mono', monospace; font-size: 10px; text-transform: uppercase;">À propos</a>
        <a href="#" style="padding: 4px 12px; text-decoration: none; color: rgba(245,240,232,0.6); font-family: 'JetBrains Mono', monospace; font-size: 10px; text-transform: uppercase;">Mentions légales</a>
      </nav>
    </div>
    <div class="footer-copyright">
      © 2026 Iran Observateur — Mini-projet Web Design — Tous droits réservés
    </div>
  </footer>

</body>
</html>

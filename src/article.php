<?php
    include 'fonction.php';
    
    // Récupérer l'article par slug depuis l'URL
    $slug = $_GET['slug'] ?? null;
    if (!$slug) {
        header('Location: index.php');
        exit;
    }
    
    $article = getArticleBySlug($slug, true);
    
    if ($article === null) {
        header('HTTP/1.0 404 Not Found');
        exit('Article non trouvé');
    }
    
    $articleImages = getArticleMedia($article['id']);
    
    $relatedArticles = getRelatedPublishedArticles($article['id'], $article['category_id'] ?? null, 4);
    
    $categories = getAllCategories(false);
    
    $recentArticles = getPublishedArticles(3, 0);
    
    $pageTitle = $article['meta_title'] ?? htmlspecialchars($article['title'] . ' — Iran Observateur');
    $pageDescription = $article['meta_description'] ?? htmlspecialchars(substr(strip_tags($article['content']), 0, 160));
    $pageUrl = 'https://iran-observateur.local/article/' . htmlspecialchars($article['slug']);
    $publishedDate = $article['published_at'] ? date('Y-m-d', strtotime($article['published_at'])) : date('Y-m-d');
    $updatedDate = $article['updated_at'] ? date('Y-m-d', strtotime($article['updated_at'])) : $publishedDate;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $pageTitle ?></title>
  <meta name="description" content="<?= $pageDescription ?>">
  <meta name="keywords" content="Iran, <?= htmlspecialchars($article['category_name'] ?? 'article') ?>, analyse, reportage">
  <meta name="author" content="<?= htmlspecialchars($article['author_username'] ?? 'La rédaction') ?> — Iran Observateur">
  <meta property="og:title" content="<?= htmlspecialchars($article['title']) ?> — Iran Observateur">
  <meta property="og:description" content="<?= $pageDescription ?>">
  <meta property="og:type" content="article">
  <meta property="og:url" content="<?= $pageUrl ?>">
  <meta property="article:published_time" content="<?= $publishedDate ?>">
  <meta property="article:modified_time" content="<?= $updatedDate ?>">
  <meta property="article:author" content="<?= htmlspecialchars($article['author_username'] ?? 'Iran Observateur') ?>">
  <meta property="article:section" content="<?= htmlspecialchars($article['category_name'] ?? 'Articles') ?>">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="<?= $pageUrl ?>">
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
    nav a:hover { color: var(--ink); background: var(--cream); }

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
    .breadcrumb span { opacity: 0.5; }

    /* ARTICLE LAYOUT */
    .article-wrap {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 40px;
      display: grid;
      grid-template-columns: 1fr 300px;
      gap: 60px;
      align-items: start;
    }

    /* ARTICLE MAIN */
    .article-main { padding: 32px 0 60px; }
    .article-cat {
      font-family: 'JetBrains Mono', monospace;
      font-size: 11px;
      color: var(--accent);
      text-transform: uppercase;
      letter-spacing: 0.15em;
      margin-bottom: 16px;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .article-cat::after { content: ""; flex: 1; max-width: 60px; height: 1px; background: var(--accent); opacity: 0.4; }

    .article-headline {
      font-family: 'Playfair Display', Georgia, serif;
      font-size: clamp(28px, 4vw, 48px);
      font-weight: 700;
      line-height: 1.15;
      letter-spacing: -0.01em;
      margin-bottom: 20px;
    }

    .article-deck {
      font-family: 'Source Serif 4', serif;
      font-size: 20px;
      font-weight: 300;
      font-style: italic;
      color: var(--muted);
      line-height: 1.65;
      margin-bottom: 28px;
      padding-bottom: 28px;
      border-bottom: 1px solid var(--border);
    }

    .article-byline {
      display: flex;
      align-items: center;
      gap: 20px;
      margin-bottom: 32px;
      flex-wrap: wrap;
    }
    .author-avatar {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      background: var(--ink);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--paper);
      font-family: 'Playfair Display', serif;
      font-size: 16px;
      font-style: italic;
      flex-shrink: 0;
    }
    .byline-info { flex: 1; }
    .byline-name {
      font-family: 'Source Serif 4', serif;
      font-weight: 600;
      font-size: 14px;
    }
    .byline-meta {
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      color: var(--muted);
      margin-top: 2px;
      letter-spacing: 0.06em;
    }

    /* IMAGE GALLERY */
    .article-gallery {
      margin-bottom: 32px;
      margin-top: 32px;
    }
    .gallery-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin-bottom: 20px;
    }
    .gallery-item {
      overflow: hidden;
      background: var(--ink);
      aspect-ratio: 16/10;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .gallery-item img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .gallery-caption {
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      color: var(--muted);
      padding: 8px 0;
      letter-spacing: 0.06em;
    }

    /* ARTICLE BODY */
    .article-body { font-size: 18px; line-height: 1.8; color: var(--ink); }
    .article-body h2 {
      font-family: 'Playfair Display', serif;
      font-size: 26px;
      font-weight: 700;
      margin: 40px 0 16px;
      padding-top: 8px;
      border-top: 2px solid var(--ink);
    }
    .article-body h3 {
      font-family: 'Playfair Display', serif;
      font-size: 20px;
      font-weight: 700;
      margin: 28px 0 12px;
      color: var(--accent2);
    }
    .article-body p { margin-bottom: 20px; }
    .article-body a { color: var(--accent); text-decoration: underline; text-decoration-thickness: 1px; }
    .article-body strong { font-weight: 600; }

    .article-body blockquote {
      border-left: 4px solid var(--accent);
      margin: 32px 0;
      padding: 20px 28px;
      background: var(--cream);
    }
    .article-body blockquote p {
      font-family: 'Playfair Display', serif;
      font-style: italic;
      font-size: 20px;
      line-height: 1.55;
      margin-bottom: 10px;
      color: var(--ink);
    }

    /* TAGS */
    .article-tags {
      margin-top: 40px;
      padding-top: 24px;
      border-top: 1px solid var(--border);
      display: flex;
      gap: 8px;
      flex-wrap: wrap;
      align-items: center;
    }
    .tags-label {
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      color: var(--muted);
      letter-spacing: 0.1em;
      text-transform: uppercase;
    }
    .tag-pill {
      border: 1px solid var(--border);
      padding: 4px 12px;
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      color: var(--muted);
      text-decoration: none;
      transition: all 0.2s;
      letter-spacing: 0.06em;
    }
    .tag-pill:hover { background: var(--ink); color: var(--paper); border-color: var(--ink); }

    /* RELATED */
    .related-section {
      border-top: 2px solid var(--ink);
      margin-top: 48px;
      padding-top: 32px;
    }
    .related-section h2 {
      font-family: 'Playfair Display', serif;
      font-size: 22px;
      font-weight: 700;
      margin-bottom: 24px;
    }
    .related-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 24px;
    }
    .related-card {
      display: flex;
      gap: 16px;
      text-decoration: none;
      color: var(--ink);
      padding: 16px 0;
      border-bottom: 1px solid var(--border);
    }
    .related-card:hover h3 { color: var(--accent); }
    .related-thumb {
      width: 80px;
      height: 60px;
      flex-shrink: 0;
      background: var(--ink);
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Playfair Display', serif;
      font-style: italic;
      color: var(--paper);
      font-size: 11px;
      opacity: 0.7;
      text-transform: uppercase;
    }
    .related-info .rel-cat {
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      color: var(--accent);
      text-transform: uppercase;
      letter-spacing: 0.1em;
      margin-bottom: 4px;
    }
    .related-info h3 {
      font-family: 'Playfair Display', serif;
      font-size: 15px;
      font-weight: 700;
      line-height: 1.35;
    }
    .related-info .rel-date {
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      color: var(--muted);
      margin-top: 4px;
    }

    /* SIDEBAR */
    .article-sidebar { padding-top: 32px; }
    .sidebar-widget {
      border-top: 2px solid var(--ink);
      padding-top: 20px;
      margin-bottom: 36px;
    }
    .sidebar-widget h3 {
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      color: var(--muted);
      margin-bottom: 16px;
    }
    .sidebar-article-link {
      padding: 12px 0;
      border-bottom: 1px solid var(--border);
      text-decoration: none;
      color: var(--ink);
      display: block;
      transition: color 0.2s;
    }
    .sidebar-article-link:hover { color: var(--accent); }
    .sidebar-cat {
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      color: var(--accent);
      text-transform: uppercase;
      margin-bottom: 4px;
    }
    .sidebar-title {
      font-family: 'Playfair Display', serif;
      font-size: 15px;
      font-weight: 700;
      line-height: 1.3;
    }
    .sidebar-date {
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      color: var(--muted);
      margin-top: 4px;
    }
    .sidebar-cat-link {
      padding: 8px 0;
      border-bottom: 1px solid var(--border);
      display: flex;
      justify-content: space-between;
      align-items: center;
      text-decoration: none;
      color: var(--ink);
      transition: color 0.2s;
    }
    .sidebar-cat-link:hover { color: var(--accent); }
    .sidebar-cat-count {
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      color: var(--muted);
    }

    /* PROGRESS */
    .reading-progress {
      position: fixed;
      top: 0;
      left: 0;
      height: 3px;
      background: var(--accent);
      transition: width 0.1s;
      z-index: 100;
      width: 0%;
    }

    footer {
      background: var(--ink);
      color: var(--paper);
      padding: 40px;
      text-align: center;
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
    .footer-inner .brand {
      font-family: 'Playfair Display', serif;
      font-size: 22px;
      font-weight: 900;
    }
    .footer-inner .brand span { color: var(--accent); }
    .footer-inner nav a {
      color: rgba(245,240,232,0.6);
      text-decoration: none;
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      padding: 4px 12px;
      border: none;
    }
    .footer-inner nav a:hover { color: var(--paper); background: none; }
    .footer-copyright {
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      color: rgba(255,255,255,0.3);
      margin-top: 24px;
      max-width: 1200px;
      margin: 24px auto 0;
    }

    @media (max-width: 900px) {
      header, .breadcrumb { padding: 0 20px; }
      .article-wrap { grid-template-columns: 1fr; padding: 0 20px; gap: 0; }
      .article-sidebar { border-top: 2px solid var(--border); padding-top: 32px; }
      .related-grid { grid-template-columns: 1fr; }
      .gallery-grid { grid-template-columns: 1fr; }
      nav { overflow-x: auto; justify-content: flex-start; }
    }
  </style>
</head>
<body>

  <div class="reading-progress" id="progress" role="progressbar" aria-label="Progression de lecture"></div>

  <div class="topbar">
    <a href="index.php">← Iran Observateur</a>
    &nbsp;·&nbsp; <?= $article['published_at'] ? date('l d F Y', strtotime($article['published_at'])) : date('l d F Y') ?> &nbsp;·&nbsp; <?= htmlspecialchars($article['category_name'] ?? 'Article') ?>
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
      <?php foreach ($categories as $cat) { ?>
        <a href="categorie.php?slug=<?= urlencode($cat['slug']) ?>"><?= htmlspecialchars($cat['name']) ?></a>
      <?php } ?>
      <a href="a-propos.php">À propos</a>
    </nav>
  </header>

  <nav class="breadcrumb" aria-label="Fil d'Ariane">
    <a href="index.php">Accueil</a>
    <span>/</span>
    <?php if ($article['category_id']) { ?>
      <a href="categorie.php?slug=<?= urlencode($article['category_slug']) ?>"><?= htmlspecialchars($article['category_name']) ?></a>
      <span>/</span>
    <?php } ?>
    <span><?= htmlspecialchars($article['title']) ?></span>
  </nav>

  <div class="article-wrap">

    <article class="article-main">

      <div class="article-cat"><?= htmlspecialchars($article['category_name'] ?? 'Article') ?></div>

      <h1 class="article-headline">
        <?= htmlspecialchars($article['title']) ?>
      </h1>

      <p class="article-deck">
        <?= htmlspecialchars(substr(strip_tags($article['content']), 0, 200) . '...') ?>
      </p>

      <div class="article-byline">
        <div class="author-avatar" aria-hidden="true"><?= strtoupper(substr($article['author_username'] ?? 'Rd', 0, 2)) ?></div>
        <div class="byline-info">
          <div class="byline-name"><?= htmlspecialchars($article['author_username'] ?? 'La rédaction') ?> — Iran Observateur</div>
          <div class="byline-meta">
            Publié le <?= $article['published_at'] ? date('d M Y', strtotime($article['published_at'])) : date('d M Y') ?>
            · Mis à jour le <?= $article['updated_at'] ? date('d M Y', strtotime($article['updated_at'])) : ($article['published_at'] ? date('d M Y', strtotime($article['published_at'])) : date('d M Y')) ?>
            · <?= intval(strlen(strip_tags($article['content'])) / 200) ?> min
          </div>
        </div>
      </div>

      <?php if (count($articleImages) > 0) { ?>
      <section class="article-gallery" aria-label="Galerie d'images">
        <div class="gallery-grid">
          <?php foreach ($articleImages as $image) { ?>
          <figure class="gallery-item">
            <img src="uploads/<?= htmlspecialchars($image['filename']) ?>" alt="<?= htmlspecialchars($image['alt_text']) ?>" loading="lazy">
          </figure>
          <?php } ?>
        </div>
        <?php if ($articleImages[0]['alt_text']) { ?>
        <div class="gallery-caption">
          <?= htmlspecialchars($articleImages[0]['alt_text']) ?> / Iran Observateur
        </div>
        <?php } ?>
      </section>
      <?php } ?>

      <div class="article-body">
        <?= $article['content'] ?>
      </div>

      <?php if (!empty($article['tags'])) { ?>
      <div class="article-tags">
        <span class="tags-label">Tags :</span>
        <?php foreach ($article['tags'] as $tag) { ?>
        <a href="#" class="tag-pill"><?= htmlspecialchars($tag['name']) ?></a>
        <?php } ?>
      </div>
      <?php } ?>

      <?php if (count($relatedArticles) > 0) { ?>
      <section class="related-section" aria-label="Articles liés">
        <h2>À lire aussi</h2>
        <div class="related-grid">
          <?php foreach ($relatedArticles as $related) { ?>
          <a href="article.php?slug=<?= urlencode($related['slug']) ?>" class="related-card">
            <div class="related-thumb"><?= strtoupper(substr($related['category_slug'] ?? 'cat', 0, 3)) ?></div>
            <div class="related-info">
              <div class="rel-cat"><?= htmlspecialchars($related['category_name'] ?? 'Article') ?></div>
              <h3><?= htmlspecialchars($related['title']) ?></h3>
              <div class="rel-date"><?= $related['published_at'] ? date('d M Y', strtotime($related['published_at'])) : '' ?></div>
            </div>
          </a>
          <?php } ?>
        </div>
      </section>
      <?php } ?>

    </article>

    <!-- SIDEBAR -->
    <aside class="article-sidebar" aria-label="Informations complémentaires">

      <?php if (count($recentArticles) > 0) { ?>
      <div class="sidebar-widget">
        <h3>Derniers articles</h3>
        <?php foreach ($recentArticles as $recent) { ?>
        <a href="article.php?slug=<?= urlencode($recent['slug']) ?>" class="sidebar-article-link">
          <div class="sidebar-cat"><?= htmlspecialchars($recent['category_name'] ?? 'Article') ?></div>
          <div class="sidebar-title"><?= htmlspecialchars($recent['title']) ?></div>
          <div class="sidebar-date"><?= $recent['published_at'] ? date('d M Y', strtotime($recent['published_at'])) : '' ?></div>
        </a>
        <?php } ?>
      </div>
      <?php } ?>

      <div class="sidebar-widget">
        <h3>Catégories</h3>
        <?php foreach ($categories as $cat) { ?>
        <a href="categorie.php?slug=<?= urlencode($cat['slug']) ?>" class="sidebar-cat-link">
          <span><?= htmlspecialchars($cat['name']) ?></span>
          <span class="sidebar-cat-count"><?= $cat['article_count'] ?? 0 ?></span>
        </a>
        <?php } ?>
      </div>

    </aside>
  </div>

  <footer>
    <div class="footer-inner">
      <div class="brand">Iran <span>Observateur</span></div>
      <nav aria-label="Navigation pied de page">
        <a href="index.php">Accueil</a>
        <a href="categorie.php?slug=diplomatie">Articles</a>
        <a href="a-propos.php">À propos</a>
      </nav>
    </div>
    <div class="footer-copyright">© 2026 Iran Observateur — Mini-projet Web Design</div>
  </footer>

  <script>
    const bar = document.getElementById('progress');
    window.addEventListener('scroll', () => {
      const total = document.body.scrollHeight - window.innerHeight;
      const pct = total > 0 ? (window.scrollY / total * 100) : 0;
      bar.style.width = Math.min(pct, 100) + '%';
    });
  </script>

</body>
</html>

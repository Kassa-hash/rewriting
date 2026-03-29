<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Diplomatie — Analyses et reportages sur la diplomatie iranienne — Iran Observateur</title>
  <meta name="description" content="Retrouvez tous nos articles sur la diplomatie iranienne : négociations, sanctions, accords internationaux et relations avec les grandes puissances.">
  <meta name="keywords" content="Iran diplomatie, négociations nucléaires, sanctions, JCPOA, ONU, relations internationales">
  <meta name="author" content="Iran Observateur">
  <meta property="og:title" content="Diplomatie — Iran Observateur">
  <meta property="og:description" content="Toutes les analyses sur la diplomatie iranienne et les relations internationales.">
  <meta property="og:type" content="website">
  <meta property="og:url" content="https://iran-observateur.local/diplomatie">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="https://iran-observateur.local/diplomatie">
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
    nav {
      display: flex;
      justify-content: center;
    }
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
    .breadcrumb span { opacity: 0.5; }

    /* CATEGORY HERO */
    .cat-hero {
      background: var(--ink);
      color: var(--paper);
      padding: 60px 40px;
      margin-bottom: 0;
      position: relative;
      overflow: hidden;
    }
    .cat-hero::before {
      content: "Diplomatie";
      position: absolute;
      right: -20px;
      top: 50%;
      transform: translateY(-50%);
      font-family: 'Playfair Display', serif;
      font-size: 160px;
      font-style: italic;
      font-weight: 900;
      opacity: 0.05;
      white-space: nowrap;
      pointer-events: none;
    }
    .cat-hero-inner {
      max-width: 1200px;
      margin: 0 auto;
      position: relative;
    }
    .cat-hero-label {
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      letter-spacing: 0.25em;
      text-transform: uppercase;
      color: var(--accent);
      margin-bottom: 16px;
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
    .cat-stat {
      text-align: center;
    }
    .cat-stat-num {
      font-family: 'Playfair Display', serif;
      font-size: 36px;
      font-weight: 700;
      color: var(--accent);
      display: block;
    }
    .cat-stat-label {
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      opacity: 0.6;
    }

    /* SUBCATEGORIES */
    .subcats {
      background: var(--cream);
      border-bottom: 1px solid var(--border);
      padding: 0 40px;
    }
    .subcats-inner {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      gap: 0;
      overflow-x: auto;
    }
    .subcats a {
      display: block;
      padding: 14px 20px;
      font-family: 'JetBrains Mono', monospace;
      font-size: 11px;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: var(--muted);
      text-decoration: none;
      border-right: 1px solid var(--border);
      white-space: nowrap;
      transition: all 0.2s;
    }
    .subcats a:hover, .subcats a.active {
      color: var(--ink);
      background: var(--paper);
    }
    .subcats a.active { font-weight: 500; }

    /* MAIN LAYOUT */
    .page-layout {
      max-width: 1200px;
      margin: 0 auto;
      padding: 40px 40px;
      display: grid;
      grid-template-columns: 1fr 280px;
      gap: 56px;
      align-items: start;
    }

    /* FILTERS */
    .filters-bar {
      display: flex;
      gap: 12px;
      align-items: center;
      margin-bottom: 32px;
      flex-wrap: wrap;
    }
    .filters-label {
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      color: var(--muted);
      letter-spacing: 0.1em;
      text-transform: uppercase;
    }
    .filter-btn {
      border: 1px solid var(--border);
      background: none;
      padding: 6px 14px;
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      cursor: pointer;
      color: var(--muted);
      transition: all 0.2s;
    }
    .filter-btn:hover, .filter-btn.active {
      background: var(--ink);
      color: var(--paper);
      border-color: var(--ink);
    }
    .sort-select {
      margin-left: auto;
      border: 1px solid var(--border);
      background: var(--paper);
      padding: 6px 12px;
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      color: var(--muted);
      cursor: pointer;
      outline: none;
    }

    /* ARTICLE LIST */
    .article-featured {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 32px;
      padding-bottom: 40px;
      margin-bottom: 40px;
      border-bottom: 2px solid var(--ink);
    }
    .article-featured-img {
      aspect-ratio: 4/3;
      background: linear-gradient(135deg, #1a3a5c 0%, #0f0e0c 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--paper);
      font-family: 'Playfair Display', serif;
      font-style: italic;
      font-size: 52px;
      opacity: 0.6;
    }
    .featured-content {
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .featured-badge {
      display: inline-block;
      background: var(--accent);
      color: white;
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      padding: 4px 10px;
      margin-bottom: 16px;
    }
    .featured-content h2 {
      font-family: 'Playfair Display', serif;
      font-size: 28px;
      font-weight: 700;
      line-height: 1.2;
      margin-bottom: 14px;
    }
    .featured-content h2 a { color: var(--ink); text-decoration: none; }
    .featured-content h2 a:hover { color: var(--accent); }
    .featured-content p {
      color: var(--muted);
      font-size: 15px;
      line-height: 1.65;
      margin-bottom: 20px;
    }
    .featured-meta {
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      color: var(--muted);
      display: flex;
      gap: 12px;
    }

    /* ARTICLE ROWS */
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
    .row-content {}
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
      border-right: none;
      padding: 10px 16px;
      font-family: 'JetBrains Mono', monospace;
      font-size: 12px;
      cursor: pointer;
      background: none;
      color: var(--muted);
      transition: all 0.2s;
    }
    .page-btn:last-child { border-right: 1px solid var(--border); }
    .page-btn:hover, .page-btn.active {
      background: var(--ink);
      color: var(--paper);
      border-color: var(--ink);
    }

    /* SIDEBAR */
    .cat-sidebar {}
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
    .tag-cloud {
      display: flex;
      flex-wrap: wrap;
      gap: 6px;
    }
    .tag-cloud a {
      border: 1px solid var(--border);
      padding: 4px 10px;
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      color: var(--muted);
      text-decoration: none;
      transition: all 0.2s;
    }
    .tag-cloud a:hover { background: var(--ink); color: var(--paper); border-color: var(--ink); }
    .cat-list { list-style: none; }
    .cat-list li {
      padding: 10px 0;
      border-bottom: 1px solid var(--border);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .cat-list li:last-child { border-bottom: none; }
    .cat-list a {
      font-family: 'Source Serif 4', serif;
      font-size: 14px;
      color: var(--ink);
      text-decoration: none;
    }
    .cat-list a:hover { color: var(--accent); }
    .cat-list .count {
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      color: var(--muted);
    }
    .timeline-widget {}
    .timeline-item {
      display: flex;
      gap: 12px;
      padding: 12px 0;
      border-bottom: 1px solid var(--border);
    }
    .timeline-item:last-child { border-bottom: none; }
    .timeline-date {
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      color: var(--accent);
      min-width: 44px;
      padding-top: 2px;
    }
    .timeline-text { font-size: 13px; line-height: 1.5; color: var(--muted); }

    footer {
      background: var(--ink);
      color: var(--paper);
      padding: 40px;
      margin-top: 40px;
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
    .footer-inner .brand { font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 900; }
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
      max-width: 1200px;
      margin: 24px auto 0;
    }

    @media (max-width: 900px) {
      header { padding: 0 20px; }
      .cat-hero, .subcats { padding-left: 20px; padding-right: 20px; }
      .page-layout { grid-template-columns: 1fr; padding: 24px 20px; }
      .article-featured { grid-template-columns: 1fr; }
      .breadcrumb { padding: 0 20px; }
      nav { overflow-x: auto; justify-content: flex-start; }
    }
  </style>
</head>
<body>

  <div class="topbar">
    <a href="index.php">← Iran Observateur</a>
    &nbsp;·&nbsp; Catégorie : Diplomatie &nbsp;·&nbsp; 9 articles
  </div>

  <header>
    <div class="header-top">
      <div class="site-date"><div>Vol. XII — N°88</div></div>
      <div class="site-title">
        <a href="index.php"><h1>Iran <span>Observateur</span></h1></a>
      </div>
      <div style="width:100px"></div>
    </div>
    <nav aria-label="Navigation principale">
      <a href="index.php">Accueil</a>
      <a href="categorie.php">Politique</a>
      <a href="categorie.php">Militaire</a>
      <a href="categorie.php">Humanitaire</a>
      <a href="categorie.php" class="active">Diplomatie</a>
      <a href="a-propos.php">À propos</a>
    </nav>
  </header>

  <nav class="breadcrumb" aria-label="Fil d'Ariane">
    <a href="index.php">Accueil</a>
    <span>/</span>
    <span>Diplomatie</span>
  </nav>

  <div class="cat-hero">
    <div class="cat-hero-inner">
      <div class="cat-hero-label">Rubrique</div>
      <h2>Diplomatie</h2>
      <p>Négociations, accords internationaux, sanctions économiques et relations entre l'Iran et les grandes puissances mondiales.</p>
      <div class="cat-stats">
        <div class="cat-stat">
          <span class="cat-stat-num">9</span>
          <span class="cat-stat-label">Articles</span>
        </div>
        <div class="cat-stat">
          <span class="cat-stat-num">3</span>
          <span class="cat-stat-label">Analyses</span>
        </div>
        <div class="cat-stat">
          <span class="cat-stat-num">2026</span>
          <span class="cat-stat-label">En cours</span>
        </div>
      </div>
    </div>
  </div>

  <div class="subcats">
    <div class="subcats-inner">
      <a href="categorie.php" class="active">Tout</a>
      <a href="categorie.php">Nucléaire</a>
      <a href="categorie.php">Sanctions</a>
      <a href="categorie.php">ONU</a>
      <a href="categorie.php">Relations bilatérales</a>
      <a href="categorie.php">Accords</a>
    </div>
  </div>

  <div class="page-layout">

    <main aria-label="Liste des articles Diplomatie">

      <!-- FILTERS -->
      <div class="filters-bar">
        <span class="filters-label">Filtrer :</span>
        <button class="filter-btn active" onclick="setFilter(this,'tous')">Tous</button>
        <button class="filter-btn" onclick="setFilter(this,'analyse')">Analyses</button>
        <button class="filter-btn" onclick="setFilter(this,'reportage')">Reportages</button>
        <button class="filter-btn" onclick="setFilter(this,'decryptage')">Décryptages</button>
        <select class="sort-select" aria-label="Trier par">
          <option>Plus récents</option>
          <option>Plus lus</option>
          <option>Plus commentés</option>
        </select>
      </div>

      <!-- FEATURED -->
      <section class="article-featured" aria-label="Article à la une de la rubrique">
        <div class="article-featured-img" role="img" aria-label="Table des négociations à Genève sur le dossier iranien">ژنو</div>
        <div class="featured-content">
          <span class="featured-badge">À la une</span>
          <h2><a href="article.php">Négociations à Genève : l'impasse nucléaire au cœur des pourparlers de mars 2026</a></h2>
          <p>Les délégations américaine, européenne et iranienne se retrouvent à Genève pour tenter de relancer un dialogue suspendu depuis l'automne 2025.</p>
          <div class="featured-meta">
            <span>28 mars 2026</span>
            <span>·</span>
            <span>8 min</span>
            <span>·</span>
            <span>Analyse</span>
          </div>
        </div>
      </section>

      <!-- ARTICLE LIST -->
      <div class="articles-list" id="article-list">
        <a href="article.php" class="article-row" data-type="analyse">
          <div class="row-thumb" style="background:linear-gradient(135deg,#2d2a1a,#0f0e0c)" role="img" aria-label="Illustration sanctions économiques iraniennes">💼</div>
          <div class="row-content">
            <div class="row-cat">Sanctions</div>
            <h3>L'économie iranienne sous pression : bilan des sanctions 2025</h3>
            <p>Un an après le nouveau train de sanctions occidental, l'économie iranienne montre des signes de fragilité croissante malgré des stratégies de contournement actives.</p>
            <div class="row-meta"><span>22 mars 2026</span><span>·</span><span>6 min</span><span>·</span><span>Analyse</span></div>
          </div>
        </a>
        <a href="article.php" class="article-row" data-type="reportage">
          <div class="row-thumb" style="background:linear-gradient(135deg,#1a3a5c,#0f0e0c)" role="img" aria-label="Illustration ONU et dossier iranien">🏛</div>
          <div class="row-content">
            <div class="row-cat">ONU</div>
            <h3>Le Conseil de sécurité divisé face à l'escalade iranienne</h3>
            <p>La Chine et la Russie ont opposé leur veto à une résolution américaine visant à renforcer les inspections de l'AIEA en Iran.</p>
            <div class="row-meta"><span>18 mars 2026</span><span>·</span><span>5 min</span><span>·</span><span>Reportage</span></div>
          </div>
        </a>
        <a href="article.php" class="article-row" data-type="decryptage">
          <div class="row-thumb" style="background:linear-gradient(135deg,#1a2d1a,#0f0e0c)" role="img" aria-label="Illustration JCPOA et accord nucléaire iranien">📋</div>
          <div class="row-content">
            <div class="row-cat">Nucléaire</div>
            <h3>Le JCPOA est-il encore sauvable ? Décryptage d'un accord en lambeaux</h3>
            <p>Dix ans après sa signature, l'accord de Vienne sur le nucléaire iranien n'est plus qu'une coquille vide. Peut-il encore servir de base à un nouveau compromis ?</p>
            <div class="row-meta"><span>15 mars 2026</span><span>·</span><span>9 min</span><span>·</span><span>Décryptage</span></div>
          </div>
        </a>
        <a href="article.php" class="article-row" data-type="analyse">
          <div class="row-thumb" style="background:linear-gradient(135deg,#2d1a0e,#0f0e0c)" role="img" aria-label="Illustration relations Iran-Russie">🤝</div>
          <div class="row-content">
            <div class="row-cat">Relations bilatérales</div>
            <h3>Iran-Russie : un rapprochement stratégique aux contours flous</h3>
            <p>Les livraisons d'armes iraniennes à Moscou ont profondément modifié l'équation diplomatique régionale et les relations de Téhéran avec l'Occident.</p>
            <div class="row-meta"><span>10 mars 2026</span><span>·</span><span>7 min</span><span>·</span><span>Analyse</span></div>
          </div>
        </a>
        <a href="article.php" class="article-row" data-type="reportage">
          <div class="row-thumb" style="background:linear-gradient(135deg,#1a3a5c,#0f0e0c)" role="img" aria-label="Illustration Turquie Iran et diplomatie régionale">🌐</div>
          <div class="row-content">
            <div class="row-cat">Relations bilatérales</div>
            <h3>La Turquie, médiateur inattendu dans la crise iranienne</h3>
            <p>Ankara multiplie les navettes diplomatiques entre Téhéran et les capitales occidentales, jouant un rôle d'intermédiaire discret mais efficace.</p>
            <div class="row-meta"><span>5 mars 2026</span><span>·</span><span>5 min</span><span>·</span><span>Reportage</span></div>
          </div>
        </a>
        <a href="article.php" class="article-row" data-type="decryptage">
          <div class="row-thumb" style="background:linear-gradient(135deg,#1a2a1a,#0f0e0c)" role="img" aria-label="Illustration pétrole iranien et sanctions">⛽</div>
          <div class="row-content">
            <div class="row-cat">Sanctions</div>
            <h3>Pétrole iranien : les routes de contournement des sanctions</h3>
            <p>Malgré les embargos, l'Iran continue d'exporter son pétrole via des réseaux opaques impliquant des tankers fantômes et des intermédiaires asiatiques.</p>
            <div class="row-meta"><span>28 fév. 2026</span><span>·</span><span>8 min</span><span>·</span><span>Décryptage</span></div>
          </div>
        </a>
      </div>

      <div class="pagination" role="navigation" aria-label="Pagination">
        <button class="page-btn active">1</button>
        <button class="page-btn">2</button>
        <button class="page-btn">3</button>
        <button class="page-btn">→</button>
      </div>

    </main>

    <!-- SIDEBAR -->
    <aside class="cat-sidebar" aria-label="Navigation secondaire">

      <div class="sidebar-widget">
        <h3>Toutes les catégories</h3>
        <ul class="cat-list">
          <li><a href="categorie.php">Politique</a><span class="count">12</span></li>
          <li><a href="categorie.php">Militaire</a><span class="count">18</span></li>
          <li><a href="categorie.php">Humanitaire</a><span class="count">14</span></li>
          <li><a href="categorie.php" style="color:var(--accent)">Diplomatie</a><span class="count">9</span></li>
          <li><a href="categorie.php">Sanctions</a><span class="count">7</span></li>
          <li><a href="categorie.php">Frappes aériennes</a><span class="count">11</span></li>
          <li><a href="categorie.php">Réfugiés</a><span class="count">8</span></li>
        </ul>
      </div>

      <div class="sidebar-widget">
        <h3>Chronologie diplomatique</h3>
        <div class="timeline-widget">
          <div class="timeline-item">
            <div class="timeline-date">Mars 26</div>
            <div class="timeline-text">Reprise des négociations à Genève</div>
          </div>
          <div class="timeline-item">
            <div class="timeline-date">Déc. 25</div>
            <div class="timeline-text">Suspension des pourparlers après escalade militaire</div>
          </div>
          <div class="timeline-item">
            <div class="timeline-date">Juin 25</div>
            <div class="timeline-text">Nouvelles sanctions américaines sur le pétrole</div>
          </div>
          <div class="timeline-item">
            <div class="timeline-date">Jan. 25</div>
            <div class="timeline-text">L'Iran annonce 60% d'enrichissement</div>
          </div>
          <div class="timeline-item">
            <div class="timeline-date">2018</div>
            <div class="timeline-text">Retrait américain du JCPOA</div>
          </div>
        </div>
      </div>

      <div class="sidebar-widget">
        <h3>Tags associés</h3>
        <div class="tag-cloud">
          <a href="#">Nucléaire</a>
          <a href="#">ONU</a>
          <a href="#">JCPOA</a>
          <a href="#">États-Unis</a>
          <a href="#">Russie</a>
          <a href="#">Turquie</a>
          <a href="#">AIEA</a>
          <a href="#">Sanctions</a>
          <a href="#">Pétrole</a>
          <a href="#">Israël</a>
        </div>
      </div>

    </aside>
  </div>

  <footer>
    <div class="footer-inner">
      <div class="brand">Iran <span>Observateur</span></div>
      <nav aria-label="Navigation pied de page">
        <a href="index.php">Accueil</a>
        <a href="categorie.php">Articles</a>
        <a href="a-propos.php">À propos</a>
        <a href="#">Contact</a>
      </nav>
    </div>
    <div class="footer-copyright">© 2026 Iran Observateur — Mini-projet Web Design</div>
  </footer>

  <script>
    function setFilter(btn, type) {
      document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      const rows = document.querySelectorAll('#article-list .article-row');
      rows.forEach(row => {
        if (type === 'tous' || row.dataset.type === type) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    }
  </script>

</body>
</php>
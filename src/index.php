<?php
include 'bdconnection.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iran Observateur — Actualités & Analyses sur le conflit en Iran</title>
  <meta name="description" content="Suivez en temps réel l'actualité du conflit en Iran : analyses politiques, militaires, humanitaires et diplomatiques. Informations vérifiées et contextualisées.">
  <meta name="keywords" content="Iran, conflit, guerre, actualité, IRGC, nucléaire, Moyen-Orient, analyse">
  <meta name="author" content="Iran Observateur">
  <meta property="og:title" content="Iran Observateur — Actualités & Analyses sur le conflit en Iran">
  <meta property="og:description" content="Suivez en temps réel l'actualité du conflit en Iran : analyses politiques, militaires, humanitaires et diplomatiques.">
  <meta property="og:type" content="website">
  <meta property="og:url" content="https://iran-observateur.local/">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="https://iran-observateur.local/">
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
      --col: 1fr;
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
    header {
      border-bottom: 3px double var(--border);
      padding: 0 40px;
    }
    .header-top {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 28px 0 20px;
      border-bottom: 1px solid var(--border);
    }
    .site-date {
      font-family: 'JetBrains Mono', monospace;
      font-size: 11px;
      color: var(--muted);
      letter-spacing: 0.08em;
    }
    .site-title {
      text-align: center;
      flex: 1;
    }
    .site-title h1 {
      font-family: 'Playfair Display', Georgia, serif;
      font-size: clamp(36px, 6vw, 72px);
      font-weight: 900;
      line-height: 1;
      letter-spacing: -0.02em;
      color: var(--ink);
    }
    .site-title h1 span { color: var(--accent); }
    .site-tagline {
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      letter-spacing: 0.25em;
      text-transform: uppercase;
      color: var(--muted);
      margin-top: 6px;
    }
    .header-actions {
      display: flex;
      gap: 12px;
      align-items: center;
    }
    .btn-search {
      background: none;
      border: 1px solid var(--border);
      padding: 8px 16px;
      font-family: 'JetBrains Mono', monospace;
      font-size: 11px;
      cursor: pointer;
      color: var(--ink);
      transition: all 0.2s;
    }
    .btn-search:hover { background: var(--ink); color: var(--paper); }

    /* NAV */
    nav {
      display: flex;
      gap: 0;
      justify-content: center;
      padding: 0;
    }
    nav a {
      display: block;
      padding: 14px 22px;
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
    nav a.active { font-weight: 500; }

    /* BREAKING TICKER */
    .ticker-wrap {
      background: var(--accent);
      color: white;
      display: flex;
      align-items: center;
      overflow: hidden;
      height: 36px;
    }
    .ticker-label {
      background: var(--ink);
      color: var(--paper);
      padding: 0 16px;
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      font-weight: 500;
      letter-spacing: 0.15em;
      text-transform: uppercase;
      white-space: nowrap;
      height: 100%;
      display: flex;
      align-items: center;
      flex-shrink: 0;
    }
    .ticker-inner {
      display: flex;
      animation: ticker 30s linear infinite;
      white-space: nowrap;
    }
    .ticker-inner span {
      font-family: 'Source Serif 4', serif;
      font-size: 13px;
      padding: 0 40px;
    }
    .ticker-inner span::before { content: "◆ "; font-size: 8px; vertical-align: middle; }
    @keyframes ticker { from { transform: translateX(0); } to { transform: translateX(-50%); } }

    /* MAIN LAYOUT */
    main { max-width: 1200px; margin: 0 auto; padding: 0 40px; }

    /* HERO */
    .hero {
      display: grid;
      grid-template-columns: 1fr 340px;
      gap: 0;
      border-bottom: 2px solid var(--ink);
      margin-top: 40px;
    }
    .hero-main {
      border-right: 1px solid var(--border);
      padding-right: 36px;
    }
    .hero-label {
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      color: var(--accent);
      margin-bottom: 16px;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .hero-label::after { content: ""; flex: 1; height: 1px; background: var(--accent); opacity: 0.4; }
    .hero-main h2 {
      font-family: 'Playfair Display', Georgia, serif;
      font-size: clamp(28px, 3.5vw, 46px);
      font-weight: 700;
      line-height: 1.15;
      letter-spacing: -0.01em;
      margin-bottom: 16px;
    }
    .hero-main h2 em { color: var(--accent); font-style: italic; }
    .hero-excerpt {
      font-size: 17px;
      color: var(--muted);
      line-height: 1.75;
      margin-bottom: 24px;
      max-width: 560px;
    }
    .hero-meta {
      display: flex;
      align-items: center;
      gap: 20px;
      font-family: 'JetBrains Mono', monospace;
      font-size: 11px;
      color: var(--muted);
      margin-bottom: 28px;
    }
    .hero-meta .cat-tag {
      background: var(--accent);
      color: white;
      padding: 3px 10px;
      font-size: 10px;
      letter-spacing: 0.1em;
      text-transform: uppercase;
    }
    .hero-img {
      aspect-ratio: 16/9;
      background: var(--ink);
      margin-bottom: 24px;
      overflow: hidden;
      position: relative;
    }
    .hero-img img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      opacity: 0.85;
      display: block;
    }
    .hero-img-placeholder {
      width: 100%;
      height: 200px;
      background: linear-gradient(135deg, var(--accent2) 0%, var(--ink) 60%);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--paper);
      font-family: 'Playfair Display', serif;
      font-size: 48px;
      font-style: italic;
      opacity: 0.6;
      letter-spacing: -0.02em;
    }
    .read-more {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      font-family: 'JetBrains Mono', monospace;
      font-size: 11px;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--ink);
      text-decoration: none;
      border-bottom: 2px solid var(--ink);
      padding-bottom: 2px;
      transition: all 0.2s;
    }
    .read-more:hover { color: var(--accent); border-color: var(--accent); }
    .read-more::after { content: "→"; }

    /* HERO SIDEBAR */
    .hero-sidebar { padding-left: 36px; }
    .sidebar-section-title {
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      color: var(--muted);
      border-bottom: 2px solid var(--ink);
      padding-bottom: 8px;
      margin-bottom: 20px;
    }
    .sidebar-articles { list-style: none; }
    .sidebar-articles li {
      padding: 16px 0;
      border-bottom: 1px solid var(--border);
    }
    .sidebar-articles li:last-child { border-bottom: none; }
    .sidebar-articles .art-cat {
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      color: var(--accent);
      text-transform: uppercase;
      letter-spacing: 0.1em;
      margin-bottom: 6px;
    }
    .sidebar-articles h3 {
      font-family: 'Playfair Display', serif;
      font-size: 17px;
      font-weight: 700;
      line-height: 1.3;
      margin-bottom: 6px;
    }
    .sidebar-articles h3 a { color: var(--ink); text-decoration: none; }
    .sidebar-articles h3 a:hover { color: var(--accent); }
    .sidebar-articles .art-date {
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      color: var(--muted);
    }

    /* SECTION GRID */
    .section-header {
      display: flex;
      align-items: baseline;
      gap: 16px;
      margin: 48px 0 24px;
    }
    .section-header h2 {
      font-family: 'Playfair Display', serif;
      font-size: 28px;
      font-weight: 700;
    }
    .section-header .section-line { flex: 1; height: 1px; background: var(--border); }
    .section-header a {
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--muted);
      text-decoration: none;
    }
    .section-header a:hover { color: var(--accent); }

    .articles-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 32px;
      margin-bottom: 48px;
    }
    .article-card { position: relative; }
    .article-card .card-img {
      aspect-ratio: 16/9;
      background: var(--ink);
      margin-bottom: 16px;
      overflow: hidden;
    }
    .card-img-fill {
      width: 100%;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 32px;
      font-family: 'Playfair Display', serif;
      font-style: italic;
      color: var(--paper);
      opacity: 0.5;
    }
    .card-img-fill.pol  { background: linear-gradient(135deg, #1a3a5c 0%, #0f0e0c 100%); }
    .card-img-fill.mil  { background: linear-gradient(135deg, #2d1a0e 0%, #0f0e0c 100%); }
    .card-img-fill.hum  { background: linear-gradient(135deg, #1a2d1a 0%, #0f0e0c 100%); }
    .card-img-fill.dip  { background: linear-gradient(135deg, #2d2a1a 0%, #0f0e0c 100%); }
    .article-card .card-cat {
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      color: var(--accent);
      text-transform: uppercase;
      letter-spacing: 0.12em;
      margin-bottom: 8px;
    }
    .article-card h3 {
      font-family: 'Playfair Display', serif;
      font-size: 20px;
      font-weight: 700;
      line-height: 1.3;
      margin-bottom: 10px;
    }
    .article-card h3 a { color: var(--ink); text-decoration: none; }
    .article-card h3 a:hover { color: var(--accent); }
    .article-card .card-excerpt {
      font-size: 14px;
      color: var(--muted);
      line-height: 1.6;
      margin-bottom: 14px;
    }
    .article-card .card-meta {
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      color: var(--muted);
      display: flex;
      gap: 12px;
    }

    /* CATEGORIES STRIP */
    .categories-strip {
      background: var(--ink);
      color: var(--paper);
      padding: 36px 40px;
      margin: 0 -40px 48px;
    }
    .categories-strip h2 {
      font-family: 'Playfair Display', serif;
      font-size: 24px;
      font-weight: 700;
      margin-bottom: 24px;
      color: var(--paper);
    }
    .cat-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 16px;
    }
    .cat-card {
      border: 1px solid rgba(255,255,255,0.15);
      padding: 20px;
      text-decoration: none;
      color: var(--paper);
      transition: all 0.25s;
      position: relative;
      overflow: hidden;
    }
    .cat-card::before {
      content: "";
      position: absolute;
      left: 0; top: 0; bottom: 0;
      width: 3px;
      background: var(--accent);
      transform: scaleY(0);
      transition: transform 0.25s;
    }
    .cat-card:hover { background: rgba(255,255,255,0.06); }
    .cat-card:hover::before { transform: scaleY(1); }
    .cat-card .cat-icon {
      font-size: 22px;
      margin-bottom: 10px;
      display: block;
    }
    .cat-card h3 {
      font-family: 'Playfair Display', serif;
      font-size: 18px;
      font-weight: 700;
      margin-bottom: 6px;
    }
    .cat-card p {
      font-size: 12px;
      opacity: 0.6;
      line-height: 1.5;
    }
    .cat-card .cat-count {
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      color: var(--accent);
      margin-top: 12px;
      letter-spacing: 0.1em;
    }

    /* NEWSLETTER */
    .newsletter {
      border: 2px solid var(--ink);
      padding: 40px;
      text-align: center;
      margin-bottom: 48px;
      position: relative;
    }
    .newsletter::before {
      content: "❧";
      position: absolute;
      top: -16px;
      left: 50%;
      transform: translateX(-50%);
      background: var(--paper);
      padding: 0 12px;
      font-size: 24px;
      color: var(--accent);
    }
    .newsletter h2 {
      font-family: 'Playfair Display', serif;
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 10px;
    }
    .newsletter p { color: var(--muted); margin-bottom: 24px; font-size: 15px; }
    .newsletter-form {
      display: flex;
      gap: 0;
      max-width: 460px;
      margin: 0 auto;
    }
    .newsletter-form input {
      flex: 1;
      border: 1px solid var(--border);
      border-right: none;
      padding: 12px 16px;
      font-family: 'Source Serif 4', serif;
      font-size: 14px;
      background: white;
      outline: none;
    }
    .newsletter-form button {
      background: var(--ink);
      color: var(--paper);
      border: 1px solid var(--ink);
      padding: 12px 24px;
      font-family: 'JetBrains Mono', monospace;
      font-size: 11px;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      cursor: pointer;
      transition: all 0.2s;
    }
    .newsletter-form button:hover { background: var(--accent); border-color: var(--accent); }

    /* FOOTER */
    footer {
      background: var(--ink);
      color: var(--paper);
      padding: 48px 40px 24px;
    }
    .footer-grid {
      max-width: 1200px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 2fr 1fr 1fr 1fr;
      gap: 40px;
      padding-bottom: 40px;
      border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    .footer-brand h3 {
      font-family: 'Playfair Display', serif;
      font-size: 26px;
      font-weight: 900;
      margin-bottom: 12px;
    }
    .footer-brand h3 span { color: var(--accent); }
    .footer-brand p { font-size: 13px; opacity: 0.6; line-height: 1.7; }
    .footer-col h4 {
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      color: var(--accent);
      margin-bottom: 16px;
    }
    .footer-col ul { list-style: none; }
    .footer-col ul li { margin-bottom: 8px; }
    .footer-col ul li a {
      color: rgba(245,240,232,0.6);
      text-decoration: none;
      font-size: 13px;
      transition: color 0.2s;
    }
    .footer-col ul li a:hover { color: var(--paper); }
    .footer-bottom {
      max-width: 1200px;
      margin: 0 auto;
      padding-top: 24px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      color: rgba(255,255,255,0.35);
      letter-spacing: 0.08em;
    }

    /* FADE IN */
    .fade-in { opacity: 0; transform: translateY(16px); animation: fadeUp 0.6s forwards; }
    .fade-in:nth-child(1) { animation-delay: 0.1s; }
    .fade-in:nth-child(2) { animation-delay: 0.2s; }
    .fade-in:nth-child(3) { animation-delay: 0.3s; }
    @keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }

    @media (max-width: 900px) {
      header, main { padding: 0 20px; }
      .hero { grid-template-columns: 1fr; }
      .hero-main { border-right: none; padding-right: 0; border-bottom: 1px solid var(--border); padding-bottom: 32px; }
      .hero-sidebar { padding-left: 0; padding-top: 32px; }
      .articles-grid { grid-template-columns: 1fr; }
      .cat-grid { grid-template-columns: repeat(2, 1fr); }
      .footer-grid { grid-template-columns: 1fr 1fr; }
      .categories-strip { margin: 0 -20px 40px; padding: 28px 20px; }
      nav { overflow-x: auto; justify-content: flex-start; }
    }
  </style>
</head>
<body>

  <div class="topbar">
    <span>Dimanche 29 mars 2026</span> &nbsp;·&nbsp;
    <a href="article.html">Dernière heure : Négociations à Genève — nouvelles propositions sur le nucléaire</a>
  </div>

  <header>
    <div class="header-top">
      <div class="site-date">
        <div>Vol. XII — N°88</div>
        <div>Édition française</div>
      </div>
      <div class="site-title">
        <h1>Iran <span>Observateur</span></h1>
        <p class="site-tagline">Analyses · Reportages · Décryptages</p>
      </div>
      <div class="header-actions">
        <button class="btn-search">⌕ Rechercher</button>
      </div>
    </div>
    <nav aria-label="Navigation principale">
      <a href="index.html" class="active">Accueil</a>
      <a href="categorie.html">Politique</a>
      <a href="categorie.html">Militaire</a>
      <a href="categorie.html">Humanitaire</a>
      <a href="categorie.html">Diplomatie</a>
      <a href="a-propos.html">À propos</a>
    </nav>
  </header>

  <div class="ticker-wrap" aria-label="Flux d'actualité en direct">
    <div class="ticker-label">En direct</div>
    <div class="ticker-inner">
      <span>Frappes signalées dans le nord-ouest de l'Iran</span>
      <span>Le Conseil de sécurité de l'ONU se réunit en urgence</span>
      <span>Téhéran annonce la suspension partielle de l'enrichissement</span>
      <span>2,3 millions de déplacés selon le HCR</span>
      <span>Washington impose de nouvelles sanctions sur le pétrole iranien</span>
      <span>Frappes signalées dans le nord-ouest de l'Iran</span>
      <span>Le Conseil de sécurité de l'ONU se réunit en urgence</span>
      <span>Téhéran annonce la suspension partielle de l'enrichissement</span>
      <span>2,3 millions de déplacés selon le HCR</span>
      <span>Washington impose de nouvelles sanctions sur le pétrole iranien</span>
    </div>
  </div>

  <main>

    <!-- HERO -->
    <section class="hero" aria-label="Article à la une">
      <div class="hero-main">
        <div class="hero-img-placeholder" role="img" aria-label="Carte du conflit en Iran et dans la région du Golfe Persique">
          ایران
        </div>
        <div class="hero-label">À la une</div>
        <h2>Négociations à Genève : <em>l'impasse nucléaire</em> au cœur des pourparlers de mars 2026</h2>
        <p class="hero-excerpt">Les délégations américaine, européenne et iranienne se retrouvent à Genève pour tenter de relancer un dialogue suspendu depuis l'automne 2025. L'enrichissement de l'uranium reste la principale pomme de discorde.</p>
        <div class="hero-meta">
          <span class="cat-tag">Diplomatie</span>
          <span>Par la rédaction</span>
          <span>28 mars 2026</span>
          <span>8 min de lecture</span>
        </div>
        <a href="article.html" class="read-more">Lire l'article complet</a>
      </div>

      <aside class="hero-sidebar" aria-label="Articles récents">
        <p class="sidebar-section-title">À lire aussi</p>
        <ul class="sidebar-articles">
          <li>
            <div class="art-cat">Militaire</div>
            <h3><a href="article.html">Les forces en présence : IRGC, armée régulière et milices alliées</a></h3>
            <div class="art-date">27 mars 2026</div>
          </li>
          <li>
            <div class="art-cat">Humanitaire</div>
            <h3><a href="article.html">Situation humanitaire : 2 millions de déplacés en 2025</a></h3>
            <div class="art-date">26 mars 2026</div>
          </li>
          <li>
            <div class="art-cat">Politique</div>
            <h3><a href="article.html">Chronologie du conflit : les origines de la crise en Iran</a></h3>
            <div class="art-date">24 mars 2026</div>
          </li>
          <li>
            <div class="art-cat">Sanctions</div>
            <h3><a href="article.html">L'économie iranienne sous pression : bilan des sanctions 2025</a></h3>
            <div class="art-date">22 mars 2026</div>
          </li>
        </ul>
      </aside>
    </section>

    <!-- DERNIERS ARTICLES -->
    <section aria-label="Derniers articles">
      <div class="section-header">
        <h2>Dernières analyses</h2>
        <span class="section-line"></span>
        <a href="categorie.html">Voir tout →</a>
      </div>
      <div class="articles-grid">
        <article class="article-card fade-in">
          <div class="card-img">
            <div class="card-img-fill pol" role="img" aria-label="Illustration politique — Téhéran, Iran">Pol</div>
          </div>
          <div class="card-cat">Politique</div>
          <h3><a href="article.html">Le régime iranien face à la pression interne et internationale</a></h3>
          <p class="card-excerpt">La double contrainte d'une opposition intérieure grandissante et des pressions diplomatiques extérieures fragilise le gouvernement de Téhéran.</p>
          <div class="card-meta">
            <span>25 mars 2026</span>
            <span>·</span>
            <span>6 min</span>
          </div>
        </article>
        <article class="article-card fade-in">
          <div class="card-img">
            <div class="card-img-fill mil" role="img" aria-label="Illustration militaire — Forces armées iraniennes">Mil</div>
          </div>
          <div class="card-cat">Militaire</div>
          <h3><a href="article.html">Frappes de drones : une nouvelle doctrine de guerre dans le Golfe</a></h3>
          <p class="card-excerpt">L'utilisation massive de drones kamikaze redéfinit les règles d'engagement dans la région et oblige les puissances à revoir leurs défenses.</p>
          <div class="card-meta">
            <span>23 mars 2026</span>
            <span>·</span>
            <span>5 min</span>
          </div>
        </article>
        <article class="article-card fade-in">
          <div class="card-img">
            <div class="card-img-fill hum" role="img" aria-label="Illustration humanitaire — Aide aux civils iraniens">Hum</div>
          </div>
          <div class="card-cat">Humanitaire</div>
          <h3><a href="article.html">L'accès humanitaire entravé : témoignages de terrain des ONG</a></h3>
          <p class="card-excerpt">Médecins Sans Frontières et le CICR dénoncent des restrictions d'accès sans précédent dans les zones de conflit en Iran.</p>
          <div class="card-meta">
            <span>21 mars 2026</span>
            <span>·</span>
            <span>7 min</span>
          </div>
        </article>
      </div>
    </section>

    <!-- CATEGORIES -->
    <section class="categories-strip" aria-label="Explorer par thématique">
      <h2>Explorer par thématique</h2>
      <div class="cat-grid">
        <a href="categorie.html" class="cat-card">
          <span class="cat-icon">🏛</span>
          <h3>Politique</h3>
          <p>Gouvernance, régime, opposition et dynamiques de pouvoir</p>
          <div class="cat-count">12 articles</div>
        </a>
        <a href="categorie.html" class="cat-card">
          <span class="cat-icon">⚔</span>
          <h3>Militaire</h3>
          <p>Opérations, forces armées, drones et frappes aériennes</p>
          <div class="cat-count">18 articles</div>
        </a>
        <a href="categorie.html" class="cat-card">
          <span class="cat-icon">🤝</span>
          <h3>Diplomatie</h3>
          <p>Négociations, sanctions, accords et relations internationales</p>
          <div class="cat-count">9 articles</div>
        </a>
        <a href="categorie.html" class="cat-card">
          <span class="cat-icon">🏥</span>
          <h3>Humanitaire</h3>
          <p>Civils, réfugiés, aide internationale et droits humains</p>
          <div class="cat-count">14 articles</div>
        </a>
      </div>
    </section>

    <!-- NEWSLETTER -->
    <section class="newsletter" aria-label="Newsletter">
      <h2>Restez informé</h2>
      <p>Recevez chaque matin notre synthèse des événements en Iran directement dans votre boîte mail.</p>
      <div class="newsletter-form">
        <label for="email-nl" class="sr-only">Votre adresse e-mail</label>
        <input type="email" id="email-nl" placeholder="votre@email.fr" autocomplete="email">
        <button type="button">S'abonner</button>
      </div>
    </section>

  </main>

  <footer>
    <div class="footer-grid">
      <div class="footer-brand">
        <h3>Iran <span>Observateur</span></h3>
        <p>Média indépendant spécialisé dans le suivi du conflit en Iran. Nos analyses s'appuient sur des sources vérifiées et des experts reconnus de la région.</p>
      </div>
      <div class="footer-col">
        <h4>Rubriques</h4>
        <ul>
          <li><a href="categorie.html">Politique</a></li>
          <li><a href="categorie.html">Militaire</a></li>
          <li><a href="categorie.html">Humanitaire</a></li>
          <li><a href="categorie.html">Diplomatie</a></li>
          <li><a href="categorie.html">Sanctions</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Site</h4>
        <ul>
          <li><a href="a-propos.html">À propos</a></li>
          <li><a href="#">Mentions légales</a></li>
          <li><a href="#">Politique de confidentialité</a></li>
          <li><a href="#">Contact</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Suivre</h4>
        <ul>
          <li><a href="#">Newsletter</a></li>
          <li><a href="#">Flux RSS</a></li>
          <li><a href="#">Twitter/X</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <span>© 2026 Iran Observateur — Mini-projet Web Design</span>
      <span>Tous droits réservés</span>
    </div>
  </footer>

</body>
</html>
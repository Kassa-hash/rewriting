<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>À propos — Iran Observateur, média indépendant sur le conflit en Iran</title>
  <meta name="description" content="Découvrez Iran Observateur : notre mission, notre équipe éditoriale et notre méthode journalistique pour couvrir le conflit en Iran avec rigueur et indépendance.">
  <meta name="keywords" content="Iran Observateur, à propos, rédaction, journalisme, mission, équipe éditoriale">
  <meta name="author" content="Iran Observateur">
  <meta property="og:title" content="À propos — Iran Observateur">
  <meta property="og:description" content="Notre mission : informer avec rigueur et indépendance sur le conflit en Iran.">
  <meta property="og:type" content="website">
  <meta property="og:url" content="https://iran-observateur.local/a-propos">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="https://iran-observateur.local/a-propos">
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
      max-width: 900px;
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

    /* PAGE HERO */
    .page-hero {
      max-width: 900px;
      margin: 48px auto 0;
      padding: 0 40px;
      text-align: center;
    }
    .page-hero-label {
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      letter-spacing: 0.25em;
      text-transform: uppercase;
      color: var(--muted);
      margin-bottom: 20px;
    }
    .page-hero h2 {
      font-family: 'Playfair Display', serif;
      font-size: clamp(36px, 5vw, 60px);
      font-weight: 700;
      font-style: italic;
      line-height: 1.1;
      margin-bottom: 24px;
    }
    .page-hero h2 em { color: var(--accent); font-style: normal; }
    .page-hero-intro {
      font-size: 20px;
      font-weight: 300;
      font-style: italic;
      color: var(--muted);
      line-height: 1.7;
      max-width: 620px;
      margin: 0 auto 48px;
    }
    .hero-rule {
      display: flex;
      align-items: center;
      gap: 16px;
      margin-bottom: 60px;
    }
    .hero-rule::before, .hero-rule::after { content: ""; flex: 1; height: 1px; background: var(--border); }
    .hero-rule span {
      font-family: 'Playfair Display', serif;
      font-size: 20px;
      color: var(--accent);
    }

    /* CONTENT */
    .page-content {
      max-width: 900px;
      margin: 0 auto;
      padding: 0 40px 80px;
    }

    /* MANIFESTO */
    .manifesto {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 60px;
      margin-bottom: 72px;
      align-items: start;
    }
    .manifesto-text h3 {
      font-family: 'Playfair Display', serif;
      font-size: 28px;
      font-weight: 700;
      line-height: 1.2;
      margin-bottom: 20px;
    }
    .manifesto-text p {
      font-size: 16px;
      color: var(--muted);
      line-height: 1.8;
      margin-bottom: 16px;
    }
    .manifesto-visual {
      background: var(--ink);
      padding: 40px;
      color: var(--paper);
      position: relative;
    }
    .manifesto-visual::before {
      content: "«";
      position: absolute;
      top: -20px;
      left: 20px;
      font-family: 'Playfair Display', serif;
      font-size: 120px;
      color: var(--accent);
      opacity: 0.4;
      line-height: 1;
    }
    .manifesto-quote {
      font-family: 'Playfair Display', serif;
      font-style: italic;
      font-size: 22px;
      line-height: 1.5;
      position: relative;
      z-index: 1;
      margin-bottom: 20px;
    }
    .manifesto-cite {
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      color: var(--accent);
      letter-spacing: 0.12em;
      text-transform: uppercase;
    }

    /* SECTION TITLE */
    .section-title {
      display: flex;
      align-items: center;
      gap: 16px;
      margin-bottom: 40px;
    }
    .section-title h2 {
      font-family: 'Playfair Display', serif;
      font-size: 24px;
      font-weight: 700;
      white-space: nowrap;
    }
    .section-title::after { content: ""; flex: 1; height: 1px; background: var(--border); }

    /* PRINCIPES */
    .principes {
      margin-bottom: 72px;
    }
    .principes-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 24px;
    }
    .principe-card {
      border: 1px solid var(--border);
      padding: 28px;
      position: relative;
    }
    .principe-num {
      position: absolute;
      top: 20px;
      right: 20px;
      font-family: 'Playfair Display', serif;
      font-size: 40px;
      font-weight: 900;
      color: var(--ink);
      opacity: 0.06;
      line-height: 1;
    }
    .principe-icon {
      font-size: 24px;
      margin-bottom: 12px;
      display: block;
    }
    .principe-card h3 {
      font-family: 'Playfair Display', serif;
      font-size: 18px;
      font-weight: 700;
      margin-bottom: 10px;
    }
    .principe-card p {
      font-size: 14px;
      color: var(--muted);
      line-height: 1.65;
    }

    /* TEAM */
    .team { margin-bottom: 72px; }
    .team-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 32px;
    }
    .team-card {
      text-align: center;
    }
    .team-avatar {
      width: 88px;
      height: 88px;
      border-radius: 50%;
      background: var(--ink);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--paper);
      font-family: 'Playfair Display', serif;
      font-size: 28px;
      font-style: italic;
      margin: 0 auto 16px;
    }
    .team-card h3 {
      font-family: 'Playfair Display', serif;
      font-size: 18px;
      font-weight: 700;
      margin-bottom: 4px;
    }
    .team-role {
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      color: var(--accent);
      text-transform: uppercase;
      letter-spacing: 0.1em;
      margin-bottom: 10px;
    }
    .team-bio {
      font-size: 13px;
      color: var(--muted);
      line-height: 1.6;
    }

    /* STATS */
    .stats-section {
      background: var(--ink);
      color: var(--paper);
      padding: 60px 40px;
      margin: 0 -40px 72px;
      text-align: center;
    }
    .stats-section h2 {
      font-family: 'Playfair Display', serif;
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 40px;
    }
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 32px;
      max-width: 700px;
      margin: 0 auto;
    }
    .stat-item {}
    .stat-num {
      font-family: 'Playfair Display', serif;
      font-size: 48px;
      font-weight: 900;
      color: var(--accent);
      display: block;
      line-height: 1;
      margin-bottom: 8px;
    }
    .stat-label {
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      opacity: 0.6;
    }

    /* CONTACT */
    .contact-section { margin-bottom: 72px; }
    .contact-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 40px;
    }
    .contact-info h3 {
      font-family: 'Playfair Display', serif;
      font-size: 22px;
      font-weight: 700;
      margin-bottom: 16px;
    }
    .contact-info p {
      font-size: 15px;
      color: var(--muted);
      line-height: 1.7;
      margin-bottom: 20px;
    }
    .contact-items { list-style: none; }
    .contact-items li {
      display: flex;
      gap: 12px;
      align-items: flex-start;
      padding: 10px 0;
      border-bottom: 1px solid var(--border);
      font-size: 14px;
    }
    .contact-items li:last-child { border-bottom: none; }
    .contact-items .ci-label {
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      color: var(--muted);
      text-transform: uppercase;
      letter-spacing: 0.08em;
      min-width: 80px;
      padding-top: 2px;
    }
    .contact-form h3 {
      font-family: 'Playfair Display', serif;
      font-size: 22px;
      font-weight: 700;
      margin-bottom: 20px;
    }
    .form-group { margin-bottom: 16px; }
    .form-group label {
      display: block;
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      color: var(--muted);
      margin-bottom: 6px;
    }
    .form-group input,
    .form-group textarea,
    .form-group select {
      width: 100%;
      border: 1px solid var(--border);
      padding: 10px 14px;
      font-family: 'Source Serif 4', serif;
      font-size: 15px;
      background: white;
      outline: none;
      transition: border-color 0.2s;
      color: var(--ink);
    }
    .form-group input:focus,
    .form-group textarea:focus { border-color: var(--accent); }
    .form-group textarea { height: 100px; resize: vertical; }
    .btn-submit {
      background: var(--ink);
      color: var(--paper);
      border: none;
      padding: 14px 28px;
      font-family: 'JetBrains Mono', monospace;
      font-size: 11px;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      cursor: pointer;
      transition: all 0.2s;
      width: 100%;
    }
    .btn-submit:hover { background: var(--accent); }

    /* FAQ */
    .faq-section { margin-bottom: 72px; }
    .faq-item {
      border-bottom: 1px solid var(--border);
    }
    .faq-question {
      width: 100%;
      background: none;
      border: none;
      padding: 20px 0;
      text-align: left;
      font-family: 'Playfair Display', serif;
      font-size: 17px;
      font-weight: 700;
      cursor: pointer;
      display: flex;
      justify-content: space-between;
      align-items: center;
      color: var(--ink);
    }
    .faq-question::after {
      content: "+";
      font-size: 20px;
      color: var(--accent);
      transition: transform 0.2s;
      flex-shrink: 0;
    }
    .faq-question.open::after { transform: rotate(45deg); }
    .faq-answer {
      overflow: hidden;
      max-height: 0;
      transition: max-height 0.3s ease;
    }
    .faq-answer p {
      font-size: 15px;
      color: var(--muted);
      line-height: 1.75;
      padding-bottom: 20px;
    }

    footer {
      background: var(--ink);
      color: var(--paper);
      padding: 40px;
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
      .page-hero, .page-content, .breadcrumb { padding-left: 20px; padding-right: 20px; }
      .manifesto, .contact-grid { grid-template-columns: 1fr; gap: 32px; }
      .principes-grid, .team-grid { grid-template-columns: 1fr; }
      .stats-grid { grid-template-columns: repeat(2, 1fr); }
      .stats-section { margin: 0 -20px 48px; padding: 40px 20px; }
      nav { overflow-x: auto; justify-content: flex-start; }
    }
  </style>
</head>
<body>

  <div class="topbar">
    <a href="index.php">← Iran Observateur</a>
    &nbsp;·&nbsp; À propos de la rédaction
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
      <a href="categorie.php">Diplomatie</a>
      <a href="a-propos.php" class="active">À propos</a>
    </nav>
  </header>

  <nav class="breadcrumb" aria-label="Fil d'Ariane">
    <a href="index.php">Accueil</a>
    <span>/</span>
    <span>À propos</span>
  </nav>

  <!-- PAGE HERO -->
  <div class="page-hero">
    <div class="page-hero-label">Qui sommes-nous</div>
    <h2>Informer avec <em>rigueur</em> sur une crise qui engage le monde</h2>
    <p class="page-hero-intro">
      Iran Observateur est un média indépendant fondé pour couvrir avec sérieux, profondeur et impartialité le conflit en Iran et ses répercussions internationales.
    </p>
    <div class="hero-rule"><span>❧</span></div>
  </div>

  <div class="page-content">

    <!-- MANIFESTO -->
    <section class="manifesto" aria-label="Notre mission">
      <div class="manifesto-text">
        <h3>Notre mission</h3>
        <p>Face à une crise d'une complexité inédite, Iran Observateur s'est donné pour mission de fournir une information fiable, contextualisée et indépendante sur le conflit en Iran et ses multiples dimensions — politiques, militaires, humanitaires et diplomatiques.</p>
        <p>Nous croyons que la compréhension des enjeux géopolitiques ne devrait pas être réservée à des cercles d'experts. C'est pourquoi nous construisons des récits accessibles, rigoureux, qui donnent aux citoyens les clés pour comprendre ce qui se passe à Téhéran, dans les couloirs de l'ONU, ou sur les routes de l'exil.</p>
        <p>Notre rédaction réunit des journalistes, des chercheurs et des traducteurs spécialisés sur le Moyen-Orient. Nous puisons dans des sources primaires, nous recoupons systématiquement les informations et nous signalons clairement ce qui reste incertain.</p>
      </div>
      <div class="manifesto-visual" role="blockquote">
        <p class="manifesto-quote">
          « La vérité est le seul luxe que les victimes d'un conflit méritent, et que nous nous devons de leur offrir. »
        </p>
        <div class="manifesto-cite">— La rédaction d'Iran Observateur</div>
      </div>
    </section>

    <!-- PRINCIPES -->
    <section class="principes" aria-label="Nos principes éditoriaux">
      <div class="section-title"><h2>Nos principes éditoriaux</h2></div>
      <div class="principes-grid">
        <div class="principe-card">
          <span class="principe-num">1</span>
          <span class="principe-icon" aria-hidden="true">🔍</span>
          <h3>Vérification systématique</h3>
          <p>Chaque information publiée est recoupée avec au moins deux sources indépendantes. Nous distinguons clairement les faits avérés des informations non confirmées.</p>
        </div>
        <div class="principe-card">
          <span class="principe-num">2</span>
          <span class="principe-icon" aria-hidden="true">⚖</span>
          <h3>Impartialité éditoriale</h3>
          <p>Nous ne prenons parti pour aucun gouvernement ni aucune faction. Notre couverture s'efforce de représenter équitablement les différentes perspectives en présence.</p>
        </div>
        <div class="principe-card">
          <span class="principe-num">3</span>
          <span class="principe-icon" aria-hidden="true">🌐</span>
          <h3>Contextualisation</h3>
          <p>Chaque événement est replacé dans son contexte historique, géopolitique et humain. Nous ne nous contentons pas de rapporter les faits : nous les expliquons.</p>
        </div>
        <div class="principe-card">
          <span class="principe-num">4</span>
          <span class="principe-icon" aria-hidden="true">🔒</span>
          <h3>Protection des sources</h3>
          <p>Nous garantissons l'anonymat de nos sources en Iran et dans la région. La sécurité de ceux qui nous font confiance est une priorité absolue.</p>
        </div>
      </div>
    </section>

    <!-- STATS -->
    <section class="stats-section" aria-label="Nos chiffres">
      <h2>Iran Observateur en chiffres</h2>
      <div class="stats-grid">
        <div class="stat-item">
          <span class="stat-num">79</span>
          <span class="stat-label">Articles publiés</span>
        </div>
        <div class="stat-item">
          <span class="stat-num">7</span>
          <span class="stat-label">Rubriques</span>
        </div>
        <div class="stat-item">
          <span class="stat-num">12</span>
          <span class="stat-label">Sources régulières</span>
        </div>
        <div class="stat-item">
          <span class="stat-num">3</span>
          <span class="stat-label">Journalistes</span>
        </div>
      </div>
    </section>

    <!-- TEAM -->
    <section class="team" aria-label="Notre équipe">
      <div class="section-title"><h2>L'équipe</h2></div>
      <div class="team-grid">
        <div class="team-card">
          <div class="team-avatar" aria-hidden="true">Sm</div>
          <h3>Sarah Morel</h3>
          <div class="team-role">Rédactrice en chef</div>
          <p class="team-bio">Ancienne correspondante au Moyen-Orient pour plusieurs grands médias français. Spécialiste des questions diplomatiques et nucléaires.</p>
        </div>
        <div class="team-card">
          <div class="team-avatar" aria-hidden="true">Kb</div>
          <h3>Kaveh Bahrami</h3>
          <div class="team-role">Journaliste — Iran & Région</div>
          <p class="team-bio">Chercheur et journaliste franco-iranien, spécialisé dans les affaires intérieures iraniennes et les dynamiques de l'IRGC.</p>
        </div>
        <div class="team-card">
          <div class="team-avatar" aria-hidden="true">Lf</div>
          <h3>Lucie Fontaine</h3>
          <div class="team-role">Journaliste — Humanitaire</div>
          <p class="team-bio">Couvre les crises humanitaires depuis quinze ans. Terrain en Irak, Syrie, Yémen. En charge de la rubrique réfugiés et droits humains.</p>
        </div>
      </div>
    </section>

    <!-- FAQ -->
    <section class="faq-section" aria-label="Questions fréquentes">
      <div class="section-title"><h2>Questions fréquentes</h2></div>

      <div class="faq-item">
        <button class="faq-question" onclick="toggleFaq(this)" aria-expanded="false">
          Iran Observateur est-il un média indépendant ?
        </button>
        <div class="faq-answer">
          <p>Oui, entièrement. Iran Observateur ne reçoit aucun financement de gouvernements, d'États ou de partis politiques. Nos ressources proviennent exclusivement des abonnements de nos lecteurs et de partenariats avec des fondations journalistiques indépendantes. Notre ligne éditoriale est définie uniquement par notre rédaction.</p>
        </div>
      </div>

      <div class="faq-item">
        <button class="faq-question" onclick="toggleFaq(this)" aria-expanded="false">
          Comment vérifiez-vous vos informations ?
        </button>
        <div class="faq-answer">
          <p>Tout article publié sur Iran Observateur passe par un processus de vérification en trois étapes : recoupement avec au moins deux sources indépendantes, relecture par un second journaliste, et validation finale par la rédactrice en chef. Lorsqu'une information n'est pas confirmée, nous le signalons explicitement dans le texte.</p>
        </div>
      </div>

      <div class="faq-item">
        <button class="faq-question" onclick="toggleFaq(this)" aria-expanded="false">
          Puis-je vous soumettre une information ou un témoignage ?
        </button>
        <div class="faq-answer">
          <p>Absolument. Vous pouvez nous contacter via le formulaire ci-dessous ou par e-mail chiffré. Si vous êtes en Iran ou dans une zone à risque, nous vous recommandons d'utiliser Signal ou ProtonMail pour nous contacter en toute sécurité. Nous garantissons l'anonymat de toutes nos sources.</p>
        </div>
      </div>

      <div class="faq-item">
        <button class="faq-question" onclick="toggleFaq(this)" aria-expanded="false">
          Comment puis-je soutenir Iran Observateur ?
        </button>
        <div class="faq-answer">
          <p>En vous abonnant à notre newsletter, en partageant nos articles et en souscrivant à un abonnement soutien. Chaque contribution nous permet de maintenir notre indépendance et de financer le travail de terrain de nos journalistes.</p>
        </div>
      </div>
    </section>

    <!-- CONTACT -->
    <section class="contact-section" aria-label="Nous contacter">
      <div class="section-title"><h2>Nous contacter</h2></div>
      <div class="contact-grid">
        <div class="contact-info">
          <h3>Coordonnées</h3>
          <p>Pour toute question éditoriale, demande d'interview ou signalement d'erreur, n'hésitez pas à nous écrire.</p>
          <ul class="contact-items">
            <li>
              <span class="ci-label">E-mail</span>
              <span>redaction@iran-observateur.local</span>
            </li>
            <li>
              <span class="ci-label">Signal</span>
              <span>+33 6 XX XX XX XX (sources sensibles)</span>
            </li>
            <li>
              <span class="ci-label">Adresse</span>
              <span>75 rue de la Presse, 75001 Paris</span>
            </li>
            <li>
              <span class="ci-label">Délai</span>
              <span>Réponse sous 48h ouvrées</span>
            </li>
          </ul>
        </div>
        <div class="contact-form">
          <h3>Envoyer un message</h3>
          <div class="form-group">
            <label for="contact-name">Nom</label>
            <input type="text" id="contact-name" name="name" placeholder="Votre nom" autocomplete="name">
          </div>
          <div class="form-group">
            <label for="contact-email">E-mail</label>
            <input type="email" id="contact-email" name="email" placeholder="votre@email.fr" autocomplete="email">
          </div>
          <div class="form-group">
            <label for="contact-subject">Objet</label>
            <select id="contact-subject" name="subject">
              <option>Question éditoriale</option>
              <option>Signalement d'erreur</option>
              <option>Proposition de témoignage</option>
              <option>Partenariat</option>
              <option>Autre</option>
            </select>
          </div>
          <div class="form-group">
            <label for="contact-message">Message</label>
            <textarea id="contact-message" name="message" placeholder="Votre message…"></textarea>
          </div>
          <button type="button" class="btn-submit">Envoyer le message</button>
        </div>
      </div>
    </section>

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
    function toggleFaq(btn) {
      const answer = btn.nextElementSibling;
      const isOpen = btn.classList.contains('open');
      document.querySelectorAll('.faq-question.open').forEach(q => {
        q.classList.remove('open');
        q.nextElementSibling.style.maxHeight = '0';
        q.setAttribute('aria-expanded', 'false');
      });
      if (!isOpen) {
        btn.classList.add('open');
        answer.style.maxHeight = answer.scrollHeight + 'px';
        btn.setAttribute('aria-expanded', 'true');
      }
    }
  </script>

</body>
</php>
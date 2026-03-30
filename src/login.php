<?php
session_start();
include 'fonction.php';

// Si déjà connecté, rediriger vers admin
if (isset($_SESSION['user_id'])) {
    header('Location: /admin/articles');
    exit;
}

$error = '';
$username = '';

// Traiter le formulaire de login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'Veuillez entrer un nom d\'utilisateur et un mot de passe.';
    } else {
        $user = validateLogin($username, $password);
        if ($user !== null) {
            $_SESSION['user_id']  = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role']     = $user['role'];
            header('Location: /admin/articles');
            exit;
        } else {
            $error = 'Nom d\'utilisateur ou mot de passe incorrect.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — Iran Observateur</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Source+Serif+4:ital,wght@0,300;0,400;0,600;1,300;1,400&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        /* ── VARIABLES ─────────────────────────────── */
        :root {
            --ink:    #0f0e0c;
            --paper:  #f5f0e8;
            --cream:  #ede7d8;
            --accent: #b8341b;
            --muted:  #6b6355;
            --border: #c8bfad;
            --white:  #ffffff;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: var(--ink);
            font-family: 'Source Serif 4', Georgia, serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            /* grain texture via repeating pattern */
            background-image:
                radial-gradient(ellipse at 20% 50%, rgba(184,52,27,0.08) 0%, transparent 60%),
                radial-gradient(ellipse at 80% 20%, rgba(26,58,92,0.10) 0%, transparent 55%);
        }

        /* ── BRAND ──────────────────────────────────── */
        .login-brand {
            text-align: center;
            margin-bottom: 36px;
        }
        .login-brand a {
            text-decoration: none;
        }
        .login-brand h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(32px, 5vw, 52px);
            font-weight: 900;
            color: var(--paper);
            line-height: 1;
            letter-spacing: -0.01em;
        }
        .login-brand h1 span { color: var(--accent); }
        .login-brand .brand-sub {
            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            letter-spacing: 0.28em;
            text-transform: uppercase;
            color: rgba(245,240,232,0.35);
            margin-top: 8px;
        }

        /* ── CARD ───────────────────────────────────── */
        .login-card {
            background: var(--paper);
            border-top: 4px solid var(--accent);
            width: 100%;
            max-width: 420px;
            padding: 44px 40px 36px;
        }

        .login-card-header {
            text-align: center;
            margin-bottom: 32px;
            padding-bottom: 24px;
            border-bottom: 1px solid var(--border);
        }
        .login-card-header .card-label {
            font-family: 'JetBrains Mono', monospace;
            font-size: 9px;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 10px;
        }
        .login-card-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            font-weight: 700;
            font-style: italic;
            color: var(--ink);
            line-height: 1.2;
        }

        /* ── ERROR ──────────────────────────────────── */
        .error-message {
            background: rgba(184,52,27,0.08);
            border-left: 3px solid var(--accent);
            color: var(--accent);
            padding: 12px 16px;
            margin-bottom: 24px;
            font-family: 'Source Serif 4', serif;
            font-size: 14px;
            line-height: 1.5;
        }

        /* ── FORM ───────────────────────────────────── */
        .form-group { margin-bottom: 20px; }

        .form-group label {
            display: block;
            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 7px;
        }

        .form-group input {
            width: 100%;
            border: 1px solid var(--border);
            padding: 11px 14px;
            font-family: 'Source Serif 4', serif;
            font-size: 15px;
            background: var(--white);
            color: var(--ink);
            outline: none;
            transition: border-color 0.2s, background 0.2s;
            appearance: none;
            -webkit-appearance: none;
            border-radius: 0;
        }
        .form-group input:focus {
            border-color: var(--accent);
            background: var(--white);
        }

        /* ── SUBMIT ─────────────────────────────────── */
        .submit-btn {
            width: 100%;
            padding: 13px 20px;
            background: var(--ink);
            color: var(--paper);
            border: none;
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 8px;
            border-radius: 0;
        }
        .submit-btn:hover { background: var(--accent); }
        .submit-btn:active { opacity: 0.9; }

        /* ── FOOTER LINK ────────────────────────────── */
        .login-back {
            margin-top: 24px;
            text-align: center;
            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }
        .login-back a {
            color: rgba(245,240,232,0.4);
            text-decoration: none;
            transition: color 0.18s;
        }
        .login-back a:hover { color: var(--accent); }

        /* ── RULE ORNAMENT ──────────────────────────── */
        .ornament {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 28px 0 0;
        }
        .ornament::before, .ornament::after {
            content: "";
            flex: 1;
            height: 1px;
            background: var(--border);
        }
        .ornament span {
            font-family: 'Playfair Display', serif;
            font-size: 16px;
            color: var(--border);
        }

        @media (max-width: 480px) {
            .login-card { padding: 32px 24px 28px; }
        }
    </style>
</head>
<body>

    <!-- Brand -->
    <div class="login-brand">
        <a href="/">
            <h1>Iran <span>Observateur</span></h1>
            <div class="brand-sub">Espace Administration</div>
        </a>
    </div>

    <!-- Card -->
    <div class="login-card">

        <div class="login-card-header">
            <div class="card-label">Accès restreint</div>
            <h2>Connexion</h2>
        </div>

        <?php if ($error): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    value="<?= htmlspecialchars($username) ?>"
                    required
                    autofocus
                    autocomplete="username"
                >
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    autocomplete="current-password"
                >
            </div>
            <button type="submit" class="submit-btn">Se connecter →</button>
        </form>

        <div class="ornament"><span>❧</span></div>

    </div>

    <!-- Retour au site -->
    <div class="login-back">
        <a href="/">← Retour au site public</a>
    </div>
    <script src="/lazy-load.js"></script>

</body>
</html>
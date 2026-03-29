-- ============================================================
--  Base de données — Site d'informations sur la guerre en Iran
--  Mini-projet Web Design — Mars 2026
-- ============================================================

-- Suppression des tables dans l'ordre inverse des dépendances
DROP TABLE IF EXISTS article_tags CASCADE;
DROP TABLE IF EXISTS medias CASCADE;
DROP TABLE IF EXISTS articles CASCADE;
DROP TABLE IF EXISTS tags CASCADE;
DROP TABLE IF EXISTS categories CASCADE;
DROP TABLE IF EXISTS users CASCADE;

-- Types ENUM
DROP TYPE IF EXISTS user_role;
DROP TYPE IF EXISTS article_status;

CREATE TYPE user_role AS ENUM ('admin', 'editor');
CREATE TYPE article_status AS ENUM ('draft', 'published', 'archived');

-- ============================================================
-- TABLE : users
-- Comptes du back-office (admin et éditeurs)
-- ============================================================
CREATE TABLE users (
    id            SERIAL PRIMARY KEY,
    username      VARCHAR(80)  NOT NULL UNIQUE,
    email         VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role          user_role    NOT NULL DEFAULT 'editor',
    created_at    TIMESTAMP    NOT NULL DEFAULT NOW()
);

-- ============================================================
-- TABLE : categories
-- Hiérarchique : parent_id permet les sous-catégories
-- ============================================================
CREATE TABLE categories (
    id          SERIAL PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    slug        VARCHAR(120) NOT NULL UNIQUE,
    description TEXT,
    parent_id   INT REFERENCES categories(id) ON DELETE SET NULL
);

-- ============================================================
-- TABLE : articles
-- Contenu principal du site
-- ============================================================
CREATE TABLE articles (
    id               SERIAL PRIMARY KEY,
    user_id          INT          NOT NULL REFERENCES users(id) ON DELETE RESTRICT,
    category_id      INT          REFERENCES categories(id) ON DELETE SET NULL,
    title            VARCHAR(200) NOT NULL,
    slug             VARCHAR(220) NOT NULL UNIQUE,
    content          TEXT         NOT NULL,
    meta_title       VARCHAR(70),
    meta_description VARCHAR(160),
    status           article_status NOT NULL DEFAULT 'draft',
    published_at     TIMESTAMP,
    created_at       TIMESTAMP    NOT NULL DEFAULT NOW(),
    updated_at       TIMESTAMP    NOT NULL DEFAULT NOW()
);

-- ============================================================
-- TABLE : medias
-- Images associées à un article
-- ============================================================
CREATE TABLE medias (
    id          SERIAL PRIMARY KEY,
    article_id  INT          NOT NULL REFERENCES articles(id) ON DELETE CASCADE,
    filename    VARCHAR(255) NOT NULL,
    alt_text    VARCHAR(255) NOT NULL DEFAULT '',
    mime_type   VARCHAR(80)  NOT NULL DEFAULT 'image/jpeg',
    file_size   INT,
    uploaded_at TIMESTAMP    NOT NULL DEFAULT NOW()
);

-- ============================================================
-- TABLE : tags
-- Mots-clés réutilisables
-- ============================================================
CREATE TABLE tags (
    id   SERIAL PRIMARY KEY,
    name VARCHAR(80)  NOT NULL UNIQUE,
    slug VARCHAR(100) NOT NULL UNIQUE
);

-- ============================================================
-- TABLE : article_tags
-- Liaison many-to-many articles <-> tags
-- ============================================================
CREATE TABLE article_tags (
    article_id INT NOT NULL REFERENCES articles(id) ON DELETE CASCADE,
    tag_id     INT NOT NULL REFERENCES tags(id)     ON DELETE CASCADE,
    PRIMARY KEY (article_id, tag_id)
);

-- ============================================================
-- INDEX pour les performances et l'URL rewriting
-- ============================================================
CREATE INDEX idx_articles_slug        ON articles(slug);
CREATE INDEX idx_articles_status      ON articles(status);
CREATE INDEX idx_articles_category    ON articles(category_id);
CREATE INDEX idx_articles_published   ON articles(published_at DESC);
CREATE INDEX idx_categories_slug      ON categories(slug);
CREATE INDEX idx_tags_slug            ON tags(slug);

-- ============================================================
-- TRIGGER : mise à jour automatique de updated_at
-- ============================================================
CREATE OR REPLACE FUNCTION update_updated_at()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = NOW();
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trg_articles_updated_at
BEFORE UPDATE ON articles
FOR EACH ROW EXECUTE FUNCTION update_updated_at();

-- ============================================================
-- DONNÉES DE TEST
-- ============================================================

-- Compte admin par défaut (mot de passe : admin)
INSERT INTO users (username, email, password_hash, role) VALUES
('admin', 'admin@iran-info.local',
 '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
 'admin'),
('editeur1', 'editeur@iran-info.local',
 '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
 'editor');

-- Catégories (avec hiérarchie)
INSERT INTO categories (name, slug, description, parent_id) VALUES
('Politique',            'politique',             'Actualités politiques sur le conflit en Iran',       NULL),
('Militaire',            'militaire',             'Opérations et forces armées',                        NULL),
('Humanitaire',          'humanitaire',           'Situation des populations civiles',                  NULL),
('Diplomatie',           'diplomatie',            'Négociations et relations internationales',          NULL),
('Sanctions',            'sanctions',             'Sanctions économiques et embargo',                   4),
('Frappes aériennes',    'frappes-aeriennes',     'Opérations aériennes et drones',                    2),
('Réfugiés',             'refugies',              'Flux migratoires et camps de réfugiés',              3);

-- Tags
INSERT INTO tags (name, slug) VALUES
('IRGC',            'irgc'),
('ONU',             'onu'),
('États-Unis',      'etats-unis'),
('Israël',          'israel'),
('Nucléaire',       'nucleaire'),
('Drones',          'drones'),
('Sanctions',       'sanctions'),
('Aide humanitaire','aide-humanitaire');

-- Articles de démonstration
INSERT INTO articles (user_id, category_id, title, slug, content, meta_title, meta_description, status, published_at) VALUES
(
  1, 1,
  'Chronologie du conflit : les origines de la crise en Iran',
  'chronologie-conflit-origines-crise-iran',
  '<h2>Les prémices du conflit</h2><p>La montée des tensions entre l''Iran et les puissances occidentales remonte aux années 2000, principalement autour du programme nucléaire iranien. En 2015, l''accord de Vienne (JCPOA) semblait ouvrir une voie diplomatique, mais le retrait américain en 2018 a précipité une nouvelle escalade.</p><h2>L''accélération des hostilités</h2><p>À partir de 2024, les incidents militaires se sont multipliés dans la région du Golfe Persique, impliquant des frappes de drones et des attaques contre des infrastructures pétrolières.</p>',
  'Chronologie du conflit en Iran — Origines et escalade',
  'Retracez les origines et l''évolution du conflit en Iran, du programme nucléaire aux tensions militaires actuelles.',
  'published', NOW() - INTERVAL '5 days'
),
(
  1, 2,
  'Les forces en présence : IRGC, armée régulière et milices',
  'forces-en-presence-irgc-armee-reguliere-milices',
  '<h2>Le Corps des gardiens de la révolution islamique</h2><p>L''IRGC constitue le pilier militaire du régime iranien. Distinct de l''armée régulière, il dispose de sa propre chaîne de commandement et contrôle les forces Quds, responsables des opérations extérieures.</p><h2>Les milices alliées</h2><p>Le Hezbollah au Liban, les Houthis au Yémen et diverses factions irakiennes forment ce que Téhéran appelle l''«axe de résistance».</p>',
  'Forces militaires iraniennes — IRGC, armée et milices',
  'Analyse des forces militaires iraniennes : IRGC, armée régulière et réseau de milices alliées dans la région.',
  'published', NOW() - INTERVAL '3 days'
),
(
  2, 3,
  'Situation humanitaire : 2 millions de déplacés en 2025',
  'situation-humanitaire-deplaces-iran-2025',
  '<h2>Une crise humanitaire sans précédent</h2><p>Selon le HCR, le conflit a provoqué le déplacement de plus de deux millions de civils en 2025. Les camps de réfugiés en Irak et en Turquie peinent à absorber cet afflux massif.</p><h2>Accès humanitaire limité</h2><p>Les organisations non gouvernementales dénoncent des restrictions sévères à l''acheminement de l''aide médicale et alimentaire dans les zones de conflit.</p>',
  'Rapport HCR sur les conditions humanitaires en Iran',
  'La crise humanitaire en Iran en 2025 : 2 millions de déplacés, accès limité à l''aide et témoignages des ONG.',
  'published', NOW() - INTERVAL '1 day'
),
(
  1, 4,
  'Négociations à Genève : état des pourparlers en mars 2026',
  'negociations-geneve-pourparlers-mars-2026',
  '<h2>Une reprise fragile des négociations</h2><p>Les délégations américaine, européenne et iranienne se sont retrouvées à Genève début mars 2026 pour tenter de relancer un dialogue diplomatique suspendu depuis l''automne 2025.</p><h2>Les points de blocage</h2><p>L''enrichissement de l''uranium reste la principale pomme de discorde, l''Iran refusant tout plafond inférieur à 60% de pureté.</p>',
  'Négociations à Genève sur le dossier iranien',
  'Bilan des négociations diplomatiques à Genève en mars 2026 sur le conflit iranien et le dossier nucléaire.',
  'draft', NULL
);

-- Liaison articles <-> tags
INSERT INTO article_tags (article_id, tag_id) VALUES
(1, 3), (1, 4), (1, 5),
(2, 1), (2, 6),
(3, 2), (3, 8),
(4, 2), (4, 3), (4, 5);

-- Médias (images des articles)
INSERT INTO medias (article_id, filename, alt_text, mime_type) VALUES
(1, 'carte-iran-conflit.jpg',      'Carte du conflit en Iran et dans la région du Golfe Persique', 'image/jpeg'),
(2, 'soldats-irgc.jpg',            'Soldats du Corps des gardiens de la révolution islamique en exercice', 'image/jpeg'),
(3, 'camp-refugies-iran.jpg',      'Camp de réfugiés iraniens à la frontière irakienne en 2025', 'image/jpeg'),
(3, 'aide-humanitaire-ong.jpg',    'Distribution de vivres par une ONG dans une zone de conflit', 'image/jpeg'),
(4, 'negociations-geneve.jpg',     'Table des négociations diplomatiques à Genève sur le dossier iranien', 'image/jpeg');

-- ============================================================
-- Vérification rapide
-- ============================================================
SELECT
  (SELECT COUNT(*) FROM users)       AS nb_users,
  (SELECT COUNT(*) FROM categories)  AS nb_categories,
  (SELECT COUNT(*) FROM articles)    AS nb_articles,
  (SELECT COUNT(*) FROM tags)        AS nb_tags,
  (SELECT COUNT(*) FROM medias)      AS nb_medias;
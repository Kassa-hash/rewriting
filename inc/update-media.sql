-- Exemple : mise à jour des noms de fichiers images pour la table medias

UPDATE medias SET filename = 'carte-iran-conflit.png' WHERE filename LIKE '%carte%';
UPDATE medias SET filename = 'camp-refugies-iran.jpeg' WHERE filename LIKE '%refugie%';
UPDATE medias SET filename = 'soldats-irgc.jpg' WHERE filename LIKE '%soldat%';
UPDATE medias SET filename = 'negociations-geneve.jpeg' WHERE filename LIKE '%geneve%';
UPDATE medias SET filename = 'aide-humanitaire-ong.jpg' WHERE filename LIKE '%aide%';

-- Vérification
SELECT id, article_id, filename FROM medias;
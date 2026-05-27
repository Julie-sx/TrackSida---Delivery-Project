-- Utilisation PHP: remplacer les ? avec querySecure($sql, $params)

USE rdqicartracksida;

-- ============================================================
-- Utilisateurs / connexion
-- Table: utilisateurs
-- Colonnes: id_utilisateur, pseudo, email, mot_de_passe, date_naissance,
-- genre, date_inscription, derniere_connexion, est_actif,
-- token_email, email_verifie, niveau
-- ============================================================

-- Inscription
INSERT INTO utilisateurs
  (pseudo, email, mot_de_passe, date_naissance, genre, token_email)
VALUES
  (?, ?, ?, ?, ?, ?);

-- Connexion: recuperer l'utilisateur par email
SELECT
  id_utilisateur,
  pseudo,
  email,
  mot_de_passe,
  date_naissance,
  genre,
  date_inscription,
  derniere_connexion,
  est_actif,
  email_verifie,
  niveau
FROM utilisateurs
WHERE email = ?
  AND est_actif = 1
LIMIT 1;

-- Mettre a jour la derniere connexion
UPDATE utilisateurs
SET derniere_connexion = CURRENT_TIMESTAMP
WHERE id_utilisateur = ?;

-- Donnees pour la page profil
SELECT
  id_utilisateur,
  pseudo,
  email,
  date_naissance,
  genre,
  date_inscription,
  derniere_connexion,
  email_verifie,
  niveau
FROM utilisateurs
WHERE id_utilisateur = ?
LIMIT 1;

-- Modifier le profil avec les colonnes qui existent dans la base
UPDATE utilisateurs
SET
  pseudo = ?,
  email = ?,
  date_naissance = ?,
  genre = ?
WHERE id_utilisateur = ?;

-- Changer le mot de passe
UPDATE utilisateurs
SET mot_de_passe = ?
WHERE id_utilisateur = ?;

-- Desactiver le compte sans supprimer les donnees
UPDATE utilisateurs
SET est_actif = 0
WHERE id_utilisateur = ?;

-- Supprimer definitivement le compte
DELETE FROM utilisateurs
WHERE id_utilisateur = ?;

-- Statistiques profil compatibles avec la base
SELECT
  (SELECT COUNT(*)
   FROM partenaires
   WHERE id_utilisateur = ?) AS contacts_count,
  (SELECT COUNT(*)
   FROM declarations_ist
   WHERE id_utilisateur = ?) AS declarations_count,
  DATEDIFF(CURRENT_DATE, DATE(date_inscription)) AS active_days
FROM utilisateurs
WHERE id_utilisateur = ?;

-- ============================================================
-- Sessions
-- Table: tokens_session
-- ============================================================

-- Creer une session
INSERT INTO tokens_session
  (id_utilisateur, token, ip_creation, user_agent, date_expiration)
VALUES
  (?, ?, ?, ?, ?);

-- Verifier une session active
SELECT
  t.id_token,
  t.id_utilisateur,
  u.pseudo,
  u.email,
  u.niveau
FROM tokens_session t
INNER JOIN utilisateurs u ON u.id_utilisateur = t.id_utilisateur
WHERE t.token = ?
  AND t.est_revoque = 0
  AND t.date_expiration > CURRENT_TIMESTAMP
  AND u.est_actif = 1
LIMIT 1;

-- Deconnexion
UPDATE tokens_session
SET est_revoque = 1
WHERE token = ?
  AND id_utilisateur = ?;

-- Nettoyer les sessions expirees
UPDATE tokens_session
SET est_revoque = 1
WHERE date_expiration <= CURRENT_TIMESTAMP;

-- ============================================================
-- Contacts / partenaires
-- Table: partenaires
-- ============================================================

-- Liste des partenaires d'un utilisateur
SELECT
  id_partenaire,
  id_utilisateur,
  surnom,
  email_partenaire,
  telephone,
  date_contact,
  notes,
  date_ajout
FROM partenaires
WHERE id_utilisateur = ?
ORDER BY date_ajout DESC;

-- Compter les partenaires
SELECT COUNT(*) AS total
FROM partenaires
WHERE id_utilisateur = ?;

-- Ajouter un partenaire
-- Il faut au moins email_partenaire ou telephone cote PHP.
INSERT INTO partenaires
  (id_utilisateur, surnom, email_partenaire, telephone, date_contact, notes)
VALUES
  (?, ?, ?, ?, ?, ?);

-- Modifier un partenaire
UPDATE partenaires
SET
  surnom = ?,
  email_partenaire = ?,
  telephone = ?,
  date_contact = ?,
  notes = ?
WHERE id_partenaire = ?
  AND id_utilisateur = ?;

-- Supprimer un partenaire
DELETE FROM partenaires
WHERE id_partenaire = ?
  AND id_utilisateur = ?;

-- Liste pour la selection dans Sid'Alerte
SELECT
  id_partenaire,
  surnom AS nom_affiche,
  UPPER(LEFT(COALESCE(surnom, email_partenaire, telephone), 2)) AS initiales
FROM partenaires
WHERE id_utilisateur = ?
ORDER BY date_ajout DESC;

-- ============================================================
-- IST
-- Table: ist
-- ============================================================

-- Liste des IST publiees pour remplir les selects
SELECT
  id_ist,
  nom,
  description,
  symptomes,
  transmission,
  traitement,
  prevention
FROM ist
WHERE est_publie = 1
ORDER BY nom;

-- Recuperer l'id_ist depuis le nom choisi dans le formulaire
SELECT id_ist
FROM ist
WHERE nom = ?
LIMIT 1;

-- Ajouter une IST dans le referentiel
INSERT INTO ist
  (nom, description, symptomes, transmission, traitement, prevention, est_publie)
VALUES
  (?, ?, ?, ?, ?, ?, ?);

-- ============================================================
-- Sid'Alerte / declarations IST
-- Tables: declarations_ist, notifications_anonymes, messages_notification
-- ============================================================

-- Declarer une IST
-- id_ist doit venir de la table ist.
INSERT INTO declarations_ist
  (id_utilisateur, id_ist, date_diagnostic, commentaire)
VALUES
  (?, ?, ?, ?);

-- Historique des declarations de l'utilisateur
SELECT
  d.id_declaration,
  i.nom AS nom_ist,
  d.date_diagnostic,
  d.commentaire,
  d.date_declaration
FROM declarations_ist d
INNER JOIN ist i ON i.id_ist = d.id_ist
WHERE d.id_utilisateur = ?
ORDER BY d.date_declaration DESC;

-- Creer une notification anonyme pour un partenaire
INSERT INTO notifications_anonymes
  (id_declaration, id_partenaire, canal, statut, token_unique)
VALUES
  (?, ?, ?, 'en_attente', ?);

-- Message associe a la notification
INSERT INTO messages_notification
  (id_notification, sujet, corps, langue)
VALUES
  (?, ?, ?, ?);

-- Notifications anonymes d'une declaration
SELECT
  n.id_notification,
  n.id_declaration,
  n.id_partenaire,
  p.surnom,
  p.email_partenaire,
  p.telephone,
  n.canal,
  n.statut,
  n.token_unique,
  n.date_envoi,
  n.date_lecture,
  n.date_creation
FROM notifications_anonymes n
INNER JOIN partenaires p ON p.id_partenaire = n.id_partenaire
WHERE n.id_declaration = ?
ORDER BY n.date_creation DESC;

-- Marquer une notification comme envoyee
UPDATE notifications_anonymes
SET statut = 'envoyee',
    date_envoi = CURRENT_TIMESTAMP
WHERE id_notification = ?;

-- Marquer une notification comme lue via son token
UPDATE notifications_anonymes
SET statut = 'lue',
    date_lecture = CURRENT_TIMESTAMP
WHERE token_unique = ?;

-- Lire le message public depuis un token anonyme
SELECT
  n.id_notification,
  n.statut,
  n.date_creation,
  m.sujet,
  m.corps,
  m.langue
FROM notifications_anonymes n
INNER JOIN messages_notification m ON m.id_notification = n.id_notification
WHERE n.token_unique = ?
LIMIT 1;

-- ============================================================
-- Logs d'activite
-- Table: logs_activite
-- ============================================================

-- Ajouter un log
INSERT INTO logs_activite
  (id_utilisateur, action, details, ip)
VALUES
  (?, ?, CAST(? AS JSON), ?);

-- Voir les derniers logs d'un utilisateur
SELECT
  id_log,
  action,
  details,
  ip,
  date_action
FROM logs_activite
WHERE id_utilisateur = ?
ORDER BY date_action DESC
LIMIT 50;

-- ============================================================
-- Blog / tags
-- Tables: blogs, tags, tags_list
-- ============================================================

-- Liste des blogs avec leurs tags
SELECT
  b.id_blog,
  b.blog_name,
  b.blog_url,
  GROUP_CONCAT(t.tag_name ORDER BY t.tag_name SEPARATOR ', ') AS tags
FROM blogs b
LEFT JOIN tags_list tl ON tl.id_blog = b.id_blog
LEFT JOIN tags t ON t.id_tag = tl.id_tag
GROUP BY b.id_blog, b.blog_name, b.blog_url
ORDER BY b.blog_name;

-- Ajouter un blog
INSERT INTO blogs
  (blog_name, blog_url)
VALUES
  (?, ?);

-- Ajouter un tag
INSERT INTO tags
  (tag_name)
VALUES
  (?);

-- Associer un tag a un blog
INSERT INTO tags_list
  (id_blog, id_tag)
VALUES
  (?, ?);

-- ============================================================
-- Requetes utiles pour l'administration
-- ============================================================

-- Tous les utilisateurs
SELECT
  id_utilisateur,
  pseudo,
  email,
  genre,
  date_inscription,
  derniere_connexion,
  est_actif,
  email_verifie,
  niveau
FROM utilisateurs
ORDER BY date_inscription DESC;

-- Toutes les declarations IST
SELECT
  d.id_declaration,
  u.pseudo,
  u.email,
  i.nom AS nom_ist,
  d.date_diagnostic,
  d.commentaire,
  d.date_declaration
FROM declarations_ist d
INNER JOIN utilisateurs u ON u.id_utilisateur = d.id_utilisateur
INNER JOIN ist i ON i.id_ist = d.id_ist
ORDER BY d.date_declaration DESC;

-- Notifications anonymes en attente
SELECT
  n.id_notification,
  n.canal,
  n.statut,
  n.date_creation,
  p.surnom,
  p.email_partenaire,
  p.telephone
FROM notifications_anonymes n
INNER JOIN partenaires p ON p.id_partenaire = n.id_partenaire
WHERE n.statut = 'en_attente'
ORDER BY n.date_creation ASC;

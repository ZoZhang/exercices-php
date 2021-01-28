# phpmvc

Un exercice de Blog basique en PHP avec une architecture MVC simplififée

### Liens
- [Frontend Demo](http://phpmvc.zhangzhao.fr)
- [Backend Demo](http://phpmvc.zhangzhao.fr/?type=admin&action=articles)  - username: admin | password: admin
- [Code Source](https://github.com/ZoZhang/exercices-php/tree/master/phpmvc)

### Avancement

- [x] La page d’accueil
- [x] Les pages News et Blog
- [x] Un article
- [x] La page de contact et le formulaire de newsletter
- [x] Le CRUD d’un article
- [x] Gestion des commentaires
- [x] Ajout de fichiers média pour les articles
- [x] Identification / Déconnexion

### Problèmes rencontrés
- Il y a un erreur de constructeur dans les models qui manquent un soulignement, par exemple:
<pre>Warning: Declaration of Application\Models\Article::_construct($data) should be compatible with Application\Models\Post::_construct()</pre>

- La structure de table `newsletter` dont le type de newsletter_email est en `int`, ça ne peut pas enregistrer l'adresse email,par exemple:<pre>DROP TABLE IF EXISTS `newsletter`;
CREATE TABLE IF NOT EXISTS `newsletter` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  <del>`newsletter_email` int(11) NOT NULL</del>,
    `newsletter_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;</pre>

### Démonstration

##Frontend
##### Page d'accueil
<img src="https://imgur.com/GU2d330.png"/>

#### Page d'un article sur le commentaire
<img src="https://imgur.com/kaUFZrU.png"/>

#### Page d'un article sur le newslettre
<img src="https://imgur.com/7LFTrFc.png"/>

#### Page du contact
<img src="https://imgur.com/Q3O23uS.png"/>

###Backend
#### Page d'identification
<img src="https://imgur.com/6pLe2xj.png"/>

#### Page du management des articles
<img src="https://imgur.com/oLnTJZo.png"/>

#### Page de modification des articles
<img src="https://imgur.com/huW0nDf.png"/>


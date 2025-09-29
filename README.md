# Guide de déploiement de l’application EcoRide

## Prérequis

- Git  
- Heroku CLI  
- Docker : PHP8, MySQL, MongoDB
- MongoDB Atlas


## Étapes

1. Cloner le projet  
git clone https://github.com/Gwladyslsn/Ecoride.git
cd ecoride

1. Installer les dépendances 
composer install

2. Configurer les variables d'environnement
Créer un fichier .env à partir de .env.example  
Remplacer les valeurs par celles de votre environnement  

3. Définir les variables d'environnement sur Heroku

4. Déployer la base de données MySQL avec HeidiSQL
Créez une base MySQL accessible à distance (chez votre hébergeur ou sur un serveur cloud).
Ouvrez HeidiSQL et configurez la connexion (hôte, port, utilisateur, mot de passe).
Importez le fichier SQL du projet (structure + données initiales).
Vérifiez que les tables sont bien créées.

5. Déployer la base NoSQL MongoDB 
Connectez-vous à MongoDB Atlas.
Créez un cluster gratuit.
Ajoutez un utilisateur avec un mot de passe sécurisé.
Autorisez votre IP (ou 0.0.0.0/0 pour toutes les adresses pour les test uniquement).
Récupérez l’URI de connexion et mettez-la dans MONGODB_URI sur Heroku.

6. Deployer sur Heroku 
heroku create ecoride-app
git push heroku main
heroku open
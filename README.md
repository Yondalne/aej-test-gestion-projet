# Plateforme de Gestion des Projets de Développement

Cette plateforme permet la gestion complète des projets de développement, offrant une interface pour les promoteurs de projets et un back-office administratif. Elle a été développée dans le cadre du test de recrutement AEJ.

![Capture d'écran de la plateforme](screenshot.png)

## Table des matières

- [Fonctionnalités](#fonctionnalités)
- [Architecture & Choix Technologiques](#architecture--choix-technologiques)
- [Prérequis](#prérequis)
- [Installation](#installation)
- [Utilisation](#utilisation)
- [Utilisateurs par défaut](#utilisateurs-par-défaut)
- [Structure du projet](#structure-du-projet)

## Fonctionnalités

### Fonctionnalités obligatoires implémentées ✅

#### Front-Office (Côté Promoteur)
- Inscription et authentification des promoteurs
- Formulaire complet de soumission de projet avec validation
- Téléchargement de fichiers (CNI, photo, plan d'affaires)
- Dashboard personnalisé avec statistiques
- Gestion des projets (création, modification, visualisation)
- Interface responsive et moderne

#### Back-Office (Côté Administrateur)
- Authentification administrateur sécurisée
- Tableau de bord avec statistiques globales
- Gestion complète des projets (recherche, filtrage, tri)
- Système de validation/rejet des projets avec justification
- Interface utilisateur intuitive et professionnelle

#### Fonctionnalités complémentaires
- ✅ Notifications par email aux promoteurs (lors de la soumission, validation ou rejet)
- ✅ Génération de PDF pour les résumés de projets
- ✅ Export des données en format XLSX (Excel)

### Bonus implémentés 🔹

- 🔹 Conteneurisation avec Docker (Dockerfile et docker-compose.yml)
- 🔹 UI/UX améliorée avec des composants réutilisables et animations

## Architecture & Choix Technologiques

### Stack technique

- **Backend**: Laravel 12 (PHP 8.2)
- **Frontend**: Vue.js 3 avec Composition API
- **Base de données**: MySQL
- **Authentification**: Inertia.js avec Vue 3
- **Génération PDF**: barryvdh/laravel-dompdf
- **Export Excel**: maatwebsite/excel et xlsx.js (côté client)
- **UI**: TailwindCSS 4
- **Emails**: Laravel Mail avec Mailtrap (dev) ou SMTP (prod)
- **Compilation des assets**: Vite

### Pourquoi Inertia.js ?

J'ai choisi d'utiliser Inertia.js plutôt qu'une architecture séparée frontend/backend pour plusieurs raisons :

1. **Développement plus rapide et efficace**: Inertia permet d'utiliser Laravel pour le backend et Vue pour le frontend sans avoir à construire une API RESTful distincte.

2. **Expérience utilisateur optimisée**: Avec Inertia, l'application bénéficie de la réactivité d'une SPA (Single Page Application) tout en conservant les avantages du routage côté serveur.

3. **Sécurité renforcée**: L'authentification Laravel est directement intégrée, évitant les problématiques de gestion des tokens JWT dans une architecture API séparée.

4. **Simplicité de maintenance**: Un seul dépôt à gérer, avec une séparation claire des préoccupations entre le frontend et le backend.

5. **Performances améliorées**: Seules les données nécessaires sont transmises, réduisant ainsi la charge réseau comparée à une API classique qui renvoie souvent des données superflues.

## Prérequis

- PHP 8.1+ avec extensions (BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML)
- Composer 2+
- Node.js 16+ et npm 8+
- MySQL 5.7+ ou MariaDB 10.3+
- Serveur web (Apache/Nginx) ou PHP built-in server pour le développement

## Installation

1. **Cloner le dépôt**
   ```bash
   git clone https://github.com/votre-username/aej-test-recrutement.git
   cd aej-test-recrutement
   ```

2. **Installer les dépendances PHP**
   ```bash
   composer install
   ```

3. **Installer les dépendances JavaScript**
   ```bash
   npm install
   ```

4. **Configurer l'environnement**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configurer la base de données**  
   Modifiez le fichier `.env` avec vos informations de connexion à la base de données :
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=aej_projets
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Configurer le service de mail**  
   Pour le développement, vous pouvez utiliser Mailtrap :
   ```
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.mailtrap.io
   MAIL_PORT=2525
   MAIL_USERNAME=votre_username_mailtrap
   MAIL_PASSWORD=votre_password_mailtrap
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS="projets@aej.ci"
   MAIL_FROM_NAME="${APP_NAME}"
   ```

7. **Migrer et remplir la base de données**
   ```bash
   php artisan migrate --seed
   ```

8. **Créer le lien symbolique pour le stockage**
   ```bash
   php artisan storage:link
   ```

9. **Compiler les assets**
   ```bash
   npm run dev
   ```
   Pour la production :
   ```bash
   npm run build
   ```

10. **Démarrer le serveur de développement**
    ```bash
    php artisan serve
    ```

## Utilisation

Accédez à l'application via l'URL : `http://localhost:8000`

### Fonctionnalités promoteur

- Inscription et connexion 
- Consultation du tableau de bord avec statistiques personnelles
- Soumission de nouveaux projets
- Modification des projets en attente ou rejetés
- Consultation des détails et statuts des projets
- Téléchargement des résumés en PDF

### Fonctionnalités administrateur

- Connexion au back-office
- Vue d'ensemble des projets et statistiques
- Recherche et filtrage avancés des projets
- Validation ou rejet des projets avec justification
- Export des données en Excel
- Génération et téléchargement des PDF de résumé

## Utilisateurs par défaut

L'application est livrée avec deux utilisateurs prédéfinis pour les tests :

### Promoteur
- **Email**: promoteur@example.com
- **Mot de passe**: password
- **Nom**: Uzumaki Naruto

### Administrateur
- **Email**: admin@example.com
- **Mot de passe**: password
- **Nom**: Namikaze Minato

## Structure du projet

```
├── app                       # Code source PHP
│   ├── Http                  # Contrôleurs, Middlewares, Requests
│   ├── Models                # Modèles de données
│   ├── Services              # Services métier (PDF, Email, etc.)
│   └── Notifications         # Notifications et emails
├── database                  # Migrations et seeders
├── resources                 # Ressources frontend
│   ├── css                   # Styles CSS/SCSS
│   ├── js                    # Code JavaScript
│   │   ├── Components        # Composants Vue réutilisables
│   │   ├── Composables       # Hooks Vue personnalisés
│   │   ├── Layouts           # Layouts de l'application
│   │   └── Pages             # Pages Vue.js (structure Inertia)
│   └── views                 # Templates Blade (emails, etc.)
├── routes                    # Définition des routes
├── storage                   # Stockage (fichiers uploadés, logs)
├── tests                     # Tests unitaires et fonctionnels
└── public                    # Assets publics compilés
```

---

## Développement

Le projet utilise Vite pour la compilation des assets.

```bash
# Pour le développement (avec hot reload)
npm run dev

# Pour la production
npm run build
```

## Docker (Bonus implémenté)

L'application est conteneurisée pour faciliter le déploiement:

```bash
# Construire et démarrer les conteneurs
docker-compose up -d

# Installer les dépendances
docker-compose exec app composer install
docker-compose exec app npm install
docker-compose exec app npm run build

# Configurer l'application
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan storage:link
docker-compose exec app php artisan migrate --seed
```

L'application sera accessible à l'adresse: `http://localhost:8080`

---

## Crédits

Développé par Yondalne dans le cadre du test de recrutement pour l'Agence Emploi Jeunes.

---

Pour toute question ou assistance, veuillez contacter [benalicherif.yd@gmail.com]

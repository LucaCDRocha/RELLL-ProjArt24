# Introduction

# Instalation dev
Cloner le projet et ce déplacer dedans
```bash
$ git clone https://github.com/LucaCDRocha/RELLL-ProjArt24.git
$ cd RELLL-ProjArt24
```

Installer les dépendances
```bash
$ composer install
$ npm install
```

Copier le fichier .env.example en .env
```bash
$ cp .env.example .env
```

Générer une clé pour l'application
```bash
$ php artisan key:generate
```

Créer un fichier de base de donnée sqlite nommé `database.sqlite` dans le dossier database

Puis migrer les tables
```bash
$ php artisan migrate
```

Ouvrir 2 terminaux et lancer les commandes suivantes dans cette ordre
```bash
$ php artisan serve
$ npm run dev
```
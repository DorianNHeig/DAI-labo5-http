# Partie 1 - HTTP Static Apache

Cette partie consiste à configurer et créer une image docker Apache/PHP contenant une simple page web.  
L'image de base utilisée est la suivante : [php:apache](https://hub.docker.com/_/php).

Le fichier `./site/index.php` est la page servie par le serveur http.

Un fichier Dockerfile décrit la création de l'image docker.

## Création de l'image docker
`docker build -t daiapache2 .` 

Créer une image avec comme nom d'image *daiapache2*

## Lancer un container
`docker run -dit -- name daihttpstatic -p 8080:80 daiapache2` 

Créer un container avec comme nom *daihttpstatic* en utilisant l'image *daiapache2*. 

Les paramètres servent a :
- d : détacher le container du CMD.
- i : pour envoyer des commandes même si l'on n'est pas attaché au terminal.
- t : pour avoir un terminal interactif (pouvoir écrire).
- p : spécifier les ports qui seront utuilisé par le docker.
- 
## Arrêter le docker
`docker stop daihttpstatic`

## Démarer le docker
`docker start daihttpstatic`

## Obtenir un fichier du docker
`docker run --rm daiapache2 cat /usr/local/apache2/conf/httpd.conf > httpd.conf`
Crée un docker et lance la commande *cat* puis note la valeur de sortie dans le fichier *httpd.conf*.

## Dockerfile
*FROM* est un mot clé servant a prendre une image docker existante.
*COPY* est un mot clé servant à copier un ficher / dossier du server au docker. 

## Page d'acceuil
Le fichier *index.php* est la page php qui sera affichée en accédant le port 8080.
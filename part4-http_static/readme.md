# Partie 4 - HTTP Static Apache

Cette partie est une extension de la [Partie 1](../part1-http_static/).  
On rajoute ici une requête en Javascript pour aller query l'api et afficher les résultats sur la page.



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
# Liste des commandes pour la partie 1

## Creation de l'image docker
`docker build -t daiapache2 .` 

Créer une image avec comme nom d'image *daiapache2*
## Crée le docker
`docker run -dit -- name daihttpstatic -p 8080:80 daiapache2` 

Créer un docker  avec comme nom *daihttpstatic* en utilisant l'image *daiapache2*. 

Les paramètres servent a :
- d : détacher le docker du CMD.
- i : pour envoyer des commandes même si l'on n'est pas attaché au terminal.
- t : pour avoir un terminal interactif (pouvoir écrire).
- p : spécifier les ports qui seront utuilisé par le docker.
## Arreter le docker
`docker stop daihttpstatic`
## Redemarer le docker
`docker start daihttpstatic`
## Optenir un fichier du docker
`docker run --rm daiapache2 cat /usr/local/apache2/conf/httpd.conf > httpd.conf`
Crée un docker et lance la commande *cat* puis note la valeur de sortie dans le fichier *httpd.conf*.
## Dockerfile
*FROM* est un mot clé servant a prendre une image docker existante.
*COPY* est un mot clé servant à copier un ficher / dossier du server au docker. 
## Page d'acceuil
Le fichier *index.html* est la page html qui sera affichée en accédant la port 8080.
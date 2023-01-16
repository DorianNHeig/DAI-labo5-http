# Partie 2 - HTTP Dynamic Express

Il s'agit d'une mini application web constuire avec [NodeJS](https://nodejs.org/en/) et le framework [ExpressJS](https://expressjs.com/) faisant office d'API pour ce projet.

Cette API contient une seule route, la racine '/'.   
Elle prends un paramètre numérique optionnel `amount`. Elle renvoit une liste de *amount* nom d'entreprise aléatoire. Chaque élément contient un nom d'entreprise (`name`) et une catch phrase d'entreprise (`catch_phrase`) aléatoire.

## Création de l'image docker
`docker build -t daiexpress .` 

Créer une image avec comme nom d'image *daiexpress*

## Lancer un container
`docker run -dit -- name daihttpdyn -p 3000:3000 daiexpress` 

Créer un container avec comme nom *daihttpdyn* en utilisant l'image *daiexpress*. 

Les paramètres servent à :
- d : détacher le container du CMD.
- i : pour envoyer des commandes même si l'on n'est pas attaché au terminal.
- t : pour avoir un terminal interactif (pouvoir écrire).
- p : spécifier les ports qui seront utuilisés par le container.
  
## Arrêter le docker
`docker stop daihttpdyn`

## Démarer le docker
`docker start daihttpdyn`

## Dockerfile
*FROM* est un mot clé servant à prendre une image docker existante.
*COPY* est un mot clé servant à copier un ficher / dossier local dans le container docker.
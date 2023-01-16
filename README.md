# DAI - Labo 5 HTTP - Rapport

## Introduction

L'objectif du labo est de créer une mini infrastructure docker comprenant: 
- Plusieurs instances d'un serveur web static apache
- Plusieurs instances d'un serveur web dynamic NodeJS
- Une instance [traefik](https://traefik.io/traefik/)

Cette infrastructure doit mettre en oeuvre plusieurs fonctionnalités du reverse proxy traefik: 
- Router vers la bonne application web (/ -> web static, /api -> web dynamic)
- Load Balancing entre les différentes instances de chaque application web

## Lancer le projet

Pour lancer ce projet il faut tout d'abord installer [docker](https://www.docker.com/products/personal/).  

Il faut d'abord créer les images docker pour les 2 applications web, [HTTP Static](./part1-http_static/) et [HTTP Dynamic](./part4-http_static/).  
Ensuite executer la commande `docker-compose up -d` à la racine pour lancer l'infrastructure. (Ou sans le `-d` pour garder le terminal, utile pour debug).

## Mise en place

Pour les parties [1](./part1-http_static/), [2](./part2-express/) et [4](./part4-http_static/), se référer aux readme présent dans leurs répertoires respectifs pour des informations complémentaires.

### Partie 1 - Static HTTP server avec apache httpd

Suivre les instructions dans le [readme](./part1-http_static/).

Nous avons créé un fichier Dockerfile pour la configuration de l'image docker de notre serveur web static.
Ce fichier contient trois commandes :
- `FROM` pour spécifier l'image de base qui est php:apache
- `COPY` pour copier le contenu du dossier `site` sur le serveur dans son fichier `/var/www/html`. Ce dossier contient les pages php affichable par le serveur.
- `EXPOSE` pour indiquer que le port 80 est exposé par le serveur.

Nous n'avons pas besoin de modifier le fichier de configuration httpd.conf car nous hebergeons des pages php n'ayant pas besoin de configuration particulière. Mais si nous avions besoin de modifier le fichier de configuration, nous aurions pu utiliser la commande `RUN` avec le docker en fonctionnement pour copier localement le fichier de configuration (`docker run --rm daiapache2 cat /usr/local/apache2/conf/httpd.conf > httpd.conf`). Puis ajouter une seconde commande `COPY` dans le Dockerfile pour copier le fichier de configuration dans le serveur lors du build. 

Pour vérifier le bon fonctionnement du serveur, il suffit de se connecter sur le port du serveur (8080) et de voir si la page php est affichée.

### Partie 2 - Dynamic HTTP server avec express.js

Suivre les instructions dans le [readme](./part2-express/).

### partie 3 - Docker compose pour build l'infrastucture

#### Reverse proxy avec traefik

Nous avons créé un fichier docker-compose.yml pour la configuration de l'infrastructure docker. Ce fichier contient 3 services:
- `reverse-proxy` pour le reverse proxy traefik. Nous utilisons l'image docker `traefik:v2.9`. Traefik est configuré pour écouter sur le port 80 et 8080. Le port 80 est utilisé pour le reverse proxy et le port 8080 pour l'interface web de traefik. 
- `http-static` pour le serveur static. Nous utilisons l'image précedemment créée `daiapache2`. Dans le fichier docker-compose, nous ne spécifions pas de port forwarding, car nous n'avons pas besoin d'exposer les ports des instances vu que nous passons par le reverse proxy. Nous avons aussi ajouté la ligne `labels: - "traefik.http.routers.http-static.rule=PathPrefix(/)"` pour indiquer à traefik que le serveur web static doit être accessible sur le chemin `/`.
- `http-dynamic` pour le serveur dynamic. Nous utilisons l'image précedemment créée `daiexpress`. Nous avons aussi ajouté la ligne `labels: - "traefik.http.routers.http-dynamic.rule=PathPrefix(/api)"` pour indiquer à traefik que le serveur web dynamic doit être accessible sur le chemin `/api`. L'instruction `traefik.http.middlewares.http-dyn-stripprefix.stripprefix.prefixes=/api` permet d'utiliser le [middleware](https://doc.traefik.io/traefik/middlewares/overview/) *stripprefix*. Ce middleware "strip" le prefix dans l'url, c'est à dire qu'il le retire pour que le serveur web au bout ne l'ait pas. Cela est nécessaire sinon l'application NodeJS reçoit une requête vers '/api', alors qu'elle écoute sur '/'.

Pour vérifier le bon fonctionnement de l'infrastructure, il suffit de se connecter sur le port 80 et de voir si la page du serveur static est affichée. Pour accéder à l'interface web de traefik, il suffit de se connecter sur le port 8080.

#### Gestion du cluster dynamiquement

Pour démarrer plusieurs instances d'un même container. Il faut ajouter un paramètre `scale`. Dans le docker-compose.yml, nous avons ajouté la ligne `http-static: scale: 3` pour démarrer 3 instances du serveur web static. Après un nouveau docker-compose up, nous avons pu voir que les 3 instances du serveur web static étaient lancées.

Nous avons aussi testé le fonctionnement du load balancing en envoyant plusieurs requêtes sur le serveur web static. Nous avons pu voir que les requêtes étaient réparties entre les 3 instances du serveur web static.

Nous avons aussi testé que le load balancer soit mis à jour dynamiquement en fonction des serveurs actifs.
Nous avons arrêter un serveur web static (`docker stop <container_id>`) et envoyé plusieurs requêtes. Nous avons pu voir que les requêtes étaient réparties entre les 2 instances du serveur web static restantes. Ensuite, nous avons redémarré le serveur web static (`docker start <container_id>`) et envoyé plusieurs requêtes. Nous avons pu voir que les requêtes étaient réparties entre les 3 instances du serveur web static. 

### Partie 4 - Requête Javascript vers l'API

Suivre les instructions dans le [readme](./part4-http_static/).

Cette partie est une extension de la partie *Part 1 - Static HTTP server avec apache httpd*. Nous avons utilisé la même configuration docker.

### Partie 5 - Load balancing: round-robin et sticky session

Nous avons utilisé la fonctionnalité de traefik pour le load balancing. De base, traefik utilise la méthode round-robin pour répartir les requêtes entre les instances du serveur web. Pour tester cette méthode, nous avons lancé plusieurs instances du serveur web dynamique et envoyé plusieurs requêtes. Nous avons pu voir que les requêtes étaient réparties entre les instances du serveur web dynamique.

Pour rendre les serveur static en sticky session, nous avons ajouter la commande `"traefik.http.services.web-static.loadbalancer.sticky.cookie.name=sticky_session_static_web"` dans le docker-compose.yml. Pour verifier le bon fonctionnement de cette fonctionnalité, nous nous sommes connectés sur le serveur web static et nous avons envoyé plusieurs requêtes. Nous avons pu voir que les requêtes étaient envoyées vers la même instance du serveur web static. En utilisant la navigation privée, nous avons pu voir que les requêtes étaient envoyées vers une autre instance du serveur web. C'est le cas car les cookies sont stockés dans le navigateur et sont envoyés avec les requêtes. Et la nivigation privée permet de ne pas stocker les cookies donc pouvoir changer de sticky session à chaque démarage.

Il est possible de voir les informations des requêtes dans la console car nous avons des informations qui s'y affichent après chaque requête envoyée. Nous avons la requête http envoyée et un message du serveur dynamique qui nous indique l'instance du serveur web dynamique qui a traité la requete.

### Partie 6 - Web app pour manager les containers dockers

Pour l'application de management docker, nous avons utilisé [portainer](https://www.portainer.io/). C'est un outil puissant permettant de gérer ses environnements dockers depuis une interface web. 

La documentation complète pour l'installation est disponible [ici](https://docs.portainer.io/start/install/server/docker).

Pour installer portainer, il faut d'abord créer un volume:  
`docker volume create portainer_data`  
Il sera utilisé pour stocker la base de donnée du logiciel.  

Ensuite, démarrer le container portainer:  
`docker run -d -p 8000:8000 -p 9443:9443 --name portainer --restart=always -v /var/run/docker.sock:/var/run/docker.sock -v portainer_data:/data portainer/portainer-ce:latest`

On peut vérifier si l'installation s'est bien déroulée en faisant `docker ps` et en verifiant que nous avons un nouveau container qui est apparu se nommant *portainer*.

Il faut ensuite se connecter sur le port 9443 pour accéder à l'interface de portainer. Lors de la première connexion, il nous sera demandé de créer le compte administrateur.
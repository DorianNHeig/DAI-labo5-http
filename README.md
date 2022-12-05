# DAI-labo5-http
# Labo HTTP Infra

## Objectives

The first objective of this lab is to get familiar with software tools that will allow us to build a **complete web infrastructure**. By that, we mean that we will build an environment that will allow us to serve **static and dynamic content** to web browsers. To do that, we will see how to configure a **Web server** and a **reverse proxy**. We will also see that **express.js** is a JavaScript framework that makes it very easy to write dynamic web apps.

The second objective is to implement a simple, yet complete, **dynamic web application**. We will create **HTML**, **CSS** and **JavaScript** assets that will be served to the browsers and presented to the users. The JavaScript code executed in the browser will issue asynchronous HTTP requests to our web infrastructure (**AJAX requests**) and fetch content generated dynamically.

The third objective is to practice our usage of **Docker**. All the components of the web infrastructure will be packaged in custom Docker images (we will create at least 3 different images). We will also use **Docker compose** to define a complete infrastructure with several components.

## General instructions

* This is a **BIG** lab and you will need a lot of time to complete it. 
* We have prepared webcasts for a big portion of the lab.
* Be aware that the webcasts have been recorded in 2016. There is no change in the list of tasks to be done, but of course **there are some differences in the details**. For instance, the Docker images that we use to implement the solution have changed a bit and you will need to do **some adjustments to the scripts**. This is part of the work and we ask you to document what the required adaptations in your report.
* The webcasts present one solution. Feeling adventurous and want to propose another one (for instance, by using Django or Deno instead of express.js)? Go ahead, we **LOVE** that. Make sure to document your choices in the report. If you are not sure if your choice is compatible with the list of acceptance criteria? Reach out to the teaching team. **Learning to discuss requirements with a "customer"** (even if this one pays you with a grade and not with money) is part of the process!
* For certain steps you will need to do research in the documentation by yourself (we are here to help, but we will not give you step-by-step instructions!) or you will need to be creative (do not expect complete guidelines).
* The lab can be done in **groups of 2 students**. You will learn very important skills and tools, which you will need to next year's courses. You cannot afford to skip this content if you want to survive next year. Essentially, this means that it's a pretty bad idea to only have one person in the group doing the job...
* Read carefully all the **acceptance criteria**.
* We will request demos as needed. When you do your **demo**, be prepared to that you can go through the procedure quickly (there are a lot of solutions to evaluate!)
* **You have to write a report. Please do that directly in the repo, in one or more markdown files. Start in the README.md file at the root of your directory.**
* The report must contain the procedure that you have followed to prove that your configuration is correct (what you would do if you were doing a demo).
* Check out the **due dates** on the main repo for the course.
* Please create one directory or one branch per step so it will be easier for us to correct your work.


## Step 1: Static HTTP server with apache httpd

### Webcasts

* [Labo HTTP (1): Serveur apache httpd "dockerisé" servant du contenu statique](https://www.youtube.com/watch?v=XFO4OmcfI3U)

### Note

* You will probably have trouble to use PHP 8 with Apache, we recommend using PHP 7 instead.

### Acceptance criteria

* You have a GitHub repo with everything needed to build the Docker image.
* You can do a demo, where you build the image, run a container and access content from a browser.
* You have used a nice looking web template, different from the one shown in the webcast.
* You are able to explain what you do in the Dockerfile.
* You are able to show where the apache config files are located (in a running container).
* You have **documented** your configuration in your report.

## Step 2: Dynamic HTTP server with express.js

### Webcasts

* [Labo HTTP (2a): Application node "dockerisée"](https://www.youtube.com/watch?v=fSIrZ0Mmpis)
* [Labo HTTP (2b): Application express "dockerisée"](https://www.youtube.com/watch?v=o4qHbf_vMu0)

### Acceptance criteria

* You have a GitHub repo with everything needed to build the Docker image.
* You can do a demo, where you build the image, run a container and access content from a browser.
* You generate dynamic, random content and return a JSON payload to the client.
* You cannot return the same content as the webcast (you cannot return a list of people).
* You don't have to use express.js; if you want, you can use another JavaScript web framework or event another language.
* You have **documented** your configuration in your report.

## Step 3: Docker compose to build the infrastructure

There are no Webcasts (yet) for this part.

The goal of this step is to use Docker compose to deploy a first version of the infrastructure with a single static and a single dynamic Web server.

* You will need to install Docker compose on your machine. You'll find the instructions [on this link](https://docs.docker.com/compose/).
* You will need to write a `docker-compose.yml` file. To do this, read the [introduction](https://docs.docker.com/compose/features-uses/), then have a look at this [tutorial](https://docs.docker.com/compose/gettingstarted/). They should provide the information you need to write your docker-compose file.

### Acceptance criteria

* You have added a `docker-compose.yml` file to your GitHub repo.
* You can start and stop an infrastructure with a single dynamic and a single static Web server using docker compose.
* You can access both Web servers on your local machine on the respective ports.
* You have **documented** your configuration in your report.

## Step 3: Reverse proxy with Traefik

The goal of this step is to run a reverse proxy in front of the dynamic and static Web servers such that the reverse proxy receives all connections and relays them to the respective Web server. 

*(Several old Webcasts are available ([5a](https://www.youtube.com/watch?v=iGl3Y27AewU) [5b](https://www.youtube.com/watch?v=lVWLdB3y-4I) [5c](https://www.youtube.com/watch?v=MQj-FzD-0mE) [5d](https://www.youtube.com/watch?v=B_JpYtxoO_E) [5e](https://www.youtube.com/watch?v=dz6GLoGou9k)) which show a methods to do this with Apache.
However, **we do not recommend anymore to follow this method** but instead to use a more modern approach, based on [Traefik](https://traefik.io/traefik/). Traefik is a reverse proxy which interfaces directly with Docker to obtain the list of active backend servers. This means that it can dynamically adjust to the number of running server.)*

The steps to follow for this section are thus:

* read the [Traefik Quick Start](https://doc.traefik.io/traefik/getting-started/quick-start/) documentation and add a new service "reverse_proxy" to your `docker-compose.yml` file using the Traefik docker image
* configure the Traefik service and the communication between the Web servers and Traefik:
  * first read the documentation of Traefik, including those ones:
    * the [Traefik Router](https://doc.traefik.io/traefik/routing/routers/) documentation, in particular the "Rule" section,
    * the [Traefik & Docker](https://doc.traefik.io/traefik/routing/providers/docker/) documentation, in particular for the dynamic Web server. 
  * then implement the reverse proxy:
    * start by relaying the requests coming to "localhost/" to the **static HTTP server** (that's the easy part),
    * then relay the requests coming to "localhost/api/" to the **dynamic HTTP server** (here you will need to search a little bit in the documentation how to use the "/api" path prefix),

### Acceptance criteria

* You have a GitHub repo with everything needed to build the various images.
* You can do a demo where you start from an "empty" Docker environment (no container running) and using docker compose you can start your infrastructure with 3 containers: static server, dynamic server and reverse proxy
* In the demo you can access each Web server from the browser in the demo. You can prove that the routing is done correctly through the reverse proxy.
* You are able to explain how you have implemented the solution and walk us through the configuration and the code.
* You are able to explain why a reverse proxy is useful to improve the security of the infrastructure.
* You have **documented** your configuration in your report.


## Step 3a: Dynamic cluster management

The goal of this section is to allow Traefik to dynamically detect several instances of the (dynamic/static) Web servers. You may have already done this in the previous step 3.

Modify your `docker-compose.yml` file such that several instances of each Web server are started. Check that the reverse proxy distributes the connections between the different instances.

### Acceptance criteria

* The modified `docker-compose.yml` file is in your GitHub repo.
* You can use docker compose to start the infrastructure with several instances of each Web server.
* You can do a demo to show that Traefik performs load balancing among the instances.
* If you add or remove instances, you can show that the load balancer is dynamically updated to use the available instances.
* You have **documented** your configuration in your report.

## Step 4: AJAX requests with JQuery

The goal of the step is to use AJAX requests to dynamically update a Web page every few seconds with data coming from the dynamic Web server.

Note: in the webcast we introduce you to JQuery, but you can also use the more modern [JavaScript Fetch API](https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API/Using_Fetch) to easily make AJAX requests.

### Webcasts

* [Labo HTTP (4): AJAX avec JQuery](https://www.youtube.com/watch?v=fgpNEbgdm5k)

### Acceptance criteria

* You have a GitHub repo with everything needed to build the various images.
* You can do a complete, end-to-end demonstration: the web page is dynamically updated every few seconds (with the data coming from the dynamic backend).
* You are able to prove that AJAX requests are sent by the browser and you can show the content of the responses.
* You have **documented** your configuration in your report.

## Step 5: Load balancing: round-robin and sticky sessions

By default, Traefik uses Round Robin to distribute the load among all available instances. However, if a service is stateful, it would be better to send requests of the same session always to the same instance. This is called sticky sessions.

The goal of this step is to change the configuration such that:

* Traefik uses sticky session for the static Web server instances
* Traefik continues to use round robin for the dynamic servers (no change required)

### Acceptance criteria

* You do a setup to demonstrate the notion of sticky session.
* You prove that your load balancer can distribute HTTP requests in a round-robin fashion to the dynamic server nodes (because there is no state).
* You prove that your load balancer can handle sticky sessions when forwarding HTTP requests to the static server nodes.
* You have **documented** your configuration and your validation procedure in your report.

## Step 6: Management UI

The goal of this step is to deploy or develop a Web app that can be used to monitor and update your Web infrastructure dynamically. You should be able to list running containers, start/stop them and add/remove instances.

There are two options for this step:

* you use an existing solution (search on Google)
* you develop your own Web app (e.g. with express.js). In this case, you can use the Dockerode npm module (or another Docker client library, in any of the supported languages) to access the docker API.

### Acceptance criteria

* You can do a demo to show the Management UI and manage the containers of your infrastructure.
* You have **documented** your configuration in your report.
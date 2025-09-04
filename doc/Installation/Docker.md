# Docker

An official twentyfouronline docker image based on Alpine Linux and Nginx is available
on [DockerHub](https://hub.docker.com/r/twentyfouronline/twentyfouronline/).

# Documentation

Full install and configuration documentation can be found on the [GitHub repository](https://github.com/twentyfouronline/docker).

# Quick install
1. Install docker: https://docs.docker.com/engine/install/
2. Download and unzip composer files:
```
mkdir twentyfouronline
cd twentyfouronline
wget https://github.com/twentyfouronline/docker/archive/refs/heads/master.zip
unzip master.zip
cd docker-master/examples/compose
```
3. Set a new mysql password in .env and inspect compose.yml
4. Bring up the docker containers
```
sudo docker compose -f compose.yml up -d
```
5. Open webui to finish configuration. `http://localhost:8000` (use the correct ip or name instead of localhost)





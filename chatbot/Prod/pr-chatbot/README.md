# VM requierement : ( dev : Adrien Adrien)

## Docker
- https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-debian-10

## Docker-composer
- https://www.digitalocean.com/community/tutorials/how-to-install-docker-compose-on-debian-10

# Rasa X Demo Bot

Clean_Docker :
docker stop $(docker ps -a -q)
docker rm $(docker ps -a -q)
docker rmi $(docker images -qa)


Requirement :

## Installer Docker
Docker :
* Mac ou Linux : https://docs.docker.com/docker-for-mac/install/ 

Linux ou Mac:

```sh
DownLoad on https://gitlab.utc.fr/agneladr/pr-chatbot.git
	        OR
git clone https://gitlab.utc.fr/agneladr/pr-chatbot.git


(In project dir) : git checkout feature/docker 

In project dir:
sudo docker-compose build
sudo docker-compose up -d
# sudo docker-compose logs rasa-x | grep password

Stop server : sudo docker-compose down

Refresh with new config files : 
    sudo docker-compose build
    sudo docker-compose up -d

```

* chown -R chatbot:chatbot pr-chatbot

* http://localhost:5002 => enjoy Rasa X
* Password : robert
* Launch Train : left menu Train button 
* Wait
* Active Model : Clic on the model in the models Menu and Clic on [...] => Make Active

## Before PUSH :
* Delete dir terms
* Delete All  zip Model in models Dir 
* Delete all files .db and .wal and shm
* git add *
* git commit -m "Commentary"
* git push

## Ports
- `5005` - Rasa port (client)
- `5002` - Rasa X

# Update Server status
```sh
Stop Servers : 
sudo docker-compose down

Start all Servers:
sudo docker-compose up -d

Look rasa log: 
sudo docker-compose logs rasa-x | grep password
```

# Training

Local training using your local python environment (or conda/venv)

```sh
sudo docker-compose run rasa-x rasa train
```

# Testing
```sh
sudo docker-compose run rasa-x rasa test nlu -u test/test_data.md --model models/$(ls models)
sudo docker-compose run rasa-x rasa test core --stories test/test_stories.md
```

# Rasa Interactive Shell

```sh
sudo docker run -v $(pwd):/app rasa/rasa:${RASA_VERSION} run actions --actions actions.actions
sudo docker-compose up app -d
sudo docker run -it -v $(pwd):/app rasa/rasa:${RASA_VERSION} shell --debug
```




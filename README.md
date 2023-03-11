# UWDC2023

## Note to judges
To go to the frontend, explicitly go to /index.html
due to the server configuration that i have no access to, this doesnt work, otherwise, but it does locally :/

## Getting started

To make it easy for you to get started with the build pipeline, here's a list of recommended steps.

**IMPORTANT**
_The files, which are already in the repository, must not be altered .. unless you know what you are doing!_

## Clone the repository to your development machine
This is your main repository which will be used for marking. From this image we create a docker container, which is served under personal URL (see email).
```
git clone https://gitlab.skill17.com/competitor-xx/project.git
```
Replace XX with your competitor number .. or use the link from the project overview

## Our laravel environment
This is just an optional docker image. It will be the basis for the final production docker image. The idea is to have all libraries set up in one image, so that we do not need to download additional packages during the competition ... where there is no internet ;-)
If you want, you can use it for your local development or you just stick to your own development environment.
```
docker login gitlab.skill17.com:5000
```
use your credentials for that login
```
docker pull gitlab.skill17.com:5000/competitor-base/laravel-environment
```

## Creating a local dev container (optional)
Now that you have pulled the image and cloned your repo, you can start your dev container OR you just stick to your own dev environment (i am repeating myself)
```
docker run -d --name dev -v ${PWD}:/app -w /app -p 8000:8000 --link mysql:mysql gitlab.skill17.com:5000/competitor-base/laravel-environment
docker exec -it dev bash
```

## Work from an existing repo (optional)
```
cd existing_repo
git remote add origin https://gitlab.skill17.com/competitor-xx/project.git
git branch -M main
git push -uf origin main
```

## Commit and push your work to the main branch
```
git commit -a -m "some message"
git push
```

### The build pipeline
Once you have pushed the main branch the build pipeline will start and your personal docker image will be created. This image is then transfered to a cluster and started.
You can see the status of your build under menu entry: CI/CD / Pipelines

## Access your production version
Once everything is green, you can access your work following the link from the email.

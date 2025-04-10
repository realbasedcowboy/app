# BasedCowboy

## Pre installation

Follow the installation instructions on https://ddev.com. Once installed go the project
root and run

```
npm install
ddev start
```

To run the frontend while developing

```
npm run dev
```

To start your reverb server locally

```
ddev artisan reverb:start
```

## Deployment

Automatic deployments are done on cloud.laravel.com. Push to the master and it will be automatically deployed on our
staging environment.

## Shortcuts

```
GIT_SSH_COMMAND='ssh -i ~/.ssh/id_cowboy' git push
```

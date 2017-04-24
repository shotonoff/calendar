# Calendar events Application

This application demonstrate my skills. I tried to cover full stack technologies 
* PHP as a backend of app
* Javascript as a frontend of app

## Install the Application

1. Clone the project [repository](https://git.itim.vn/shotonoff/calendar)
2. Copy `.env.example` to `.env`
3. [Install docker](https://docs.docker.com/engine/installation/)
4. [Install docker compose](https://docs.docker.com/compose/install/)

5. If you are on OSX:

   1. Add network interface for debug
   
   ```
   sudo ifconfig lo0 alias 10.254.254.254
   ```

   2. Update `.env`
   
   ```bash
   XDEBUG_REMOTE_HOST="10.254.254.254"
   ```

6. Add hostname to `/etc/hosts`:

   ```bash
   echo "\n127.0.0.1 aulinks.local" | sudo tee --append /etc/hosts
   ```
   
7. Create docker network:
    
    ```bash
    docker network create --driver bridge aulinks
    ```

8. Install and build project docker images:

    ```bash
    docker pull digitallyseamless/nodejs-bower-grunt:latest
    docker-compose pull mysql nginx
    docker-compose build php
    docker-compose build nginx
    ```

9. Start project:
    
    Copy .env.example to .env
    
    ```bash
        docker-compose up -d
    ```

10. Install project dependencies:

    ```bash
    bin/run npm install
    bin/run bower install
    bin/run bower bowercopy
    composer install #is expected that composer already have been installed on your system
    ```

11. Prepare data: 
    
    ```bash
        bin/run migration migrations:migrate --no-interaction
        bin/run console user:create admin admin@aulinks.cz --super
    ```
    
    


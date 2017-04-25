# Calendar events Application

This application demonstrate my skills. I tried to cover full stack technologies 
* PHP as a backend of app
* Javascript as a frontend of app

## Install the Application

1. Clone the project [repository](https://github.com/shotonoff/calendar)
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
   sudo sh -c 'echo "\n127.0.0.1 aulinks.local" | cat >> /etc/hosts'
   ```
   
   if you you are OSX
    
    ```bash
    sudo sh -c 'echo "\n192.168.99.100 aulinks.local" | cat >> /etc/hosts'
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
    bin/run grunt bowercopy
    bin/run composer install
    ```

11. Prepare data: 
    
    ```bash
        bin/run migration migrations:migrate --no-interaction
        bin/run console user:create admin admin@aulinks.cz --super
    ```
    
12. Open in your browser `http://aulinks.local/`

13. To send email, you have to run a command manually  

    ```bash
        bin/run console mailer:send
    ```
    
14. There are two ways, how to register an user  
    * Open registration page manually `http://aulinks.local/#/aulinks.local/#/registration?token=PUT_HERE_INVITE_TOKEN`
    * Run a command to send email and click by link which lead to registration page
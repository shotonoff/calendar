# Calendar events Application

This application demonstrate my skills. I tried to cover full stack technologies 
* PHP as a backend of app
* Javascript as a frontend of app

### Install the Application

1. Clone the project [repository](https://github.com/shotonoff/calendar)
2. [Install docker](https://docs.docker.com/engine/installation/)
3. [Install docker compose](https://docs.docker.com/compose/install/)

4. Add hostname to `/etc/hosts`:

   ```bash
   sudo sh -c 'echo "\n127.0.0.1 aulinks.local" | cat >> /etc/hosts'
   ```
   
   if you you are OSX
    
    ```bash
    sudo sh -c 'echo "\n192.168.99.100 aulinks.local" | cat >> /etc/hosts'
    ```
   
5. Run build script
    
    ```bash
    sudo ./build.sh
    ```
    
6. Open in your browser `http://aulinks.local/`

7. To send email, you have to run a command manually  

    ```bash
        sudo ./bin/run console mailer:send
    ```

7. To change an event status, to run a command  

    ```bash
        sudo ./bin/run console event:status:observer
    ```

### Some notes
There are two ways, how to register an user  
1. Click by `Register` link in an invite block on invite list pageThe link leads to registration page with particular token 
2. Open registration page manually `http://aulinks.local/#/aulinks.local/#/registration?token=PUT_HERE_INVITE_TOKEN`
3. Run a command to send email and click by link which lead to registration page
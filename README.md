CROWD FUNDING
========
This is a project for CS2102 2016 SEM1
--------
## Developer guild
### 1. Install Bitnami server

### 2. Import data under folder `small_data` (mind the order of import) (go to `http://127.0.0.1:8080/phppgadmin/`)

### 3. Set `PHP.ini`

#### 3.1 Fuck you MAPP
- The Bitnami comes with php version that makes use of cache to improve your application performance, which is really really really BAD for development. change `php/etc/php.ini` => `opcache.enable=1` to `opcache.enable=0`, also change `error_reporting` to `error_reporting=E_ALL & ~E_NOTICE` (Use Ctrl + F to find them, remember to restart the server after the modification)
- Fuck you php, open the error display. change`php/etc/php.ini` => `display_errors = Off` to `display_errors = On`

### 4. Set database connection
- Copy the `app.env.example` and rename it to `app.env`

The content is look like this:

``` bash
APP_URL=localhost
APP_TIMEZONE=Asia/Singapore

DB_CONNECTION=postgre
DB_HOST=localhost
DB_DATABASE=The_database_name_you_create
DB_USERNAME=postgres
DB_PASSWORD=Your_password_for_pgAdmin
```

Change the value (The git repo will ignore the `app.env` so you can put your password there)

### 4. Write your code

### 4.1 PHP coding style
Please wrap your php code within `<?php //content here ?>` **NOT** `<? //content ?>`. (The server will compline if you use `<? //content ?>`, then you use half a hour to debug LOL)

 
#### the following is to unify the coding style
* html
    * the assignment of HTML elements should **NOT** use space to seperate "="   
    ```html
    <div class="container"></div>
    ```

    * the class name in html should also follow JAVA convention (camelCase), while attribute "id" and "name" should use lower-case letters seperated with underscore "_"
    ```html
    <div class= "FileViewer">
        <div class="Page">     
            <img id="first_page_picture" src="">
            <iframe name="first_page_iframe"></iframe>
        </div>
    </div>
    ```

    * all the html file should be named with words seperated using "_"      
    ```
    sign_up_page.html
    ```

* javascript/jquery
    * the style for javascript code should follow **CS1101S** standard **EXCEPT** the naming convention    
    ```javascript
    function mouseInChangeColor(obj) {
        if (obj.innerHTML == "submit")
            obj.className = "btn btn-info";
        else if (obj.innerHTML = "clear")
            obj.className = "btn btn-warning";
    }
    ```
    
    * the naming for author-created functions and classes should follow JAVA convention (camelCase)    
    ```javascript
    var nextStep = false;
    ```

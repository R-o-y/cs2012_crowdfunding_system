CROWDFUNNDNG
========
This is a project for CS2102 in 2016/17 SEM1
--------
 
#### the following is to unify the coding style
* html
    * the assignment of HTML elements should **NOT** use space to seperate "="   
    ```html
    <div class="container"></div>
    ```

    * the class name in html should also follow JAVA convention (camelCase), while attribute "id" and "name" should use lower-case letters seperated with underscore "_"
    ```html
    <div class="FileViewer">
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

<?php

session_start();
require '../app/Autoloader.php';
Autoloader::register();

App::getHead("Index");
App::getMenu();
?>
<div class="jumbotron">
    <div class="container">
        <h1>Hello world!</h1>
        <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer hendrerit massa eu facilisis faucibus. Nunc sed molestie leo. In hac habitasse platea dictumst. Proin auctor velit eu libero suscipit, vel consectetur augue consectetur. Quisque id erat ut dui porttitor mattis. Maecenas in nunc eget ante lobortis facilisis. Vivamus eget nibh fringilla, posuere ante sed, egestas ipsum. Aliquam volutpat imperdiet consectetur. Nullam lacus orci, posuere quis mollis sit amet, fermentum sed libero. Cras justo leo, pretium non varius non, lacinia vel ex. Donec in lacus sem. Duis at purus consectetur, vehicula tortor ac, cursus mauris.</p>
        <a class="btn btn-primary" href="forum.php">Voir le forum</a>
    </div>
</div>
<?php App::getFooter(); ?>

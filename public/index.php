<?php

// Include router class
include('../routes/Route.php');

##.......WEB Routes.........
Route::add('/',function(){
    require '../views/index.php';
});

Route::add('/action',function(){
    require '../controllers/CreateShortURLController.php';
    new CreateShortURLController($_POST);
},'post');


Route::add('/redirect',function(){
    require '../controllers/RedirectURLController.php';
    new RedirectURLController($_GET['code']);
},'get');


Route::run('/');


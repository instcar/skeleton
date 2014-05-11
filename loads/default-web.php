<?php
/* default-web.php --- 
 * 
 * Filename: default-web.php
 * Description: 
 * Author: Gu Weigang
 * Maintainer: 
 * Created: Tue Jan 29 14:56:13 2013 (+0800)
 * Version: master
 * Last-Updated: Sun Mar 23 21:40:13 2014 (+0800)
 *           By: Gu Weigang
 *     Update #: 83
 * 
 */

/* Change Log:
 * 
 * 
 */

/* This program is part of "Baidu Darwin PHP Software"; you can redistribute it and/or
 * modify it under the terms of the Baidu General Private License as
 * published by Baidu Campus.
 * 
 * You should have received a copy of the Baidu General Private License
 * along with this program; see the file COPYING. If not, write to
 * the Baidu Campus NO.10 Shangdi 10th Street Haidian District, Beijing The Peaple's
 * Republic of China, 100085.
 */

/* Code: */

require $system."/loads/default.php";

$di->set('url', function() use ($config){
    $url = new \Phalcon\Mvc\Url();
    $url->setBaseUri($config->application->baseUri);
    return $url;
});
            
$di->set('view', function() use ($system, $config) {
    $view = new \Phalcon\Mvc\View();
    $view->setViewsDir($system.$config->application->viewsDir);
    return $view;
});

$di->setShared('cookie', function(){
    $cookie = new \Phalcon\Http\Response\Cookies();
    $cookie->useEncryption(true);
    return $cookie;
});

$di->setShared('crypt', function() {
    $crypt = new Phalcon\Crypt();
    $crypt->setKey('#1dj8$=dp?.ak//j1V$'); //Use your own key!
    return $crypt;
});

$di->setShared('session', function(){
    $session = new \Phalcon\Session\Adapter\Files();
    $session->start();
    return $session;
});

$di->set('flash', function(){
    $flash = new \Phalcon\Flash\Direct(array(
        'error'   => 'alert alert-error',
        'success' => 'alert alert-success',
        'notice'  => 'alert alert-info',
    ));
    return $flash;
});

// register rules for router
$di->set('router', function() {
    $router = new \Phalcon\Mvc\Router();
    $router->setDefaultModule("server");
    $router->add("/:module/:controller/:action/:params",
                 array("module"     => 1,
                       "controller" => 2,
                       "action"     => 3,
                       "params"     => 4
                 ));
    
    $router->add('/admin/',
                 array(
                     "module" => "admin",
                     "controller" => "index",
                     "action"   => "index",
                 ));

    $router->add('/admin',
                 array(
                     "module" => "admin",
                     "controller" => "index",
                     "action"   => "index",
                 ));    
    
    return $router;
});

// register multi-modules
$application->registerModules($config->web_module->toArray());


/* default-web.php ends here */
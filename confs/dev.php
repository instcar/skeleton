<?php
return array(
    "application" => array(
        
        "modelsDir"  => "/apps/common/models/",
        "viewsDir"   => "/apps/common/views/",
        "pluginsDir" => "/apps/plugins/",
        "libraryDir" => "/apps/library/",

        "baseUri"    => "http://tycoon.baidu.com:8088/",
        "baseUrl"    => "http://tycoon.baidu.com:8088/",

        "tmpDir"     => "/home/work/tmp/",

        "logger"     => array(
            "dir"    => "/home/work/var/log/instcar/",
            "format" => "[%file%:%line%][%ip%] %message%",
        ),
        
        "debug"      => false,
        "close"      => false,
    ),
    
    "cli_module" => array(

        "server" => array(
            "className" => 'Instcar\Server\\' . PHALCON_RUN_ENV,
            "path"      =>  PHALCON_DIR."/server/" . PHALCON_RUN_ENV.".php",
        ),
    ),
    
    "web_module" => array(

        "server" => array(
            "className" => 'Instcar\Serer\\'.PHALCON_RUN_ENV,
            "path"      =>  PHALCON_DIR."/server/".PHALCON_RUN_ENV.".php",
        ),        
    ),

    "database" => array(
        
        // db starts here
        'db' => array(
            
            'nodes'   => 2,
            
            'charset' => 'utf8',
            
            'host'    => array(
                "10.48.31.126",
                "10.48.31.126",
            ),
            
            'port' => array(
                "8006",
                "8006",
            ),
            
            'username' => array(
                'root',
                'root',
            ),
            
            "password" => array(
                'root',
                'root',
            ),
            
            "dbname" => array(
                'bigbang',
                'bigbang',
            ),
        ),
        // db ends here

        
    ),
    
    'library' => array(
        
    ),
);


/* dev.php ends here */
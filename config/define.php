<?php
#*******************************
# CONFIGURAÇÕES
#*******************************
include 'define_db.php';

#*******************************
# PATHS / URLS
#*******************************
define("PATHCLASSES",PATHRAIZ."classes/");
define("PATHCONFIG",PATHRAIZ."config/");
define("PATHCONTROLE",PATHRAIZ."controle/");
define("PATHPUBLIC",PATHRAIZ."public/");
    define("PATHBIBLIOTECA",PATHPUBLIC."biblioteca/");
    define("PATHVIEW",PATHPUBLIC."views/");
        define("PATHPORTAL",PATHVIEW."portal/");
    define("PATHCSS",PATHPUBLIC."css/");
    define("PATHJS",PATHPUBLIC."js/");
    define("PATHIMGS",PATHPUBLIC."imagens/");
    define("PATHLOG",PATHPUBLIC."log/");
    define("PATHUPLOADS",PATHPUBLIC."uploads/");
        define("PATHUSUARIOS",PATHUPLOADS."usuarios/");
        define("PATHREPO",PATHUPLOADS."repositorio/");
            

define("URLCLASSES",URLRAIZ."classes/");
define("URLCONFIG",URLRAIZ."config/");
define("URLCONTROLE",URLRAIZ."controle/");
define("URLPUBLIC",URLRAIZ."public/");
    define("URLBIBLIOTECA",URLPUBLIC."biblioteca/");
    define("URLVIEW",URLPUBLIC."views/");
        define("URLPORTAL",URLVIEW."portal/");
    define("URLCSS",URLPUBLIC."css/");
    define("URLJS",URLPUBLIC."js/");
    define("URLIMGS",URLPUBLIC."imagens/");
    define("URLLOG",URLPUBLIC."log/");
    define("URLUPLOADS",URLPUBLIC."uploads/");
        define("URLUSUARIOS",URLUPLOADS."usuarios/");
        define("URLREPO",URLUPLOADS."repositorio/");

#*******************************
# DIVERSOS
#*******************************
define("HORA",date('H:i:s'));
define("DATABR",date('d/m/Y'));
define("DATAMYSQL",date('Y-m-d'));
define("DATAHORABR",DATABR.' '.HORA);
define("DATAHORAMYSQL",DATAMYSQL.' '.HORA);

?>
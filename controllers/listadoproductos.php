<?php

//  ../controllers/listadoproductos.php

require '../fw/fw.php';
require '../views/FormListadoProductos.php';
require '../models/Productos.php';
require '../fw/BanderaSesion.php';
require '../models/Clientes.php';

$p = new Productos();

$v = new FormListadoProductos();
$v->productos = $p->getTodos();


$v->render();



?>
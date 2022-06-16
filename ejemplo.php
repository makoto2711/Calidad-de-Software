<?php

// ENTRAR A assets Archivo JS , linea de la 28 a la 47


 $input = json_decode(file_get_contents('php://input'), true);

echo json_encode($input["id"]);


<?php 
require_once './vendor/autoload.php';
use GO\Scheduler;

// Cria um novo agendador
$scheduler = new Scheduler();

// Configura os jobs agendados
$scheduler->php('script.php')->output([
    'my_file1.log'
]);

$scheduler->call(function () {
    echo "Hello";
    return " world!";
})->output('my_file.log');

// Deixe o planejador executar os jobs vencidos. 
$scheduler->run();
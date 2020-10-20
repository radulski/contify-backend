<?php

namespace App\DAO\MySQL\ContifyDev;

abstract class Conexao
{
    /**
     *  @var \PDO
     */
    protected $pdo;

    public function __construct()
    {
        date_default_timezone_set('America/Sao_Paulo');
        
        $host = getenv('CONTIFY_DEV_MYSQL_HOST');
        $port = getenv('CONTIFY_DEV_MYSQL_PORT');
        $user = getenv('CONTIFY_DEV_MYSQL_USER');
        $pass = getenv('CONTIFY_DEV_MYSQL_PASSWORD');
        $dbname = getenv('CONTIFY_DEV_MYSQL_DBNAME');
        
        // Alterar SSL Azure
        /*
        $options = array(
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            \PDO::MYSQL_ATTR_SSL_CA => '/Users/rafaelradulskidasilva/Documents/BaltimoreCyberTrustRoot.crt.pem',
            \PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
        );
        */

        $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8;port={$port}";
        $this->pdo = new \PDO($dsn, $user, $pass /* $options */);
        $this->pdo->setAttribute(
            \PDO::ATTR_ERRMODE,
            \PDO::ERRMODE_EXCEPTION
        );
    }
}
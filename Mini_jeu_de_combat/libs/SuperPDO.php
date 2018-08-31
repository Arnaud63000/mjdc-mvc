<?php

class SuperPDO
{
    public $pdo;

    /*
     * Le constructeur de la classe.
     * On y injecte la classe PDO, puis
     * on active les exceptions SQL par défaut.
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo  = $pdo;
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function query($sql, $parameters = null)
    {
        if($parameters) {
            $prepared =  $this->pdo->prepare($sql);
            $prepared->execute($parameters);;

            return $prepared;
        }

        return $this->pdo->query($sql);
    }
}
<?php

class PersonnagesManager
{
    private $superPdo;

    public function __construct($superPdo)
    {
        $this->setBdd($superPdo);
    }

    //On ajoute un nouveau personnage
    public function add(Personnage $perso)
    {
        $newPerso = $this->superPdo->query(
            'INSERT INTO personnages (nom) VALUES (?)',
            [$perso->nom]
        );

        $perso->hydrate([
            'id' => $this->superPdo->pdo->lastInsertId(),
            'degats' => 0,
            'experience' => 0,
            'niveau' => 1,
            'nbCoups' => 0,
            'dateDernierCoup' => '0000-00-00',
        ]);
    }

    public function count()
    {
        return $this->superPdo->query('SELECT COUNT(*) FROM personnages')->fetchColumn();
    }

    public function delete(Personnage $perso)
    {
        $this->superPdo->query('DELETE FROM personnages WHERE id = ' . $perso->id);
    }

    public function exists($info)
    {
        if (is_int($info)) {
            $req = $this->superPdo->query(
                'SELECT count(*) FROM personnages WHERE id = ?',
                [$info]
            );
            return $req->fetchColumn();
        }

        $req = $this->superPdo->query(
            'SELECT COUNT(*) FROM personnages WHERE nom = ?',
            [$info]
        );

        return (bool)$req->fetchColumn();
    }

    public function get($info)
    {
        if (is_int($info)) {
            $req = $this->superPdo->query(
                'SELECT id, nom, degats, experience, niveau, nbCoups, dateDernierCoup FROM personnages WHERE id = ?',
                [$info]
            );
            $donnees = $req->fetch(PDO::FETCH_ASSOC);

            return new Personnage($donnees);
        }

        $req = $this->superPdo->query(
            'SELECT id, nom, degats, experience, niveau, nbCoups, dateDernierCoup FROM personnages WHERE nom = ?',
            [$info]
        );

        $donnees = $req->fetch(PDO::FETCH_ASSOC);

        return new Personnage($donnees);
    }

    public function getList($nom)
    {
        $persos = [];

        $req = $this->superPdo->query(
            'SELECT id, nom, degats, experience, niveau, nbCoups, dateDernierCoup FROM personnages WHERE nom <> ? ORDER BY nom',
            [$nom]
        );

        while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
            $persos[] = new Personnage($donnees);
        }
        return $persos;
    }

    public function update(Personnage $perso)
    {
        $req = $this->superPdo->query(
            'UPDATE personnages SET degats = ?, experience = ?, niveau = ?, nbCoups = ?, dateDernierCoup = ? WHERE id = ?',
            [
                $perso->degats,
                $perso->experience,
                $perso->niveau,
                $perso->nbCoups,
                $perso->dateDernierCoup->format('Y-m-d'),
                $perso->id
            ]
        );
    }

    public function setBdd(SuperPDO $superPdo)
    {
        $this->superPdo = $superPdo;
    }
}
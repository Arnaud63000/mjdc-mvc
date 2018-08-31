

<fieldset>
    <legend><b>Mes informations</b></legend>
    <p>
    <center>
        <b></i>Nom</b></i> : <?= htmlspecialchars($perso->nom) ?><br/>
        <b><i>Dégâts</b></i> : <?= $perso->degats ?>
        <b><i>Expérience</b></i> : <?= $perso->experience ?>
        <b><i>Niveau</b></i> : <?= $perso->niveau ?>
        <b><i>Nombre des coups</b></i> : <?= $perso->nbCoups ?>
        <b><i>Date de dernier coup</b></i> : <?= $perso->dateDernierCoup->format('d/m/Y') ?>
    </center>
    </p>
</fieldset>
<fieldset>
    <legend><b>Qui frapper?</b></legend>
    <p>
        <?php

        foreach ($ennemis as $unPerso) {
            echo '<a href="?frapper=' . $unPerso->id . '">' .
                htmlspecialchars($unPerso->nom) .
                '</a>
                    (dégâts : ' . $unPerso->degats . ', expérience : ' .
                $unPerso->experience . ', niveau : ' . $unPerso->niveau .
                ', nombre des coups : ' . $unPerso->nbCoups . ', date de dernier coup : ' .
                $unPerso->dateDernierCoup->format('d/m/Y') . ')<br />';
        }

        ?>
    </p>
</fieldset>

<br><br>
<p><a href="?deconnexion=1">Déconnexion</a></p>
<!DOCTYPE html>
<html>
<head>
    <title>TP : Mini jeu de combat</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.3/semantic.min.css"/>
    <link rel="stylesheet" type="text/css" href="assets/css/personnages.css"/>
</head>
<body>

<h1 class="ui center aligned header">
    🧙‍ MJdC 🧙‍
</h1>
<p> Nombre de personnages créés : <?= $manager->count() ?></p>

<?php if (isset($_SESSION["erreur"])) { ?>
        <p class="ui red label"><?=$_SESSION["erreur"]?></p>
<?php   unset($_SESSION["erreur"]);
      }
  ?>

<?php if (isset($_SESSION["confirmation"])) { ?>
    <p class="ui green label"><?=$_SESSION["confirmation"]?></p>
    <?php   unset($_SESSION["confirmation"]);
}
?>

<div class="ui-container center">
    <div class="ui-segment">
        <?= $content ?>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.3/semantic.min.js"></script>

</body>
</html>
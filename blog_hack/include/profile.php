<?php
    
$id =  $_SESSION['id'];
if(isset($_GET['id']) && intval($_GET['id'])) {
    $id = $_GET['id'];
}
$sql = "SELECT
            login,
            email,
            level
        FROM
            user
        WHERE
            id = " . $id . ";";

$query = mysqli_query($link, $sql);
$row = mysqli_fetch_assoc($query);

if($row !== false) { ?>

    <div class="contenu">
        <h2>Profil</h2>
        <div class="txt">Nom d'utilisateur: <?php echo $row['login']; ?><br/>
        Adresse courriel: <?php echo $row['email']; ?><br/>
        Niveau: <?php echo $row['level']; ?></div>
        <div class="bas_bloc"></div>
    </div>

<?php } else { ?>
        
    <div class="contenu">
        <h2>Profil</h2>
        <div class="txt">Ce profil d'utilisateur n'existe pas.</div>
        <div class="bas_bloc"></div>
    </div>
<?php } ?>
    

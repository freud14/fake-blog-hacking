<?php

$search = "";
if(isset($_GET['search']) && !empty($_GET['search'])) {
    $search = " WHERE login LIKE '%".mysqli_real_escape_string($link,$_GET['search'])."%'";
}

$sql = "SELECT
            id,
            login,
            email,
            level
        FROM
            user"
        . $search . ";";

$query = mysqli_query($link,$sql);

?>
<div class="contenu">        <h2>Liste des membres</h2>
    <div class="txt">
         <?php if(isset($_GET['search']) && !empty($_GET['search'])) { ?>
            Vous avez rechercher : <strong> <?php echo $_GET['search']; ?> </strong>
         <?php  } ?>
        <form method="get" action="">
            <input type="hidden" name="page" value="members">
            <input type="text" name="search" value="<?php echo isset($_GET['search'])  && !empty($_GET['search']) ? $_GET['search'] : ""; ?>"/>
            <input type="submit" value="Rechercher" />
        </form>
        <br/><br/>
        <table id="listemembre">
            <tr>
                <td> <strong> Nom d'utilisateur </strong> </td>
                <td> <strong> Adresse courriel </strong> </td>
                <td> <strong> Niveau </strong> </td>
           </tr>
    
<?php  while($row = mysqli_fetch_array($query)) { ?>
            <tr>
                <td> <a href="index.php?page=profile&id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['login']); ?></a> </td>
                <td> <?php echo htmlspecialchars($row['email']); ?> </td>
                <td> <?php echo $row['level']; ?> </td>
           </tr>
<?php } ?>
        </table>
    </div>
    <div class="bas_bloc"></div>
</div>   

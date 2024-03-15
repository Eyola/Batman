<?php
define("BASE_URL", "/EYOSOP");
require_once "./head.php";
?>

<title>Ajout de nouveau rouleau</title>

<?php
require_once "./header.php";
require_once "../controller/rollsManager.php";


$rollsManager = new RollsManager();
$roll = $rollsManager->getRollsById($_GET["id"]);
if ($_POST) {
    $id = $roll->getId();
    $name = $_POST["name"];
    $length = $_POST["length"];
    $recovery = $_POST["recovery"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    var_dump($id);
    try {
        $updateRoll = new Rolls([
            "id" => $id,
            "name" => $name,
            "length" => $length,
            "recovery" => $recovery,
            "description" => $description,
            "price" => $price,
        ]);
        $rollsManager->updateRolls($updateRoll, $id);
        header("Location:rolls.php");
        echo "La modification a réussi.";
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}


?>

<form method="post" class="container">
    <label class="form-label" for="name">Nom / Ref</label>
    <input type="name" name="name" id="name" class="form-control" min=1 max=901 value="<?= $roll->getName() ?>">
    <label class="form-label" for="length">Longueur</label>
    <input type="number" name="length" id="length" class="form-control" placeholder="Longueur du rouleau en m" value="<?= $roll->getLength() ?>">
    <label class="form-label" for="recovery">Recouvrement</label>
    <input type="number" name="recovery" id="recovery" class="form-control" placeholder="Le recouvrement longitudinal en mm" value="<?= $roll->getRecovery() ?>"></input>
    <label class="form-label" for="description">Description</label>
    <input type="text" name="description" id="description" class="form-control" placeholder="Description/destination du rouleau" value="<?= $roll->getDescription() ?>"></input>
    <label class="form-label" for="price">Prix</label>
    <input type="text" name="price" id="price" class="form-control" placeholder="Prix au m²" value="<?= $roll->getPrice() ?>"></input>
    <input type="submit" value="Modifier" class="btn btn-success mt-3">
</form>

<?php
require_once "../views/footer.php";

<?php
require_once APP_PATH . "/views/head.php";
require_once APP_PATH . "/views/header.php";
?>

<h3 class="text-center text-uppercase mt-5 mb-5">Création de nouveau devis</h3>
<div class="work d-flex">
    <div class="container justify-content-center">
        <form method="get" class="" " action=" <?= BASE_URL . 'createEstimate'; ?>">
            <input class="csrf_token" type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <input type="hidden" name="id" value="<?= $selectedCustomer->getId() ?>">
            <ul class="list-group ">
                <li class="list-group-item">
                    <h6>Client</h6>
                    <label class="form-label" for="customer">Nom / Entité</label>
                    <input class="form-control" type="text" name="customer" id="idustomer" value="<?= $nameCustomer ?>">
                </li>

                <li class="list-group-item">
                    <h6>Contact</h6>
                    <label class="form-label" for="nameContact">Nom</label>
                    <input class="form-control" type="text" name="nameContact" id="nameContact" placeholder="Nom de la personne à contacter" value="<?= $contactCustomer ?>">

                    <label class="form-label" for="mailContact">Mail</label>
                    <input class="form-control" type="mail" name="mailContact" id="mailContact" value="<?= $mailContact ?>">

                    <label class="form-label" for="adressContact">Adresse</label>
                    <input class="form-control" type="text" name="adressContact" id="adressContact" value="<?= $adressContact ?>">
                </li>

                <li class="list-group-item">
                    <h6>Chantier</h6>
                    <label class="form-label" for="nameEstimate">Nom</label>
                    <input class="form-control" type="text" name="nameEstimate" id="nameEstimate" placeholder="Nom du chantier/devis">
                </li>
                <div class="d-inline-flex justify-content-center"><input type="submit" class="btn btn-success mt-3" value="Créer devis" id="addLine" /></div>
            </ul>
        </form>
    </div>
</div>


<?php
require_once APP_PATH . "/views/footer.php";
?>
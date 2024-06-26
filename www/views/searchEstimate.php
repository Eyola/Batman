<?php
require_once APP_PATH . "/views/head.php";
require_once APP_PATH . "/views/header.php";
?>

<h3 class="text-center text-uppercase mt-5">modifier Devis</h3>
<div class="work d-flex align-items-center">
    <div class="container">
        <form action="<?= BASE_URL . 'modifyEstimate'; ?>" method="post">
            <select class="form-select selectEstimate" aria-label="Default select example" name="idEstimate">

                <option selected>Open this select menu</option>
                <?php foreach ($estimateList as $estimate) { ?>
                    <option class="estimate" value="<?= $estimate->getId() ?>"><?= $estimate->getNameEstimate() ?></option>
                <?php
                }
                ?>
            </select>
            <input type="submit" value="Modifier devis" class="btn btn-warning estimateButton" disabled>
        </form>
    </div>
</div>
<script src="js/searchEstimateScript.js"></script>
<?php
require_once APP_PATH . "/views/footer.php";
?>
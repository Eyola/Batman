<?php
require_once APP_PATH . "/views/head.php";
require_once APP_PATH . "/views/header.php";
?>

<h2 class="text-center text-uppercase mt-5">situation</h2>
<h3 class="text-center text-uppercase"><?= $estimate->getNameEstimate(); ?></h3>

<div class="container">
    <input type="hidden" id="taskQuantity" value="<?= count($tasksList) ?>">
    <form method="post" action="<?= BASE_URL . 'saveSituation'; ?>">
        <input class="csrf_token" type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <input type="hidden" id="controlUpdate" name="controlUpdate" value="update">
        <input type="hidden" name="idEstimate" value="<?= $estimate->getId() ?>">
        <div class="blockList">
            <?php
            foreach ($tasksList as $taskDetails) {
            ?>
                <div class="py-2 block<?= $taskDetails['taskNumber'] ?>" name="lineNb<?= $taskDetails['taskNumber'] ?>">
                    <input type="hidden" class="blocNb" name="taskId<?= $taskDetails['taskNumber'] ?>" value="<?= $taskDetails['id'] ?>">
                    <label for="description" class="fs-5 fw-bold">Description</label>
                    <textarea rows="2" class="form-control description" name="description<?= $taskDetails['taskNumber'] ?>" disabled><?= $taskDetails['descriptionTask'] ?></textarea>
                    <div class="table-responsive">
                        <table class="text-center table table<?= $taskDetails['taskNumber'] ?> table-striped">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Produit</th>
                                    <th>Quantité</th>
                                    <th>Prix unitaire</th>
                                    <th>Montant total</th>
                                    <th>Avancement</th>
                                </tr>
                            </thead>
                            <tbody class="task<?= $taskDetails['taskNumber'] ?>">
                                <?php
                                $productsByTask = $taskManager->getProductsByTask($taskDetails['id']); //les infos des produits, sans leur identité, mais leur id
                                foreach ($productsByTask as $productByTask) {
                                    $testproduct = $productsManager->getProductsById($productByTask->getIdProduct());
                                ?>
                                    <tr class="rowId row<?= $taskDetails['taskNumber'] . $productByTask->getRow() ?>" id="<?= $taskDetails['taskNumber'] . $productByTask->getRow() ?>">
                                        <input type="hidden" class="rowNb" name="row<?= $taskDetails['taskNumber'] ?>[]" value="<?= $productByTask->getRow() ?>">
                                        <td>
                                            <select class="form-select type" id="type" aria-label="Default select example" style="min-width: 140px" disabled>
                                                <?php foreach ($typesList as $type) { ?>
                                                    <option class="" value="<?= $type->getName() ?>" <?php
                                                                                                        if ($type->getName() == $testproduct->getType()) {
                                                                                                            echo 'selected';
                                                                                                        } ?>><?= $type->getName() ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select product" id="product" aria-label="Default select example" name="product<?= $taskDetails['taskNumber'] ?>[]" style="min-width: 140px" disabled>
                                                <?php foreach ($productList as $type => $product) { ?>
                                                    <option class="<?= $product->getType() ?>" value="<?= $product->getName() ?>" <?php
                                                                                                                                    if ($product->getName() == $testproduct->getName()) {
                                                                                                                                        echo 'selected';
                                                                                                                                    } ?>><?= $product->getName() ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input class="form-control text-center quantity" id="quantity" name="quantity<?= $taskDetails['taskNumber'] ?>[]" type="number" value="<?= $productByTask->getQuantityProduct() ?>" style="min-width: 140px" disabled>
                                        </td>
                                        <td>
                                            <div class="currency-wrap">
                                                <span class="currency-code">€</span>
                                                <input class="form-control text-center unitPrice text-currency" style="min-width: 150px" name="unitPrice<?= $taskDetails['taskNumber'] ?>[]" type="number" step="any" id="unitPrice" value="<?= $productByTask->getUnitPriceProduct() ?>" style="min-width: 140px" disabled>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="currency-wrap">
                                                <span class="currency-code">€</span>
                                                <input type="number" step="any" data-type="currency" class="resultPrice text-center form-control text-currency" style="min-width: 150px" value="<?= $productByTask->getQuantityProduct() * $productByTask->getUnitPriceProduct() ?>" disabled></input>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="currency-wrap">
                                                <span class="currency-code">%</span>
                                                <input type="number" class="form-control text-center text-currency" style="min-width: 150px" name="situation<?= $taskDetails['taskNumber'] ?>[]" value="<?= $productByTask->getSituation() ?>">
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <hr class="border border-primary border-1 opacity-100">

                </div>
            <?php
            }
            ?>
            <div class="container text-end pb-4">
                <input type="submit" value="Enregistrer situation" class="btn btn-primary">
            </div>
        </div>
    </form>
</div>

<?php
require_once APP_PATH . "/views/footer.php";
?>
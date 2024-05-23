<?php

require_once APP_PATH . "/models/PDOServer.php";
require_once APP_PATH . "/models/estimateManager.php";
require_once APP_PATH . "/models/typesManager.php";
require_once APP_PATH . "/models/productsManager.php";
require_once APP_PATH . "/models/taskManager.php";
require_once APP_PATH . "/models/productByTaskManager.php";
require_once APP_PATH . "/models/userManager.php";

class EstimateController
{
    public function estimate()
    {
        require_once APP_PATH . "/views/estimate.php";
    }

    public function newEstimatePage()
    {
        $customersManager = new CustomersManager();
        $selectedCustomer = $customersManager->getCustomerById($_GET["id"]);
        $nameCustomer = $selectedCustomer->getNameCustomer();
        $contactCustomer = $selectedCustomer->getNameContact();
        $mailContact = $selectedCustomer->getMailContact();
        $adressContact = $selectedCustomer->getAdressContact();
        require_once APP_PATH . "/views/newEstimate.php";
    }
    public function newEstimate()
    {
        echo "newEstimate";
        $estimateManager = new EstimateManager();
        var_dump($_POST);
        if ($_POST) {
            $nameEstimate = $_POST["nameEstimate"];
            $idCustomer = $_POST["id"];
            try {
                $newEstimate = new Estimate([
                    "nameEstimate" => $nameEstimate,
                    "idCustomer" => $idCustomer,
                ]);
                var_dump($newEstimate);
                $idEstimate = $estimateManager->createEstimate($newEstimate);
                var_dump($idEstimate);
                $estimate = $estimateManager->showEstimateById($idEstimate);
                var_dump($estimate);
                $typesManager = new TypesManager();
                $typesList = $typesManager->showTypes();
                $productsManager = new ProductsManager();
                $productList = $productsManager->showProducts();
                require_once APP_PATH . "/views/createEstimate.php";
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
    }

    public function saveEstimate()
    {
        $taskManager = new TaskManager();
        $productByTaskManager = new productByTaskManager();
        $productsManager = new ProductsManager();

        $tasksNumber = 1;

        if ($_POST) {
            $idEstimate = $_POST['idEstimate'];
            try {
                $count = floor(count($_POST) / 4);
                for ($i = 0; $i < $count; $i++) {
                    $newTask = new Task([
                        'taskNumber' => $_POST['taskNumber' . $i][0],
                        'descriptionTask' => $_POST["description" . $i][0],
                        /* 'quantity' => $_POST["quantity" . $i],
                        'unitPrice' => $_POST["unitPrice" . $i] */
                    ]);
                    $idTask = $taskManager->addTask($newTask);
                    $taskManager->addTaskRef($idEstimate, $idTask);
                    $j = 0;
                    foreach ($_POST['product' . $i] as $value) {
                        $product = $productsManager->getProductsByName($_POST['product' . $i][$j]);
                        $newProducts = new Products([
                            'id' => $product->getId()
                        ]);
                        $newProductByTask = new ProductByTask([
                            'quantityProduct' => $_POST['quantity' . $i][$j],
                            'unitPriceProduct' => $_POST['unitPrice' . $i][$j],
                        ]);
                        $taskManager->addProductByTask($idTask, $newProductByTask, $newProducts);
                        $j++;
                    }
                } /* header("Location:modifyEstimate.php?id=$estimateId"); */
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
    }

    public function searchEstimateToModify()
    {
        $estimateManager = new EstimateManager();
        $estimateList = $estimateManager->showEstimateToModify();
        require_once APP_PATH . '/views/searchEstimate.php';
    }

    public function modifyEstimate()
    {
        $estimateManager = new EstimateManager();
        $productsManager = new ProductsManager();
        $productList = $productsManager->showProducts();
        $typesManager = new TypesManager();
        $typesList = $typesManager->showTypes();
        $taskManager = new TaskManager();
        $productByTaskManager = new productByTaskManager();
        $tasksList = $taskManager->showTasksById($_GET['id']);
        $tasksNumber = count($tasksList);
        require_once APP_PATH . '/views/modifyEstimate.php';
    }

    public function updateEstimate()
    {
        if ($_POST) {
            try {
                foreach ($tasksList as $tasksid) {
                    $idTasks[] = $tasksid['id'];
                }
                $taskManager->deleteTasks($idTasks);
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
            $idEstimate = $_GET['id'];
            /* try {
        $count = count($_POST) / 4;
        for ($i = 0; $i < $count; $i++) {        
            $newTask = new Task([
                'description' => $_POST["description" . $i][0],
                /* 'quantity' => $_POST["quantity" . $i], 
                /* 'unitPrice' => $_POST["unitPrice" . $i] 
            ]);
            $idTask = $taskManager->addTask($newTask);
            $j = 0;
            foreach ($_POST['product' . $i] as $value) {
                $product = $productsManager->getProductsByName($_POST['product' . $i][$j]);
                $newProducts = new Products([
                    'id' => $product->getId()
                ]);
                $newProductByTask = new ProductByTask([
                    'quantityProduct' => $_POST['quantity' .$i][$j],
                    'unitPriceProduct' => $_POST['unitPrice' .$i][$j],
                ]);
                $taskManager->addProductByTask($idTask, $newProductByTask, $newProducts);
                $j++;   

            }
        } 
    } catch (Exception $e) {
        $error = $e->getMessage();
    }*/
        }
    }

    public function accountingPage()
    {
        require_once APP_PATH . "/views/accounting.php";
    }

    public function estimateToRegister()
    {
        $estimateManager = new EstimateManager();
        $estimateList = $estimateManager->showEstimateToModify();
        $userManager = new UserManager();
        $driverList = $userManager->getDrivers();
        require_once APP_PATH . "/views/estimateToRegister.php";
    }

    public function registerEstimate()
    {
        $estimateManager = new EstimateManager();
        $estimateManager->registerEstimate($_POST["id"], $_POST["driver"]);
        $this->accountingPage();
    }

    public function estimateRegistered()
    {
        $estimateManager = new EstimateManager();
        $estimateList = $estimateManager->showEstimateRegistered();
        var_dump($estimateList);
        require_once APP_PATH . "/views/estimateRegistered.php";
    }
}
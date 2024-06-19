<?php
require_once APP_PATH . "/models/projectsManager.php";
require_once APP_PATH . "/models/estimateManager.php";
class ProjectsController
{

    public function projectsPage()
    {
        $projectsManager = new ProjectsManager;
        $projectList = $projectsManager->projectRegisteredList();
        require_once APP_PATH . "/views/projects.php";
    }

    public function editSituationPage()
    {
        var_dump($_POST);
        if ($_SESSION['role'] != 'Assistant') {
            $estimateManager = new EstimateManager();
            $taskManager = new TaskManager();
            $productsManager = new ProductsManager();
            $typesManager = new TypesManager();
            $productByTaskManager = new productByTaskManager();
            if ($_GET) {
                $estimate = $estimateManager->showEstimateById($_GET['id']);
                $tasksList = $taskManager->showTasksById($_GET['id']);
            } else if ($_POST) {
                $estimate = $estimateManager->showEstimateById($_POST['id']);
                $tasksList = $taskManager->showTasksById($_POST['id']);
            }
            $productList = $productsManager->showProducts();
            $typesList = $typesManager->showTypes();
            require_once APP_PATH . "/views/editSituation.php";
        } else {
            echo "Vous n'avez pas les droits pour acceder à cette page.";
        }
    }

    public function saveSituation()
    {
        if ($_POST && $_SESSION['role'] != 'Assistant') {
            $result = 0;
            $search = 'taskId';
            foreach ($_POST as $key => $value) {
                if (substr_count($key, $search) == 1) {
                    $result++;
                }
            }
            try {
                $projectManager = new ProjectsManager();
                for ($i = 0; $i < $result; $i++) {
                    $j = 0;
                    foreach ($_POST['situation' . $i] as $value) {
                        $newSituationByProduct = new ProductByTask([
                            'idTask' => $_POST['taskId' . $i],
                            'situation' => $_POST['situation' . $i][$j],
                            'row' => $_POST['row' . $i][$j]
                        ]);
                        $projectManager->saveSituation($newSituationByProduct);
                        $j++;
                    }
                }
            } catch (\Throwable $th) {
                //throw $th;
            }
            $this->editSituationPage();
        } else {
            echo "Vous n'avez pas les droits pour acceder à cette page.";
        }
    }

    public function orderPage()
    {
        if ($_SESSION['role'] != 'Assistant') {
            $estimateManager = new EstimateManager();
            $taskManager = new TaskManager();
            $productsManager = new ProductsManager();
            $typesManager = new TypesManager();
            $productByTaskManager = new productByTaskManager();
            if ($_GET) {
                $estimate = $estimateManager->showEstimateById($_GET['id']);
                $tasksList = $taskManager->showTasksById($_GET['id']);
            } else if ($_POST) {
                $estimate = $estimateManager->showEstimateById($_POST['idEstimate']);
                $tasksList = $taskManager->showTasksById($_POST['idEstimate']);
            }
            $productList = $productsManager->showProducts();
            $typesList = $typesManager->showTypes();
            require_once APP_PATH . "/views/order.php";
        } else {
            echo "Vous n'avez pas les droits pour acceder à cette page orderPage.";
        }
    }

    public function saveOrder()
    {
        if ($_POST && $_SESSION['role'] != 'Assistant') {
            $result = 0;
            $search = 'taskId';
            foreach ($_POST as $key => $value) {
                if (substr_count($key, $search) == 1) {
                    $result++;
                }
            }
            try {
                $projectManager = new ProjectsManager();
                for ($i = 0; $i < $result; $i++) {
                    $j = 0;
                    foreach ($_POST['expense' . $i] as $value) {
                        $row = (is_numeric($_POST['row' . $i][$j]) ? (int)$_POST['row' . $i][$j] : 0);
                        $newExpense = (is_numeric($_POST['expense' . $i][$j]) ? (int)$_POST['expense' . $i][$j] : 0);
                        $oldExpense = (is_numeric($_POST['alreadyBuy' . $i][$j]) ? (int)$_POST['alreadyBuy' . $i][$j] : 0);
                        $expense = $newExpense + $oldExpense;
                        $newProductByTask = new ProductByTask([
                            'idTask' => $_POST['taskId' . $i],
                            'row' => $row,
                            'expense' => $expense,
                        ]);
                        $j++;
                        $projectManager->expense($newProductByTask);
                    }
                }
            } catch (Exception $e) {
                $e->getMessage();
            }
            $this->orderPage();
        } else {
            echo "Vous n'avez pas les droits pour acceder à cette page là.";
        }
    }

    public function resultsPage()
    {
        $estimateManager = new EstimateManager();
        $estimate = $estimateManager->showEstimateById($_GET['id']);
        $tasksManager = new TaskManager();
        $tasksList = $tasksManager->showTasksById($_GET['id']);
        $productsManager = new ProductsManager();
        $projectsManager = new ProjectsManager();
        $productsResultList = $projectsManager->getTotalProductByProject($_GET['id']);
        $marges = $projectsManager->getRemainingBudgetPerSituation($_GET['id']);
        require_once APP_PATH . "/views/results.php";
    }

    public function totalBudget(ProductByTask $productByTask)
    {
        return $productByTask->getQuantityProduct() * $productByTask->getUnitPriceProduct();
    }

    public function projectedExpense(ProductByTask $productByTask)
    {
        return $this->totalBudget($productByTask) * $productByTask->getSituation() / 100;
    }

    public function remainingBudget(ProductByTask $productByTask)
    {
        return $this->totalBudget($productByTask) - $this->projectedExpense($productByTask);
    }

    public function margin()
    {
        $projectsManager = new ProjectsManager();
        $test =  $projectsManager->getRemainingBudgetPerSituation($_GET('id'));
    }

    public function projectedBudget(ProductByTask $productByTask)
    {
        return $this->totalBudget($productByTask) * $productByTask->getSituation() / 100;
    }

    public function getMarge(ProductByTask $productByTask, array $marges)
    {
        foreach ($marges as $marge) {
            if ($productByTask->getIdProduct() == $marge->getIdProduct()) {
                return $marge->getExpense();
            }
        }
    }
}

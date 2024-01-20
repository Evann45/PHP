<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Application</title>
</head>
<body>

    <header>
        <h1>Mon Application</h1>
    </header>

    <main>
        <?php

        use controller\ControllerHome;
        use data\Database;
        
        require "class/autoload.php";
        
        require "data/json_to_sql.php";
        
        // $statement = Database::getInstance()->query("SELECT * FROM questions");
        // $questions = $statement->fetchAll();
        
        
        if(isset($_GET["controller"]) and isset($_GET["action"])){
            $controllerName = $_GET["controller"];
        
            $controller = match($controllerName){
                "ControllerHome" => new ControllerHome(),
                default => null
            };
        
            $actionName = $_GET["action"];
            echo $controller->$actionName();
        }
        
        ?>
    </main>

    <footer>
    </footer>

</body>
</html>


<
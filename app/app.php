<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/User.php";
    require_once __DIR__."/../src/Item.php";
    require_once __DIR__."/../src/Community.php";

    $app = new Silex\Application();

    $server = "mysql:host=localhost:8889;dbname=warehouse";
    $username = "root";
    $password = "root";
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array("twig.path" => __DIR__."/../views"));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/", function() use ($app) {
        return $app["twig"]->render("index.html.twig");
    });

    $app->get("/start_sharing", function() use ($app) {
        return $app["twig"]->render("profiles.html.twig");
    });

    $app->post("/profile_create", function() use ($app) {
        $name = $_POST['new_member_name'];
        $email = $_POST['new_member_email'];
        $new_member = new User($name, $email);
        $new_member->save();
        return $app["twig"]->render("profiles.html.twig", array(User::getAll()));
    });




    return $app;
 ?>

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!empty($_REQUEST["act"])) {
    switch ($_REQUEST["act"]) {
        case "install1":
            $file_config = $_ENV["basepath"]."/config.php";
            if (!file_exists($file_config) AND !is_writeable(dirname($file_config))) die("config.php not writeable 1");
            if (file_exists($file_config) AND !is_writeable($file_config)) die("config.php not writeable 2");

            $outfile = '<?php'.PHP_EOL;
            $outfile .= '$config["mysql"]["connection"] = "mysql://'.$_REQUEST["dbuser"].':'.$_REQUEST["dbpassword"].'@'.$_REQUEST["dbhost"].'/'.$_REQUEST["dbname"].'";'.PHP_EOL;
            file_put_contents($file_config, $outfile);
            
            PageEngine::html(array("url" => "/"));
            exit;
        case "installdev":
            $file_config = $_ENV["basepath"]."/config.php";
            if (!file_exists($file_config) AND !is_writeable(dirname($file_config))) die("config.php not writeable 1");
            if (file_exists($file_config) AND !is_writeable($file_config)) die("config.php not writeable 2");

            $outfile = '<?php'.PHP_EOL;
            $outfile .= 'ini_set("display_errors", 1);'.PHP_EOL;
            $outfile .= 'error_reporting(E_ALL);'.PHP_EOL;
            $outfile .= '$config["db"]["connection"] = "mysql:mysql:host=localhost;dbname=opentube";
            $config["db"]["user"] = "opentube";
            $config["db"]["password"] = "opentube";'.PHP_EOL;
            file_put_contents($file_config, $outfile);

            require_once($_ENV["basepath"]."/app/code/classes/DB.php");

            DB::init(0, "mysql:mysql:host=localhost;dbname=opentube", "opentube", "opentube");
            $db = new DB(0);
            $sql = file_get_contents(dirname($_ENV["basepath"])."/opentube.dev.sql");
            $db->exec($sql);

            PageEngine::html("goto", array("url" => "/"));
            exit;
    }
}



?><html>
    <head>
        <title>OpenTube install</title>
        <link rel="shortcut icon" href="/skins/default/img/favicon_opentube.png">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="https://library.goo1.de/fontawesome/5/css/all.min.css" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    </head>

<body>
<header>
      <div class="navbar navbar-dark bg-dark box-shadow">
        <div class="container d-flex justify-content-between">
          <a href="/" class="navbar-brand d-flex align-items-center">
            <i class="far fa-film-alt fa-2x mr-1"></i> OpenTube
          </a>
        </div>
      </div>
    </header>
<main>
<section class="container">
    <form method="POST">
        <INPUT type="hidden" name="act" value="install1"/>
    <h1 class="h1 my-2">Installation OpenTube</h1>
    <div class="form-group row">
        <label for="inputFld1" class="col-sm-2 col-form-label">MySQL/MariaDB host:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="inputFld1" name="dbhost" placeholder="" value="localhost">
        </div>
    </div>

    <div class="form-group row">
        <label for="inputFld2" class="col-sm-2 col-form-label">Username:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="inputFld2" name="dbuser" placeholder="" value="opentube">
        </div>
    </div>

    <div class="form-group row">
        <label for="inputFld3" class="col-sm-2 col-form-label">Password:</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="inputFld3" name="dbpassword" placeholder="" value="">
        </div>
    </div>

    <div class="form-group row">
        <label for="inputFld4" class="col-sm-2 col-form-label">Database:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="inputFld4" name="dbname" placeholder="" value="opentube">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
            <button class="btn btn-primary" type="submit">Installation starten</button>
        </div>
    </div>
    </form>
    <hr/>
    <a class="btn btn-outline-primary" href="?act=installdev">Developmentversion installieren</a>
</section>
</main>



</body>
</html>
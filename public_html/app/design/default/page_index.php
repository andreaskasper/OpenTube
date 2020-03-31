<?php
$db = new DB(0);

PageEngine::html("header", array("search" => $_GET["q"] ?? ""));
?>
<main>
<div class="container">
Hier ist die Hauptseite
</div>
</main>
<?php
PageEngine::html("footer");
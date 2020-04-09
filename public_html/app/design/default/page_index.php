<?php
$db = new DB(0);

PageEngine::html("header", array("search" => $_GET["q"] ?? ""));
?>
<main>
<div class="container">
Hier ist die Hauptseite

<?php
print_r($_SESSION);
PageEngine::html("widget_login");
?>

</div>
</main>
<?php
PageEngine::html("footer");
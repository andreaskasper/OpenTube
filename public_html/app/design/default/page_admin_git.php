<?php
$db = new DB(0);

$git = Git::open(dirname($_ENV["basepath"]));

if (!empty($_REQUEST["act"])) {
    switch ($_REQUEST["act"]) {
        case "addfile":
            $a = $git->add($_REQUEST["file"]);
            print_r($a);
            exit;


    }
}

PageEngine::html("header", array("search" => $_GET["q"] ?? ""));
?>
<main>
<div class="container">
<h1 class="my-4">Git</h1>

<style>
.fa-stacktr {
    top: -0.5rem;
    right: -0.5rem;
    left: auto;
    bottom: auto;
}
</style>
<table>
<?php
if (Git::is_repo($git)) {
    exec('git status --porcelain "'.dirname($_ENV["basepath"]).'"', $g);
    foreach ($g as $row) {
        $aw = substr($row,0,2);
        $file = trim(substr($row,2,9999));
        if ($file == ".gitignore") continue;
        $ext = substr($file,strrpos($file,"."),999);
        switch (strtolower($ext)) {
            case ".php":
                $fileicon = "far fa-file-code"; break;
            default:
                $fileicon = "far fa-file"; break;
        }
        switch ($aw) {
            case "??":
                echo('<tr><td><span class="fa-stack"><i class="'.$fileicon.' fa-stack-2x"></i><i class="fas fa-sparkles fa-stack-1x fa-stacktr" style="color: #080;"></i></span></td><td>'.html($file).'</td><td><button type="button" class="btn btn-outline-secondary" data-action="addfile" data-file="'.htmlattr($file).'">+</button></td></tr>');
                break;
            case "D ":
                echo('<tr><td><span class="fa-stack"><i class="'.$fileicon.' fa-stack-2x"></i><i class="far fa-minus-square fa-stack-1x fa-stacktr" style="color: #800;"></i></span></td><td>'.html($file).'</td><td></td></tr>');
                break;
            case "M ":
                echo('<tr><td><span class="fa-stack"><i class="'.$fileicon.' fa-stack-2x"></i><i class="far fa-plus-square fa-stack-1x fa-stacktr" style="color: #080;"></i></span></td><td>'.html($file).'</td><td></td></tr>');
                break;
            case " M":
                echo('<tr><td><span class="fa-stack"><i class="'.$fileicon.' fa-stack-2x"></i><i class="fas fa-pen fa-stack-1x fa-stacktr" style="color: #f80;"></i></span></td><td>'.html($file).'</td><td><button type="button" class="btn btn-outline-secondary" data-action="addfile" data-file="'.htmlattr($file).'">+</button></td></tr>');
                break;
            case " D":
                echo('<tr><td><span class="fa-stack"><i class="'.$fileicon.' fa-stack-2x"></i><i class="fas fa-trash-alt fa-stack-1x fa-stacktr" style="color: #f00;"></i></span></td><td>'.html($file).'</td><td><button type="button" class="btn btn-outline-secondary" data-action="addfile" data-file="'.htmlattr($file).'">+</button></td></tr>');
                break;
            case "A ":
                echo('<tr><td>'.str_replace(' ','■',$aw).'</td><td>'.html($file).'</td><td>added</td></tr>');
                break;
            default:
                echo('<tr><td>'.str_replace(' ','■',$aw).'</td><td>'.html($file).'</td></tr>');
                break;
        }
    }
}

?></table>
<script>
$(document).ready(function() {
    $(document).on("click", "[data-action]", function() {
        doaction($(this).data("action"), $(this));
    });
});

function doaction(act, ele) {
    switch (act) {
        case "addfile":
            $.post(document.location.href, {act: "addfile", file: ele.data("file")});
    }
}
</script>

</div>
</main>
<?php
PageEngine::html("footer");


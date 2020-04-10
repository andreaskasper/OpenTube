<?php
$loc = dirname($_ENV["basepath"]);
exec('git log "'.$loc.'"', $lines);
preg_match("@commit (?P<c>[a-f0-9]+)@", $lines[0], $m1);
$html = file_get_contents("https://github.com/andreaskasper/OpenTube/commits/master");
preg_match("@/OpenTube/commit/(?P<c>[a-f0-9]+)@mi", $html, $m2);

if ($m1["c"] == $m2["c"]) echo('<div class="container"><div class="alert alert-success"><i class="fab fa-github fa-1x mr-2"></i>Git okay.</div></div>');
else {
    $j = false;
    foreach ($lines as $row) {
        if (strpos($row ?? "", $m2["c"]) !== FALSE) $j = true;
    }
    if (!$j) echo('<div class="container"><div class="alert alert-danger"><i class="fab fa-github fa-3x float-left mr-2"></i><b>Neu Version in your Git</b><br/>You need to pull the new update.</div></div>');
    else echo('<div class="container"><div class="alert alert-primary"><i class="fab fa-github fa-3x float-left mr-2"></i><b>Commited</b><br/>Ready to push your update.</div></div>');
}

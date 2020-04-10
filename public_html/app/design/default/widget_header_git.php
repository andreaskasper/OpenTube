<?php
$loc = dirname($_ENV["basepath"]);
exec('git log "'.$loc.'"', $lines);
preg_match("@commit (?P<c>[a-f0-9]+)@", $lines[0], $m1);
$html = file_get_contents("https://github.com/andreaskasper/OpenTube/commits/master");
preg_match("@/OpenTube/commit/(?P<c>[a-f0-9]+)@mi", $html, $m2);

if ($m1["c"] == $m2["c"]) echo('<div class="container"><div class="alert alert-success">Git okay.</div></div>');
else echo('<div class="container"><div class="alert alert-success"><b>Neu Version in your Git</b><br/>You need to pull the new update.</div></div>');

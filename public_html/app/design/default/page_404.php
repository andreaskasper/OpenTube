<?php
header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");

PageEngine::html("header");

echo('<div class="text-center" style="padding: 25vh 0;"><span style="font-size: 5rem;">404</span></div>');

PageEngine::html("footer");
exit;
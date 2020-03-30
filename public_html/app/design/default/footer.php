<?php

namespace web;

i18n::init(__FILE__);

?><footer class="bg-dark d-none d-sm-block">
	<div class="container my-1">
		<div class="row">
			<div class="col-auto">
				&copy; 2017-<?=date("Y"); ?> by DanceCloud
			</div>
			<div class="col-auto d-none">
				<a href="/<?=$_ENV["lang"]; ?>/yt" TARGET="_blank"><i class="fab fa-youtube"></i> YouTube</a>
				<a href="https://twitch.tv/5678wcs" TARGET="_blank"><i class="fab fa-twitch"></i> Twitch</a>
				<a href="https://discord.gg/mdAkUe" TARGET="_blank"><i class="fab fa-discord"></i> Discord</a>
			</div>
			<div class="col text-right">
				<a href="https://www.hepcatclub.com/de_impressum.html" style="color:#777" TARGET="_blank"><?=__("Impressum"); ?></a>
				<a href="https://www.hepcatclub.com/de_datenschutzerklaerung.html" style="color:#777" TARGET="_blank"><?=__("data protection"); ?></a>
				<!--<a href="">Partner</a>-->
				<a href="/abuse" style="color:#777">DMCA/Abuse</a>
			</div>
		</div>
	</div>
</footer>




    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/skins/default/js/popper.min.js"></script>
    <script src="/skins/default/libs/bootstrap/js/bootstrap.min.js"></script>
	<script src="/skins/default/js/main.js"></script>
    <!--<script src="../../assets/js/vendor/holder.min.js"></script>
    <script>
      Holder.addTheme('thumb', {
        bg: '#55595c',
        fg: '#eceeef',
        text: 'Thumbnail'
      });
    </script>-->
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-486839-34"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', 'UA-486839-34');
	</script>

	<script data-ad-client="ca-pub-3364448309114165" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

	<!-- start webpushr code --> <script>(function(w,d, s, id) {w.webpushr=w.webpushr||function(){(w.webpushr.q=w.webpushr.q||[]).push(arguments)};var js, fjs = d.getElementsByTagName(s)[0];js = d.createElement(s); js.id = id;js.src = "https://cdn.webpushr.com/app.min.js";fjs.parentNode.appendChild(js);}(window,document, 'script', 'webpushr-jssdk'));webpushr('init','BAOnUlAXqKWViV1qEwD8t5ewI7bA0y67eeD3-Q2N153iMedC5vLAgOs6uQghMcu1ZVpPjGBD88EBJfmdUtKvFCk');</script><!-- end webpushr code -->


  </body>
</html>

<?php

i18n::init(__FILE__);

?><footer class="bg-dark text-light py-2">
	<div class="container">
		<div class="row">
			<div class="col-auto">
				<i class="fab fa-creative-commons"></i><i class="fab fa-creative-commons-by"></i> <?=date("Y"); ?> by <a href="https://www.facebook.com/AndiKDance/" class="text-light" TARGET="_blank">Andreas Kasper</a>
			</div>
			<div class="col text-right">
				<span class="ml-1 mb-1 text-light">support us:</span>
				<a href="https://paypal.me/AndreasKasper" class="text-light ml-1 mb-1" TARGET="_blank"><i class="fab fa-paypal"></i></a>
				<a href="https://patreon.com/AndreasKasper" class="text-light ml-1 mb-1" TARGET="_blank"><i class="fab fa-patreon"></i></a>
			</div>
			
			<!--<div class="col-auto d-none">
				<a href="/<?=$_ENV["lang"]; ?>/yt" TARGET="_blank"><i class="fab fa-youtube"></i> YouTube</a>
				<a href="https://twitch.tv/5678wcs" TARGET="_blank"><i class="fab fa-twitch"></i> Twitch</a>
				<a href="https://discord.gg/mdAkUe" TARGET="_blank"><i class="fab fa-discord"></i> Discord</a>
			</div>
			<div class="col text-right">
				<a href="https://www.hepcatclub.com/de_impressum.html" style="color:#777" TARGET="_blank"><?=__("Impressum"); ?></a>
				<a href="https://www.hepcatclub.com/de_datenschutzerklaerung.html" style="color:#777" TARGET="_blank"><?=__("data protection"); ?></a>
				<!- -<a href="">Partner</a>- ->
				<a href="/abuse" style="color:#777">DMCA/Abuse</a>
			</div>-->
		</div>
	</div>
</footer>




    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script src="/skins/default/js/main.js"></script>
    <!--<script src="../../assets/js/vendor/holder.min.js"></script>
    <script>
      Holder.addTheme('thumb', {
        bg: '#55595c',
        fg: '#eceeef',
        text: 'Thumbnail'
      });
    </script>-->
	

  </body>
</html>

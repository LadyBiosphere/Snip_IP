		<!--Footer navigation-->
		<div class="foot-nav">
			<footer>
				<ul>
					<li><a href="index.php?page=access" accesskey="7"><i class="fa fa-question-circle"></i> Accessibility</a></li>
					<li><a href="http://goo.gl/dAL9HL" accesskey="8"><i class="fa fa-facebook-square"></i> Facebook</a></li>
					<li><a href="http://goo.gl/ba8OKF" accesskey="9"><img src="images/logos/collect.png" alt="Collect SNIP"> Points</a></li>

						<!--If no one logged in, show 'login' button. Else, show 'logout' and 'control'.-->
						<?php
							if(!isset($_SESSION['user_username'])):
						?>

						<li><a href="index.php?page=login" accesskey="0"><i class="fa fa-scissors"></i> Admin Login</a></li>
					
						<?php 
							else:
						?>

					<li><a href="index.php?page=logout" accesskey="0"><i class="fa fa-scissors"></i> Logout</a></li>
					<li><a href="index.php?page=admin"><i class="fa fa-cog fa-spin"></i> Controls</a></li>

						<?php 
							endif;
						?>
				</ul>
				<p><a href="http://goo.gl/IOeD72">Web developer | Nishita Singh, 2014</a></p>
			</footer>	
		</div>

	</div>
	<!--End of blackboard background-->

	<!--JavaScript/jQuery for interactive sliders-->
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="js/wallopSlider.js"></script>
	<script>
	  var slider = new WallopSlider('.wallop-slider');
	  slider.on('change', function (event) {
	    console.log(event.detail.currentItemIndex);
	    console.log(event.detail.parentSelector);
	  });
	</script>

	<!--Google Analytics for future data analysis-->
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-56652409-1', 'auto');
	  ga('send', 'pageview');
	</script>

</body>
</html>
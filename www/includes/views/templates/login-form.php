<!-- Strictly for 'Login' -->
<div id="container">

	<div class="news-container">

		<div class="form">
			<form action="<?php echo $_SERVER['PHP_SELF'] ?>?page=login" method="POST" id="login-form">
				<div>
					<label for="username">Username: </label>
					<input type="text" name="username" id="username" placeholder="myusername">
					<span class="error" id="username-error"><?php echo $this->message; ?><?php echo $this->usernameError; ?></span>
				</div>
				<div>
					<label for="password">Password: </label>
					<input type="password" name="password" id="password">
					<span class="error" id="password-error"><?php echo $this->message; ?><?php echo $this->passwordError; ?></span>
				</div>
				<div>
					<input type="submit" name="login" value="login" class="button">
				</div>
			</form>
		</div>
		
	</div>

</div>
<!-- End of written content -->

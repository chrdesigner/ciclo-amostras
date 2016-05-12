<form id="login" action="login" method="post" class="autenticacao-promotor">
	<h1>Realize a sua autenticacão</h1>
   
    <p class="status"></p>
   
    <span class="wpcf7-form-control-wrap username">
	    <label for="username">Email do Promotor <sup>*</sup></label>
	    <input class="wpcf7-form-control wpcf7-text" id="username" type="text" name="username" pattern="[^ @]+@[^ @]+.[a-z]+" placeholder="Digite o seu e-mail de promotor" required />
    </span>

    <span class="wpcf7-form-control-wrap password">
	    <label for="password">Senha <sup>*</sup></label>
	    <input class="wpcf7-form-control wpcf7-text" id="password" type="password" name="password" placeholder="Digite a sua senha"  required />
    </span>
    
    <a class="lost" href="<?php echo wp_lostpassword_url(); ?>">Esqueceu a sua senha?</a>
    <input class="submit_button" type="submit" value="Login" name="submit">
    
    <a class="close" href="">(close)</a>
    <?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
</form>
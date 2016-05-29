<img src="<?php echo $logoUrl; ?>" alt="König Brasil" title="König Brasil" />
 
<?php if ( $user->first_name != '' ) : ?>
<h1>Olá, <?php echo $user->first_name . ' ' . $user->last_name; ?></h1>
<?php else : ?>
<h1>Olá Promotor</h1>
<?php endif; ?>

<h2>Seja bem vindo a König Brasil</h2>

<p>Acesse agora mesmo à <b><a href="<?php echo $siteUrl; ?>">Área Restrita de Agenda de Visitas</a></b></p>

<p>
	<b>Seus dados de acesso são:</b>
	<br><br>
	<i>E-mail:</i> <?php echo $user->user_email; ?>
	<br>
	<i>Senha:</i> <?php echo $plaintext_pass; ?>
</p>

<br><br>

<p>Atenciosamente,<br>Equipe König Brasil</p>
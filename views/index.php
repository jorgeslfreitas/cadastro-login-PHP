<?php \Classes\ClassLayout::setHead('Homepage', 'Essa é a home page do nosso site.'); ?>

 

<h1>Home Page</h1>
<br><br>
<a href="<?php echo DIRPAGE.'cadastro';?>">Cadastro</a>
<br><br>
<a href="<?php echo DIRPAGE.'login'; ?>">Login</a>
<br><br>
<a href="<?php echo DIRPAGE.'esqueci-minha-senha'; ?>">Esqueci minha senha</a>

<?php \Classes\ClassLayout::setFooter(); ?>
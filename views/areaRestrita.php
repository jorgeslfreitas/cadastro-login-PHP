<?php \Classes\ClassLayout::setHeadRestrito("user"); ?>

<?php \Classes\ClassLayout::setHead('Área Restrita', 'Exclusivo para membros cadastrados.'); ?>

<h1>Área Restrita</h1>

<a href="<?php echo DIRPAGE.'controllers/controllerLogout'; ?>">Sair</a>

<?php \Classes\ClassLayout::setFooter(); ?>
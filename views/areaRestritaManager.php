<?php \Classes\ClassLayout::setHeadRestrito("manager"); ?>

<?php \Classes\ClassLayout::setHead('Área Restrita', 'Exclusivo para membros cadastrados.'); ?>

<h1>Área de gerenciamento</h1>
<p>Área exclusiva para o gerenciamento do sistema</p>

<a href="<?php echo DIRPAGE.'controllers/controllerLogout'; ?>">Sair</a>

<?php \Classes\ClassLayout::setFooter(); ?>
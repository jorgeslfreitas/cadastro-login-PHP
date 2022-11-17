<?php \Classes\ClassLayout::setHead('Redefinição de senha', 'Redefina sua senha!'); ?>

    <div class="topFaixa float w100 center">
        Redefinição de senha
    </div>

    <div class="retornoSen float w100 center"></div>

    <form name="formRedSenha" id="formRedSenha" action="<?php echo DIRPAGE.'controllers/controllerConfirmacaoSenha';?>" method="post">
        <div class="cadastro float center">
            <input class="float w100 h40" type="email" id="email" name="email" value="<?php echo \Traits\TraitParseUrl::parseUrl(1); ?>" required>
            <input class="float w100 h40" type="text" id="token" name="token"  value="<?php echo \Traits\TraitParseUrl::parseUrl(2); ?>" required>
            <input class="float w100 h40" type="password" id="senha" name="senha" placeholder="Senha:" required>
            <input class="float w100 h40" type="password" id="senhaConf" name="senhaConf" placeholder="Confirmação da Senha:" required>
            <input class="float w100 h40" type="hidden" id="g-recaptcha-response" name="g-recaptcha-response" required>
            <input class="inlineBlock h40" type="submit" name="cadastrar" value="Cadastrar Nova Senha">
        </div>
    </form>


<?php \Classes\ClassLayout::setFooter(); ?>
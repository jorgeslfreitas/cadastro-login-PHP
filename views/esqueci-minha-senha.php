<?php \Classes\ClassLayout::setHead('Esqueci minha senha', 'Recupere sua senha.'); ?>

    <div class="topFaixa float w100 center">
        Esqueci minha senha
    </div>

    <div class="retornoSen float w100 center">
        Feedback
    </div>

    <form name="formSenha" id="formSenha" action="<?php echo DIRPAGE.'controllers/controllerSenha';?>" method="post">
        <div class="cadastro float center">
            <input class="float w100 h40" type="email" id="email" name="email" placeholder="Email:" required>
            <input class="float w100 h40" type="text" id="dataNascimento" name="dataNascimento" placeholder="Data de Nascimento:" required>
            <input class="float w100 h40" type="hidden" id="g-recaptcha-response" name="g-recaptcha-response" required>
            <input class="inlineBlock h40" type="submit" name="cadastrar" value="Solicitar">
        </div>
    </form>


<?php \Classes\ClassLayout::setFooter(); ?>
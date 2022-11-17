//Máscaras dos formulários
$('#cpf , #dataNascimento').on('focus', function () {
    var id=$(this).attr("id");
    if(id == "cpf"){VMasker(document.querySelector("#cpf")).maskPattern("999.999.999-99");}
    if(id == "dataNascimento"){VMasker(document.querySelector("#dataNascimento")).maskPattern("99/99/9999")};
});

//Retorno do root
function getRoot()
{
    var root="http://"+document.location.hostname+"/cadastro-login/";
    return root;
}

function getCaptcha()
{
    grecaptcha.ready(function() {
        grecaptcha.execute('SITEKEY EMITIDO PELO SITE DO GOOGLE CAPTCHA', {action: 'homepage'}).then(function(token){
            const gRecaptchaResponse=document.querySelector("#g-recaptcha-response").value=token;
        });
    });

}
getCaptcha();

//Ajax do formulário de cadastro
$('#formCadastro').on('submit',function(event){
    event.preventDefault();
    var dados=$(this).serialize();

    $.ajax({     
        url: getRoot()+'controllers/controllerCadastro',
        type:'post',
        dataType:'json',
        cache: false,
        processData: false,
        data: dados,
        success:function(response){
            $('.retornoCad').empty();
            if(response.retorno == 'erro'){
                getCaptcha();
                $.each(response.erros,function(key,value){
                $('.retornoCad').append(value+'<br>');
                
            });
                
            }else{
                alert("Dados inseridos com sucesso!");
                window.location.href=getRoot()+'login';
            }
        }   
    });
});

//Ajax do formulário de login
$('#formLogin').on('submit',function(event){
    event.preventDefault();
    var dados=$(this).serialize();

    $.ajax({     
        url: getRoot()+'controllers/controllerLogin',
        type:'post',
        dataType:'json',
        cache: false,
        processData: false,
        data: dados,
        success:function(response){
            if(response.retorno == 'success'){
                window.location.href=getRoot()+'areaRestrita';
            }else{
                getCaptcha();
                if(response.tentativas == true){
                    $('.loginFormulario').hide();
                }
                $('.resultadoForm').empty();
                $.each(response.erros,function(key,value){
                    $('.resultadoForm').append(value+'<br>');
                });
                
            }
        }   
    });
});

//Ajax do formulário de confirmação de senha
$("#formSenha").on("submit",function(event){
    event.preventDefault();
    var dados=$(this).serialize();

    $.ajax({
        url: getRoot()+'controllers/controllerSenha',
        type: 'post',
        dataType: 'json',
        data: dados,
        success: function (response) {
            if(response.retorno == 'success'){
                $('.retornoSen').html("Redefinição de senha enviada com sucesso!");
            }else{
                getCaptcha();
                $('.retornoSen').empty();
                $.each(response.erros,function(key,value){
                    $('.retornoSen').append(value+'');
                });
            }
        }
    });
});

//CapsLock página de cadastro
$("#senha, #senhaConf").keypress(function(e){
    kc=e.keyCode?e.keyCode:e.which;
    sk=e.shiftKey?e.shiftKey:((kc==16)?true:false);
    if(((kc>=65 && kc<=90) && !sk)||(kc>=97 && kc<=122)&&sk){
        $(".retornoCad").html("Caps Lock Ligado");
    }else{
        $(".retornoCad").empty();
    }
});

//CapsLock página de login
$("#senha").keypress(function(e){
    kc=e.keyCode?e.keyCode:e.which;
    sk=e.shiftKey?e.shiftKey:((kc==16)?true:false);
    if(((kc>=65 && kc<=90) && !sk)||(kc>=97 && kc<=122)&&sk){
        $(".resultadoForm").html("Caps Lock Ligado");
    }else{
        $(".resultadoForm").empty();
    }
});
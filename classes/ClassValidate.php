<?php

namespace Classes;

use Models\ClassCadastro;
use Classes\ClassPassword;
use Models\ClassLogin;
use Classes\ClassMail;

class ClassValidate {
    private $erro=[];
    private $cadastro;
    private $password;
    private $login;
    private $tentativas;
    private $session;
    private $mail;

    public function __construct()
    {
        $this->cadastro=new ClassCadastro();
        $this->password=new ClassPassword();
        $this->login=new ClassLogin();
        $this->session=new ClassSession();
        $this->mail=new ClassMail();


    }

    #Retorno do atributo erro
    public function getErro()
    {
        return $this->erro;
    }

    #Atribuir uma mensagem ao fim do array erro
    public function setErro($erro)
    {
        array_push($this->erro,$erro);
    }
    
    #Validar se os campos desejados foram preenchidos
    public function validateFields($par)
    {
        $i=0;
        foreach ($par as $key => $value){
            if(empty($value)){
                $i++;
            }
        }
        if($i==0){
            return true;
        }else{
            $this->setErro("Preencha todos os dados!");
            return false;
        }
    }

    #Validação se o dado é um email 
    public function validateEmail($par)
    {
        if(filter_var($par, FILTER_VALIDATE_EMAIL)){
            return true;
        }else{
            $this->setErro("Email inválido!");
            return false;
        }
    }

    #Validação se o email existe no banco de dados (action null para cadastro)
    public function validateIssetEmail($email,$action=null)
    {
        $b=$this->cadastro->getIssetEmail($email);

        if($action==null){
            if($b > 0){
                $this->setErro("Email já cadastrado!");
                return false;
            }else{
                return true;
            }
        }else{
            if($b > 0){
                return true;
            }else{
                $this->setErro("Email não cadastrado!");
                return false;
            }
        }
    }

    #Validação se o dado é uma data
    public function validateData($par)
    {
        $data=\DateTime::createFromFormat("d/m/Y",$par);
        if(($data) && ($data->format("d/m/Y") === $par)){
            return true;
        }else{
            $this->setErro("Data Inválida!");
            return false;
        }
    }

    #Validação se a data é igual adata do banco de dados - usado em redefinição de senha
    public function validateDataNascimento($dataNascimento, $email)
    {
        $dataDb=$this->login->getDataUser($email);
        if(isset($dataDb["data"]["dataNascimento"])){
            if($dataNascimento == $dataDb){
                return true;
            }else{
                $this->setErro("Data de nascimento não confere com a data de nascimento do usuário");
                return false;
            }    
        }
    }

    #Validação para determinar um CPF real
    public function validateCpf($par)
    {
        $cpf = preg_replace('/[^0-9]/', '', (string) $par);

        // Valida tamanho
        if (strlen($cpf) != 11){
            $this->setErro("CPF Inválido!");
            return false;
        }

        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            $this->setErro("CPF Inválido!");
            return false;
        }

        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                $this->setErro("CPF Inválido!");
                return false;
            }
        }
        return true;
    }

    #Validação se o cpf existe no banco de dados (action null para cadastro)
    public function validateIssetCpf($cpf,$action=null)
    {
        $b=$this->cadastro->getIssetCpf($cpf);
    
        if($action==null){
            if($b > 0){
                $this->setErro("CPF já cadastrado!");
                    return false;
                }else{
                    return true;
                }
            } 
    }       


    #Verificar se a senha é igual a confirmação de senha
    public function validateConfSenha($senha,$senhaConf)
    {
        if($senha === $senhaConf){
            return true;
        }else{
            $this->setErro("Senha diferente de confirmação de senha!");
        }
    }

    #Verificar a força da senha
    public function validateStrongSenha($senha)
    {
        $compSenha = '$\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$';
        if (preg_match_all($compSenha, $senha)){
            #echo "Senha forte";
            return true;
        }else{
            $this->setErro("Utilize uma senha mais forte!");
            return false;
            
        }          
    }

    #Verificação da senha digitada com o hash no banco de dados
    public function validateSenha($email,$senha)
    {
        if($this->password->verifyHash($email,$senha)){
            return true;
        }else{
            $this->setErro("Usuário ou Senha Inválidos!");
            return false;
        }
    }

    #Verificar se o captcha está correto
    public function validateCaptcha($captcha,$score=0.5)
    {
        $return=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".SECRETKEY."&response={$captcha}");
        $response=json_decode($return);
        if($response->success == true && $response->score >= $score){
            return true;
        }else{
            $this->setErro("Captcha Inválido! Atualize a página e tente novamente.");
        }
    }

    #Validação final do cadastro
    public function validateFinalCad($arrVar)
    {
        if (count($this->getErro()) > 0){
            $arrResponse=[
                "retorno"=>"erro",
                "erros"=>$this->getErro()
            ];
        }else{
            /*
            $this->mail->sendMail(
                $arrVar['email'],
                $arrVar['nome'],
                $arrVar['token'],
                "Confirmação de Cadastro",
                "<strong>Cadastro do Site - Doador RP</strong><br>
                Confirme seu email <a href='".DIRPAGE."controllers/controllerConfirmacao/{$arrVar['email']}/{$arrVar['token']}'>clicando aqui</a>."
            );
            */
            $arrResponse=[
                "retorno"=>"success",
                "erros"=>null
            ];
            $this->cadastro->insertCad($arrVar);
        }

        return json_encode($arrResponse);
    }

    #Validação das tentativas de login
    public function validateAttemptLogin()
    {
        if($this->login->countAttempt() >= 5){
            $this->setErro("Você realizou mais de 5 tentativas");
            $this->tentativas=true;
            return false;
        }else{
            $this->tentativas=false;
            return true;
        }
    }

    #Método de validação de confirmação de email
    public function validateUserActive($email)
    {
        $user=$this->login->getDataUser($email);
        if(isset($user["data"]["status"])){
            if($user["data"]["status"] == "confirmation"){
            if(strtotime($user["data"]["dataCriacao"]) <= strtotime(date("Y-m-d H:i:s"))-432000){
                $this->setErro("Ative seu cadastro pelo link do email");
                return false;
            }else{
                return true;
            }
            }else{
                return true;
            }
        }
        
    }

    #Validação final do login
    public function validateFinalLogin($email)
    {
        if(count($this->getErro()) > 0){
            $this->login->insertAttempt();
            $arrResponse=[
                "retorno"=>"erro",
                "erros"=>$this->getErro(),
                "tentativas"=>$this->tentativas
            ];    
        }else{
            $this->login->deleteAttempt();
            $this->session->setSessions($email);
            $arrResponse=[
                "retorno"=>"success",
                "pages"=>'areaRestrita',
                "tentativas"=>$this->tentativas
            ];
        }

        return json_encode($arrResponse);
    }

    #Validação final de recuperação de senha
    public function validateFinalSen($arrVar)
    {
        if (count($this->getErro()) > 0){
            $arrResponse=[
               "retorno"=>"erro",
                "erros"=>$this->getErro()
            ];
        }else{
                /*
                $this->mail->sendMail(
                    $arrVar['email'],
                    $arrVar['nome'],
                    $arrVar['token'],
                    "Link para Confirmação de Senha",
                    "<strong>Redefinição de senha - Doador RP</strong><br>
                    Redefina sua senha <a href='".DIRPAGE."redefinicaoSenha/{$arrVar['email']}/{$arrVar['token']}'>clicando aqui</a>."
                );
                */
            $arrResponse=[
                "retorno"=>"success",
                "erros"=>null
            ];
            $this->cadastro->insConfirmation($arrVar);
        }
    
        return json_encode($arrResponse);
    }

}


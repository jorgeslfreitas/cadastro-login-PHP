<?php
$session=new Classes\ClassSession();
$session->destructSessions();
echo "<script>
    alert('Você efetuou o logout!');
    window.location.href='".DIRPAGE."';
</script>";
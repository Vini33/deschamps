<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <title>jogo felipe</title>
</head>
<body>

    <nav>
    </nav>

    <canvas width="20" height="20"></canvas>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="jogo.js" type="module"></script>
    <?php
        include_once "conect.php";
        session_start();

        $banco = new Banco();
        $pontos = $banco->NomePontos();
        //print_r($pontos);

        echo "<table>";
        echo "<tr>";
        echo "<th>Top 10 Jogadores</th>";
        echo "<th>pontos</th>";
        echo "</tr>";

        foreach($pontos as $key => $val){
    
            if($val['user_id'] == session_id()){
                echo "<tr>";
                echo "<td style='color:#F0DB4F'>";
                echo $val['user_id'];
                echo " - ";
                echo $val['pont'];
                echo "</td>";
                echo "</tr>";
            }else{
                echo "<tr>";
                echo "<td>";
                echo $val['user_id'];
                echo " - ";
                echo $val['pont'];
                echo "</td>";
                echo "</tr>";
            }
    
        }
        echo "</table>";

        //setando a horario para o horario brasileiro
        date_default_timezone_set('America/Sao_Paulo');
        $data = date("Hi");
        $_SESSION['user_id'] = session_id();
        $result = $banco->refresh(session_id());

        //to dizendo que se o id do player nao tiver cadastrado, cadastra player
        if($result == ''){
            $banco->cadastra(session_id(), rand(0, 19),rand(0,19),$data,$data);
        }

        //fazer parte do admin
        if($_SERVER['QUERY_STRING'] == 'admin=vini'){
            echo "<div>";
            echo "<form action='' method='post'>
                    <input type='number' value='1' name='numerofruit' id='numero'>
                    <button name='ok' id='ok'>ok</button>
                </form>";
            echo "</div>";
        }
        if(isset($_POST['ok'])){
            //echo 'sim';
        }
        
 
    ?>
</body>
</html>
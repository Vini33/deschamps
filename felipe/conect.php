<?php


class Banco{

    public function __construct(){
        $this->banco = new PDO("mysql:host=localhost;dbname=mult","root","");
        $this->valores = array();
    }

    public function ValidaPos(){
        //verificando se existe alguma fruta na tabela de maca
        $pro = $this->banco->prepare("SELECT COUNT(id) FROM maca");
        $pro->execute();
        $result = $pro->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function MacaPosicao(){
        //posicao e id da fruta pra fazer com colisao
        $pos = $this->banco->prepare("SELECT id, p_x,p_y FROM maca");
        $pos->execute();
        $result = $pos->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function PosMaca($x,$y){
        //inserindo frutas 
        $eu =$this->ValidaPos();
        if($eu['COUNT(id)'] == 0){
            $pro = $this->banco->prepare("INSERT INTO maca(p_x,p_y) VALUES (:X,:Y)");
            $pro->bindValue(":X",$x);
            $pro->bindValue(":Y",$y);
            $pro->execute();
            //print_r($result);
        }
    }

    public function RemoverFruit($id){
        $pos = $this->banco->prepare("DELETE FROM maca WHERE id = :ID");
        $pos->bindValue(":ID",$id);
        $pos->execute();
    }

    public function PontosPlay($id){
        //inserindo pontos do player
        $pro = $this->banco->prepare("UPDATE player SET pont = pont + 1 WHERE user_id = :ID");
        $pro->bindValue(":ID",$id);
        $pro->execute();
    }

    public function MacaPos(){
        //posicao da maca e id junto
        $pos = $this->banco->prepare("SELECT id,p_x,p_y FROM maca");
        $pos->execute();
        $result = $pos->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function PlayPosicao($id){
        $pos = $this->banco->prepare("SELECT pos_x,pos_y FROM player WHERE user_id = :ID");
        $pos->bindValue(":ID",$id);
        $pos->execute();
        $result = $pos->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function colisao(){
        $maca = $this->MacaPosicao();
        $play = $this->PlayPosicao($_SESSION['user_id']);
        foreach($maca as $key => $value){
            foreach($play as $keyy => $val){
                if($value['p_x'] == $val['pos_x'] && $value['p_y'] == $val['pos_y']){
                    $this->PontosPlay($_SESSION['user_id']);
                    $this->RemoverFruit($value['id']);
                }
            }
        }
    }

    public function valor($id){
        //pegando posicao do jogador
        $pro = $this->banco->prepare("SELECT pos_x, pos_y FROM player WHERE user_id = :ID");
        $pro->bindValue(":ID",$id);
        $pro->execute();
        $result = $pro->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function cadastra($id, $x,$y,$dd,$lo){
        $pro = $this->banco->prepare("INSERT `player` (`user_id`,`pos_x`,`pos_y`,`data`,`logado`, `pont`) VALUES (:ID, :X,:Y,:DD, :LO,:PONT)");
        $pro->bindValue(":ID",$id);
        $pro->bindValue(":X",$x);
        $pro->bindValue(":Y",$y);
        $pro->bindValue(":DD",$dd);
        $pro->bindValue(":LO",$lo);
        $pro->bindValue(":PONT",0);
        $pro->execute();
    }

    public function refresh($valor){
        //verificando se o player ja existe pra nao ser adicionado novamente
        $pro = $this->banco->prepare("SELECT user_id FROM player WHERE user_id = :VALOR");
        $pro->bindValue(":VALOR",$valor);
        $pro->execute();
        $result = $pro->fetch(PDO::FETCH_ASSOC);
        //print_r($result);
        return $result;
    }

    public function Players(){
        //onde pego posicao do playe e da maca pra retorna pra ser redenrizado
        $pro = $this->banco->prepare("SELECT user_id, pos_x,pos_y,pont FROM player");
        $pro->execute();
        $result = $pro->fetchAll(PDO::FETCH_ASSOC);
        array_push($this->valores, $result, $this->MacaPos());
        echo json_encode($this->valores);
    }
    public function att($tecla, $id, $data){
        //atualiza posicao do player
        $qual = array(
            "ArrowUp" => function(){
                return $this->banco->prepare("UPDATE `player` SET `pos_y`= pos_y - 1, data = :D WHERE user_id = :ID AND (pos_y > 0)");
            },
            "ArrowRight" => function(){
                return $this->banco->prepare("UPDATE `player` SET `pos_x`= pos_x + 1, data = :D WHERE user_id = :ID AND (pos_x < 19)");
            },
            "ArrowLeft" => function(){
                return $this->banco->prepare("UPDATE `player` SET `pos_x`= pos_x - 1, data = :D WHERE user_id = :ID AND (pos_x > 0)");
            },
            "ArrowDown" => function(){
                return $this->banco->prepare("UPDATE `player` SET `pos_y`= pos_y + 1, data = :D WHERE user_id = :ID AND (pos_y < 19)");
            });
            $pro = $qual[$tecla]();
            $pro->bindValue(":ID",$id);
            $pro->bindValue(":D",$data);
            $pro->execute();
                        
    }
    public function data($data){
        //pegando a data do player
        $pro = $this->banco->prepare("SELECT data FROM player WHERE user_id = :ID");
        $pro->bindValue(":ID", $data);
        $pro->execute();
        $result = $pro->fetchAll(PDO::FETCH_ASSOC);
        return $result[0]['data'];
    }
    public function remove($dd){
        //removendo player pelo tempo que ficou parado
        $pro = $this->banco->prepare("DELETE FROM `player` WHERE IF(:DD - data >= 2,1,0) ");
        $pro->bindValue(":DD",$dd);
        $pro->execute();
    }
    public function NomePontos(){
        $pos = $this->banco->prepare("SELECT user_id, pont FROM player");
        $pos->execute();
        $result = $pos->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

}
//new Banco();

?>
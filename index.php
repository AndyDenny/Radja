<?php
//RadJa
/*
$txtarea =  $_REQUEST["namesfiles"];
$arLinks = explode(',',$txtarea);

if ($arLinks[0]){    
    foreach ($arLinks as $k=>$link){        
        if (strlen($link) > 4){            
            $link = trim($link);
            if ( stripos ($link , $_SERVER["HTTP_HOST"]) != -1){
                $link = explode($_SERVER["HTTP_HOST"], $link)[1];
                $link = ltrim (  $link ,   "/" );
            }
            elseif ( $link[0] =="/"){
                   $link = ltrim (  $link ,   "/" );
            }
            $flsz = filesize($link);
            copy($link,$link."-orig");      
            $arSize = getimagesize($link);
            $arLinkInfo[$k]["origfilesize"] = $flsz;
            $arLinkInfo[$k]["url"] = $link;
            $arLinkInfo[$k]["w"] = $arSize[0];
            $arLinkInfo[$k]["h"] = $arSize[1];
            $arLinkInfo[$k]["t"] = explode("/",$arSize["mime"])[1];        
        }            
    }
}

if ($arLinkInfo){
    foreach ($arLinkInfo as $k=>$link){
        $quality = 60;
        $pngquality = 6;
        $type = $link["t"];
        switch ($type) {
            case 'jpeg':
            case 'jpg':
            case 'JPG':
                $resizeimg = imagecreatefromjpeg ($link["url"]);
                imagejpeg($resizeimg,$link["url"],$quality);
                $arLinkInfo[$k]["newsize"] = filesize($link["url"]);        
                break;
            case 'png':
            case 'PNG':
                $resizeimg = imagecreatefrompng ($link["url"]);
                imagepng($resizeimg,$link["url"],$pngquality);
                $arLinkInfo[$k]["newsize"] = filesize($link["url"]);
                break;
            case 'gif':
            case 'GIF':
                $resizeimg = imagecreatefromgif ($link["url"]);
                imagegif($resizeimg,$link["url"],$quality);
                $arLinkInfo[$k]["newsize"] = filesize($link["url"]);
                break;    
            default:
                echo $link["url"]." - unknown format.";
                break;
        }
    }
}*/

class Radja
{

    public function mess ($vari){
        /**
        * print instans variable
        */
            echo $vari;
    }

  
    public function linksInfo(){

        $txtarea =  $_REQUEST["namesfiles"];
        $arLinks = explode(',',$txtarea);
        file_put_contents("./linksarray.txt",$arLinks);

        if ($arLinks[0]){    
            foreach ($arLinks as $k=>$link){        
                if (strlen($link) > 4){            
                    $link = trim($link);
                    if ( stripos ($link , $_SERVER["HTTP_HOST"]) != -1){
                        $link = explode($_SERVER["HTTP_HOST"], $link)[1];
                        $link = ltrim (  $link ,   "/" );
                    }
                    elseif ( $link[0] =="/"){
                        $link = ltrim (  $link ,   "/" );
                    }
                    $flsz = filesize($link);                         
                    $arSize = getimagesize($link);
                    $arLinkInfo[$k]["origfilesize"] = $flsz;
                    $arLinkInfo[$k]["url"] = $link;
                    $arLinkInfo[$k]["w"] = $arSize[0];
                    $arLinkInfo[$k]["h"] = $arSize[1];
                    $arLinkInfo[$k]["t"] = explode("/",$arSize["mime"])[1];        
                }            
            }
        }
        return $arLinkInfo;
    }

    public function makeBackupLinks(){
            if (file_exists("./linksarray.txt")){
                    $arLinks = file("./linksarray.txt");
                    if ( count($arLinks)>0 ){
                        
                        foreach ($arLinks as $link){
                            copy($link,$link."-orig"); 
                        }

                        echo "Backups - done.";
                    }else{
                        echo "Ссылки на файлы отсутствуют";
                        return false;
                    }
            }else{
                echo "Файл ссылок отсутствует";
                return false;
                
            }
    }

}


$ra = new Radja();

//$linki = $ra->linksInfo();

print_r($_POST);
?>
<meta charset="utf-8">
<form action="" method="post">
Список ссылок для картинок Gif, Jpg, Png <br>
Не проверен для работы ссылками с пробелом и на русском<br>
Ссылки ввводятся без названия домена, без слеша в начале, через запятую<br>
<textarea placeholder="put links of files there" name="namesfiles" id="namesfiles" cols="89" rows="5">
</textarea>
<br>
<button type="submit">GO</button>
</form>

<div class="arlinks">
<?if($arLinkInfo){
    foreach($arLinkInfo as $linkInfo):
    ?>
<div class="link"><?=$linkInfo["url"]?> | <br>Ширина\высота: <span><b><?=$linkInfo["w"]?></b></span>x<span><?=$linkInfo["h"]?> | <br>Вес старый\новый: </span><u><?=$linkInfo["origfilesize"]?></u> =-= <span><i><?=$linkInfo["newsize"]?></i></span> </div>
<br>
<?
endforeach;
}?>
</div>
<style>
body{
    background-color: #edf1cb;
}
.link,textarea,button{
    padding: 15px;
    border: 1px solid gray;
    border-radius: 5px;
    background-color: #ebf1bc;
}
button{
    background-color: lightgreen;
    color:  gray;
    font-weight:600;
}
button:hover{
    cursor: pointer;
    box-shadow: 0px 0px 5px gray;
    color: black;
    background-color: green;
}
.link{
    width: 50%;
}
.hide{
    display: none;
}
</style>
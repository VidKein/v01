<?php 
   //подключаем базу mysql_kv
   require_once $location_serv."functions/functions.php";
    //выводим информацию о всех картинках
    $single = get_single_img();//выводим картинки
    //выводим информацию о картинка по категориям из Б/Д
    $id_cat = category_id($categories);
    //Запрос - номер
    $request = read_request();
    //Название раздела
    $categori_name_request = NameCategory($request);
?>
    <link rel="stylesheet" href="/css/slider.css"><!--стили плагина slick-слайдер-->
    <link href="/fonts/fontawesome/css/all.min.css" type="text/css" rel="stylesheet"><!--Подключаем Font awesome 5/Иконки-->
    <link rel="stylesheet" href="/css/slick/slick.css"/><!--Подключаем библиотеку slick-слайдер-->
    <link rel="stylesheet" href="/css/slick/slick-theme.css"/><!--Подключаем темы slick-слайдер-->
    <script src="/script/jquery/jquery-3.5.1.min.js"></script><!--Подключаем jquery-3.5.1/анимация кнопок-->
    <script src="/script/fullccrin/jquery.fullscreen.min.js"></script><!--Плагин fullccrin-->
    <script src="/script/anime/anime.js"></script><!--Подключаем скрипт с анимацией-->
    <script src="/script/slick/slick.js"></script><!--Скрипт slick-слайдер-->
    <script src="/script/slick/js/js.js"></script><!--Параметры slick-слайдер-->
    <script src="/script/social/social.js"></script><!--Подключение социальных сетей-->
<!--Страница слайдера-->
<section id="fullscreen_slider" class="slider">
 <div class="SingleImage">
  <div class="imegen">
        <div class="sl">
            <?php
            if ($categories == 'all' || $request == null) {//выводим картинки ВСЕ
                foreach ($single as $info_img):
                    $adress = $info_img["url_1200"];
                    $adress_correction = ltrim($adress , " ../ ");//убирает точки перед URL адрессом
                    $info=getimagesize($adress_correction);//вычитываем информацию из картинки
                    ?>
                <div class="sl_slade">
                        <img class="sl_img" data-lazy = "<?php echo $adress_correction;//вычитка с базы?>" alt="" <?php echo $info["3"];//размер картинки?> title="<?= $info_img['short_description']?>">
                </div>
                <?php endforeach;        
            } elseif($categories == $request){//Подгрузка по категориям используя запросы
                foreach ($id_cat as $info_img):
                    $adress = $info_img["url_1200"];
                    $adress_correction = ltrim($adress , " ../ ");//убирает точки перед URL адрессом
                    $info=getimagesize($adress_correction);//вычитываем информацию из картинки
                    ?>
                <div class="sl_slade">
                        <img class="sl_img" data-lazy = "<?php echo $adress_correction;//вычитка с базы?>" alt="" <?php echo $info["3"];//размер картинки?> title="<?= $info_img['short_description']?>">                        
                </div>
                <?php endforeach;
            }
            ?>
        </div>   
    </div>
 </div>
 <div class="controlsMini">
    <div class="infoTextMini">
        <p id ="name"></p>
        <p id ="description"></p>
    </div>
    <div class="countBlocMini">
        <button class="backwardMini" title="Предыдушее фото"><</button>
          <span class="namberMini" id = "namberMini"></span>
           <span class="flasMini">/</span>
          <span class="ofNamberMini"><?php $namber_all = ALLroow($categories); echo($namber_all);?></span>
        <button class="forwardMini" title="Следуюшее фото">></button>
        <button id="play_metca" class="playMini" style="display: block;" title="Проигрывать"><span class="churchMini"><i class="fas fa-play fa-sm"></i></span></button>
            <button class="stopMini" style="display: none;"  title="Остановить"><span class="churchMini"><i class="fas fa-pause-circle fa-sm"></i></span></button>
        <button class="requestfullscreenMini" style="display: block;" title="На весь экран"><span class="churchMini"><i id="closefull" class="fas fa-expand-arrows-alt fa-sm"></i></span></button>
            <button class="exitfullscreenMini" style="display: none;" title="На весь экран"><span class="churchMini"><i id="closefull" class="fas fa-compress-arrows-alt fa-sm"></i></span></button>
        <button class="socialMini" title="Поделится"><span class="churchMini"><i class="fas fa-share-alt fa-sm"></i></span></button>    
        <button class="infoMini" title="Информация о фото"><span class="churchMini"><i class="fas fa-info  fa-sm"></i></span></button>    
    </div>
 </div>
   <button onclick="document.location='/index.php?page=gallery&categories=<?= $request;?>'" class="close" title="Выйти из просмотра"><i class="fas fa-times"></i></button>
   <button class="transition"><i id="rotate" class="fas fa-angle-double-right" title="Скрыть информационную панель"></i></button>
 <div class="infoSection">
    <section class="info-foto">
        <button class="backward" title="Предыдушее фото"><i class="fas fa-arrow-left"></i></button>
        <button class="forward" title="Следуюшее фото"><i class="fas fa-arrow-right"></i></button>    
        <div class="count">
        <span id = "namber" ></span> / <span><?php $namber_all = ALLroow($categories); echo($namber_all);?></span>
        </div>
        <!--Название раздела + количество картинок-->
        <h1 class="name-foto"> <?php
            if ($request == 'all') {?>
                <span><?= 'Все фото';?></span><?php
                $namber_all = ALLroow($categories); echo " : ".$namber_all;
            } else {
                foreach ($categori_name_request as $Name) {?>
                   <span><?= $Name['name'];?></span>
                    <?php $namber_all = ALLroow($categories);echo " : ".$namber_all;
                }
            }?></h1>
        <!--Информация о картинках--> 
        <div class="blokInfoFoto">   
        <?php
        if ($categories == 'all' || $request == null) {//выводим информация о ВСЕХ картинках
            foreach ($single as $key=>$info):?>
            
                <div class="content-foto" index="<?= $key?>" style="display: none;">
                    <p><?= $info['name']?></p><!--name-->
                    <p ><?= $info['description']?></p><!--description--> 
                </div>
            
            <?php endforeach;
        } elseif($categories == $request){//Подгрузка информациb о картинках по категориям используя запросы
            foreach ($id_cat as $key=>$info):?>
            <div class="blokInfoFoto">
                <div class="content-foto" index="<?= $key?>" style="display: none;">
                    <p><?= $info['name']?></p><!--name-->
                    <p><?= $info['description']?></p><!--description-->
                </div>
            
            <?php endforeach;
        }?>
        </div>
        <div class="functional">
            <button id="play_metca" class="play" style="display: block;" title="Проигрывать">Проигрывать <span class="church"><i class="fas fa-play"></i></span></button>
              <button class="stop" style="display: none;"  title="Остановить">Остановить <span class="church"><i class="fas fa-pause-circle"></i></span></button>
            <button class="requestfullscreen" style="display: block;" title="На весь экран">На весь экран<span class="church"><i id="closefull" class="fas fa-expand-arrows-alt"></i></span></button>
               <button class="exitfullscreen" style="display: none;" title="На весь экран">На весь экран<span class="church"><i id="closefull" class="fas fa-compress-arrows-alt"></i></span></button>
            <button class="social" title="Поделится">Поделится<span class="church"><i class="fas fa-share-alt"></i></span></button>
        </div>
    </section>
 </div>
     <!--Поделиться изображением-->    
     <section class="appearance_social">
       <div class="holder_social">
           <div class="holder_content" id="social_metca">
               <button class="close_social" title="Выйти из поделится"><i class="fas fa-times"></i></button>
               <h1>Поделиться этим изображением</h1>
               <form onsubmit="return false;//приостанавливаем перезагрузку страницы">
                    <label class="form-control-value">Ссылка*</label>
                    <input id="result"  type="text" value="" readonly>
                    <button onclick="copyToClipboard('result')" title="Скопировать ссылку" class="preparation_form_value"><i class="far fa-copy"></i></button>
                    <div class="validation-feedback"></div>
               </form>
               <form>
                   <label class="form-control-email">Электронный адресс*</label>
                   <input type="email" required placeholder="Введите адрес электронной почты" id="name_mail_dispatch"  class ="name_mail_dispatch" value="">
                   <button type="submit" class="preparation_form_mail" title="Поделиться по электронной почте"><i class="far fa-envelope"></i></button>
                   <div class="email-feedback"></div>
               </form>
               <ul class="options_social">
                   <li><a href="#" data-pin-do="buttonPin" data-pin-count="above" onclick="return addSoc('pinterest');" class="pinterest" title="pinterest"><i class="fab fa-pinterest-p"></i></a></li>
                   <li><a href="#" onclick="return addSoc('facebook');" class="facebook" title="facebook"><i class="fab fa-facebook-f"></i></a></li>
                   <li><a href="#" onclick="return addSoc('twitter');" class="twitter" title="twitter"><i class="fab fa-twitter"></i></a></li>
               </ul>
           </div>
       </div>
    </section>
</section>
<script>
imgLoad();
addEventListener("resize",()=>{imgLoad();}) 

    function imgLoad() {
        let imgLoad = document.getElementsByTagName("img");
        for (let i = 0; i < imgLoad.length; i++) {
            const elementWidth = imgLoad[i].width;
            const elementHeight = imgLoad[i].height;
            
            if (elementWidth !== "" && elementWidth !== 200) {
                if (elementWidth > elementHeight) {
                    imgLoad[i].style.width = "100%"; 
                    imgLoad[i].style.height = "auto";
                } else {
                    if (document.documentElement.clientWidth >= 750) {
                        imgLoad[i].style.width = "auto"; 
                        imgLoad[i].style.height = window.innerHeight+"px";
                        document.querySelector(".imegen").setAttribute ("style", "border-top : null");
                    } else {
                        if (document.querySelector(".infoMini").className ==  "infoMini active") {
                            document.querySelector(".imegen").setAttribute ("style", "border-top : 0em solid transparent");
                            imgLoad[i].style.width = "auto"; 
                            imgLoad[i].style.height = (window.innerHeight-110)+"px";
                        } else {
                            document.querySelector(".imegen").setAttribute ("style", "border-top : 0em solid transparent");
                            imgLoad[i].style.width = "auto"; 
                            imgLoad[i].style.height = (window.innerHeight-53)+"px";;
                        }
                    }

                }
            }
        }   
    }
</script>
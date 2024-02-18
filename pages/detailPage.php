<?php //загрузка обшей информации
	require_once "functions/functions.php";
	if(isset($_GET['page'])) $page = $_GET['page'];
	$data_page = data_page_row($page);		
?>
<link rel="stylesheet" href="/css/detalePage.css">

<style>
    <?=".".$page."_block"?> > h1 {text-align: center; margin: 12px 0 10px 0;}
    <?=".".$page."_block"?> > p {text-align: center; margin: 5px 0;}
</style>

<div class="<?=$page?>_pages">
	<div class="<?=$page?>_block">
            <!--Шапка-->
            <?php if ($page == 'copyright') {?>
                <h1><?=$data_page -> name;?> / Авторские права</h1>
            <?php } else {?>
                <h1><?=$data_page -> name;?></h1>
                <h1><?= help_vars($array_settings,'text_main');?></h1>
                <p><?= help_vars($array_settings,'text_right');?></p>
            <?php }
            ?>
		<!--ФОТО/ТЕКСТ-->
        <?php if ($page == 'copyright') {?>
                <div class="<?=$page?>_discription"><?= $data_page -> description;?></div>
        <?php } else if($page == 'about') {?>
                <img class="<?=$page?>_page" alt="Мое фото" src="<?= $data_page ->img;?>">
                <div class="<?=$page?>_discription"><?= $data_page -> description;?></div>
            <?php } else {?>
                <div class="row">
                    <div class="col_left">
                        <img class="<?=$page?>_page"alt="Мое фото" src="<?= $data_page ->img;?>">
                        <div class="<?=$page?>_discription"><?= $data_page -> description;?></div>
                    </div>
                    <!--Блок обратной связи-->
                    <div class="col_right">
                    <form id="myForm" action="/functions/email_detailPage.php" method="post" role="form" name="myForm">
                     <!--Ваше имя-->
                          <div class="form-group has-feedback"> 
                            <label class="glyphicon form-control-feedback">Ваше имя<span>*</span></label>
                            <div class="input-gpup">
                              <input id="your_name"  type="text" name = "your_name" placeholder="Ваше имя (от 2 до 30 символов)" rows="2" minlength="2" maxlength="30" required value="">
                            </div>
                            <div class="invalid-feedback"></div>
                          </div>
                    <!--Ваш электронный адрес-->
                          <div class="form-group has-feedback">
                            <label class="glyphicon form-control-feedback">Ваш электронный адрес<span>*</span></label>
                            <div class="input-gpup">
                             <input id="email_contact"  type="email" name="email_contact" placeholder="Email-адрес" required value="" >
                            </div>
                            <div class="invalid-feedback"></div>
                          </div> 
                    <!--Тема сообщения-->
                          <div class="form-group has-feedback">  
                            <label class="glyphicon form-control-feedback">Тема сообщения<span>*</span></label>
                            <div class="input-gpup">
                             <input id="message" type="text" name="message" placeholder="Сообщение (от 5 до 50 символов)"  rows="5" maxlength="50" required value="">
                            </div>
                            <div class="invalid-feedback"></div>
                          </div>
                    <!--Cообщение-->      
                          <div class="form-group has-feedback"> 
                            <label class="glyphicon form-control-feedback">Сообщение<span >*</span></label>
                            <div class="input-gpup">
                              <textarea id="text_message" name="text_message" type="text" placeholder="Сообщение (от 5 до 500 символов)" rows="5" maxlength="500" required value=""></textarea>
                            </div>
                            <div class="invalid-feedback"></div>
                          </div>                            
                            <!--Блок для ввода кода CAPTCHA-->
                            <div class="form-group has-feedback" id="captcha">
                              <!--Изображение, содержащее код CAPTCHA-->
                              <img id="img-captcha" src="/captcha/captcha.php">  		  
                              <!--Элемент, запрашивающий новый код CAPTCHA-->
                              <div class="renewal">
                                  <button botton id="reload-captcha" type="button"><i class="fas fa-sync-alt"></i></button>
                              </div>
                                <label class="form-control-feedback" id="captcha-text">Пожалуйста, введите указанный на изображении код<span>*</span></label>
                                <input id="text-captcha" name="captcha" type="text" class="form_control" required maxlength="6" placeholder="******" value="">
                            </div>
                        </form>
                        <!-- Нижняя часть модального окна -->
                        <div class="modal-footer">
                          <a href="<?=$_SERVER['PHP_SELF'];?>?page=contact"><button type="button" title="Отменить">Отмена</button></a>
                          <button id="save" type="button" title="Отправить">Отправит</button>
                        </div>
                    </div>
                </div>
                <div class="alert alert-success hidden" id="success-alert">
                  <h2>Вы все заполнили правильно.</h2>
                  <div>Ваше письмо отправлено адресату.</div>
                  <div>В ближайшее время я постараюсь на него ответить.</div>
                  <div>С уважением Константин Видющенко.</div>
                  <a href="<?= $_SERVER['PHP_SELF'];?>" style="text-decoration: none;" title = "Нажмите для перехода на главную страницу">Нажмите для того чтобы перейти на главную страницу</a>
                </div>
  <?php
      }?>    
    </div>
</div>
<script src="/script/mail/mail_detailPage.js"></script>
//Убираем Информационную панель//Центрируем картинку//Поворот кнопки исчезнавения блока информации
$(document).ready(function() {
    var $transition = $('.transition');//выбирает по class кнопку скрытия инфо панели 
        $infoSection = $('.infoSection');//выбираем инфо секцию
		    $SingleImage = $('.SingleImage');//выбираем секцию картинок
		    $trans = $('#rotate');//выбирает по id знак << поворота

    $transition.click('click', function() {//нажимая кнопку исчезновения инфо секции
      $infoSection.toggleClass('hide');//меняем параметры infoSection->left: 75% --100%
      $SingleImage.toggleClass('center');//меняем параметры SingleImage->righ: 25% --15%
      $trans.toggleClass('fa-rotate-180');//добовляем поворот на 180 к знаку << поворота
    });
});
//Изменение кнопки проигрывателя
$(document).ready(function(){
  var $play = $(".play");//кнопка проигрывать
      $pausa = $(".stop");//кнопка пауза
          
      $play.click('click', function(){//убераем кнопку проигрывать -- показываем кнопку пауза
        $play.toggleClass('active');//маркер для отключения проигрывателя при открытых соц сетях
          $pausa.css({'display': 'block'});
          $play.css({'display': 'none'});
      });
    
      $pausa.click('click', function(){//убераем кнопку пауза -- показываем кнопку проигрывать
        $play.toggleClass('active');//маркер для отключения проигрывателя при открытых соц сетях
          $pausa.css({'display': 'none'});
          $play.css({'display': 'block'});
      });
  });
//Полноэкранный режим
$(function() {  
      // полноэкранном режиме
      $('#fullscreen_slider .requestfullscreen').click(function() {
        $('#fullscreen_slider').fullscreen();
        return false;
      });

      //выход из полноэкранного режима
      $('#fullscreen_slider .exitfullscreen').click(function() {
        $.fullscreen.exit();
        return false;
      });

      // событие документа---если необходимо привязать функцию к одной кнопке(создается две кнопки - одна есь-- другая скрывается и наоборот)
      $(document).on('fscreenchange', function() {
        //если мы сейчас в полноэкранном режиме
        if ($.fullscreen.isFullScreen()) {
          $('#fullscreen_slider .requestfullscreen').hide();
          $('#fullscreen_slider .exitfullscreen').show();
        } else {
          $('#fullscreen_slider .requestfullscreen').show();
          $('#fullscreen_slider .exitfullscreen').hide();
        }

      });
});
//Убираем/добавляем социальные сети+вставляем МЕТА-теги
let copyURL;
let img;
$(document).ready(function(){
  var $social = $(".appearance_social"); 
      $close = $(".close_social");
      $open = $(".social");
     
      $open.click('click', function(){//нажимая кнопку на открытие
        $social.css({'display': 'block'});//добавляем в display --> block
        $('.holder_content').toggleClass('active');//маркер для отключения кнопак клавиш на клавиатуре вправо/влево+пробел клавиатуры при открытых соц сетях
        if ($("#play_metca" ).hasClass('play active')) {//вычитываем маркер нажатия кнопки проигрывателя -- социальные сети
          $('.sl').slick('slickPause');//пауза автопроигрывателя -- когда у проигрывателя class=play active
         }
         //выводим адрес для скачивания
         copyURL = window.location.href;//вычитываем адрес с url
         document.getElementById('result').value = copyURL;
         //передаем в МЕТА ИНФОРМАЦИЮ
         document.querySelector('meta[property="og:url"]').setAttribute("content", copyURL);//передаем в МЕТА ссылку на саму веб-страницу, которая добавляется в социальную сеть      
         var src_img = $(".slick-active > img").attr( "src" );//вычитываем адрес картинки
         img = origin_web +"/" + src_img;//создаем путь - добовляем домен переменная origin_web 
         document.querySelector('meta[property="twitter:image:src"]').setAttribute("content", img);//передаем в МЕТА ссылку на картинку, которая должна сопровождать материал в twitter
         document.querySelector('meta[property="og:image"]').setAttribute("content", img);//передаем в МЕТА ссылку на картинку, которая должна сопровождать материал в других соц сетях
        //вычитываем информационный текст картинки и передаем в МЕТА
         $.each($("[style='display: block;'] > p"), function (index, value) { 
         if (index == 0) {document.querySelector('meta[property="og:title"]').setAttribute("content", ($(value).text()));}//выводим name
            else if (index == 1) {document.querySelector('meta[property="og:description"]').setAttribute("content", ($(value).text()));}//выводим description
          });
        //Размер картинки в соц сетях
        var img_new = new Image();
          img_new.onload = function() {
            var width_img = this.width;
            var height_img = this.height;
            document.querySelector('meta[property="og:image:width"]').setAttribute("content", width_img);
            document.querySelector('meta[property="og:image:height"]').setAttribute("content", height_img);
          }
        img_new.src = img;

      });
      $close.click('click', function(){//нажимая кнопку на закрытие
        $social.css({'display': 'none'});//добавляем в display --> none
        $('.holder_content').toggleClass('active');//маркер для отключения кнопак клавиш на клавиатуре вправо/влево+пробел клавиатуры при открытых соц сетях
        if ($("#play_metca" ).hasClass('play active')) {//вычитываем маркер нажатия кнопки проигрывателя -- социальные сети
          $('.sl').slick('slickPlay');//включаем автопроигрыватель когда у проигрывателя -- когда class=play active
        }
        //убираем информационные уведомления
        //меняем цвет названия форм
        $('.validation-feedback').empty();
        $('.email-feedback').empty();
        $(".form-control-value").css({'color':'black'});        
        $(".form-control-email").css({'color':'black'});        
      });
  });
  //Отключаем нажатие кнопки клавиш пробел на клавиатуре при открытых соц сетях
$(document).on('keydown',function (e) {
    var key = e.which;
        if ($('#social_metca' ).hasClass('holder_content active')) {
          if(key == 32){
            e.preventDefault();//Если будет вызван данный метод, то действие события по умолчанию не будет выполнено - К примеру, клик по ссылке не отправит пользователя по новому URL*/
            return false; 
          }
        }
});
//Скрываем index--main cтраницу - Скрипт подключается в случае подгрузки страницы slider
$(document).ready(function(){
     $(".main").css('display','none'); 
});
//Функция копирования ссылки
  function copyToClipboard(elementId) {
    // Создаем элемент ввод
    var aux = document.createElement("input");
    aux.setAttribute("value", document.getElementById(elementId).value);
    // Добавить его в документ
    document.body.appendChild(aux);
    // Выделяем его содержание
    aux.select();
    // Копируем выделенный текст
    document.execCommand("copy");
    // Убираем его из документа
    document.body.removeChild(aux);
    //Изменяем цвет и выводим информацию о успешном копировании ссылки    
    $(".form-control-value").css({'color':'green'});
    $(".validation-feedback").text("*Ссылка скопирована").css({'color':'green'});
    }

       
/*Отправка данных для формирования письма через почтовую программу*/
 $(document).ready(function(){
  $(".preparation_form_mail").click(function(e){
      e.preventDefault();//Если будет вызван данный метод, то действие события по умолчанию не будет выполнено - К примеру, клик по ссылке не отправит пользователя по новому URL*/
      //Собираем/выводим информацию о картинке
      let name_mail_dispatch = $(".name_mail_dispatch").val();//вычитываем содержание инпута электронного адреса
      let name_section_dispatch = $(".name-foto span").text();//вычитываем содержание раздела
      //вычитываем информационный текст картинки
      $.each($("[style='display: block;'] > p"), function (index, value) { 
          if (index == 0) {section_content_name = $(value).text();
            $("#name_dispatch").text($(value).text());}//выводим name
          else if (index == 1) {section_content_maseg = $(value).text();
            $("#description_dispatch").text($(value).text());}//выводим description
      });
      //Проверяем на валидность данные в input для отправке по почте
      let validation = $('.form-control-email');
      let name_mail_form = $('input[type="email"].name_mail_dispatch')[0];//вычитываем HTMLSelectElement из input[type="email"]
      if (!name_mail_form.checkValidity()) {
        validation.addClass('validation-remove').css({'color':'#dc3545'});
        $(".email-feedback").css({'color':'#dc3545'});
        $(".email-feedback").text("*" + name_mail_form.validationMessage);
      } else {
        validation.addClass('validation-ok').css({'color':'green'});
        //отправляем данные
         let Date_letter_slider = new Date() ;//дата отправления
         let copyURL_changed = copyURL.replace(/\&/g, '%26');
         window.location.href = 'mailto:' + name_mail_dispatch + '?subject=Сообшение пришло с сайта-Constantin Vidyuschenko&body=' + 'Раздел - ' + name_section_dispatch + '%0D%0A' + 'Название фотографии - ' + section_content_name + '%0D%0A'+ section_content_maseg + '%0D%0A' + copyURL_changed + '%0D%0A' + 'Дата/время отправления - ' + Date_letter_slider;  
         $(".email-feedback").css({'color':'green'});
         $(".email-feedback").text("*Данные переданы для отправки. Убедитесь что у вас настроена почтовая программа.");
        //подсчет кликов
        $.ajax({
          method: "POST", // метод HTTP, используемый для запроса
          url: "/functions/functions.php", // строка, содержащая URL адрес, на который отправляется запрос
          dataType: 'json',
          data: { // данные, которые будут отправлены на сервер
            edit : 1,
            name : 'mail',
            fale :"/json/share.json"}
          })
      }
    });
});
/*Анимация на АДМИН Странице*/
$(document).ready(function() {
    $('.show-settings').click('click', function() {//нажимаем кнопку помоши
      $('.show-settings').toggleClass('active');
      if ($('#show-settings' ).hasClass('show-settings active')) {//условие открытия/закрытия панели помошь
        $('.help').css({'display': 'block'});
        }else{$('.help').css({'display': 'none'});}        
      });
});

/*Скрипт для акардиона в информационную админ панель*/
  var acc = document.getElementsByClassName("accordion");
  var i;
  
  for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
  /* Переключение между добавлением и удалением класса "active",
  чтобы выделить кнопку, управляющую панелью */
      this.classList.toggle("activeAccord");
  /* Переключение между скрытием и отображением активной панели */
      var panel = this.nextElementSibling;
      if (panel.style.display === "block") {
        panel.style.display = "none";
      } else {
        panel.style.display = "block";
      }
    });
  }
  /*Скрипт для анимации отображения скрытие панелей в информационой админ панели*/
  //Обшая информационная панель
  $(document).ready(function() {
    $('.showFullInfo').click('click', function() {//нажимаем кнопку помоши
      $('.showFullInfo').toggleClass('active');
      if ($('#showFullInfo' ).hasClass('showFullInfo active')) {//условие открытия/закрытия панели помошь
        $('.wrapInfoFullinfo').css({'display': 'none'});
        }else{$('.wrapInfoFullinfo').css({'display': 'block'});}        
      });
   //Хостинг панель
    $('.showAdminInfo').click('click', function() {//нажимаем кнопку помоши
      $('.showAdminInfo').toggleClass('active');
      if ($('#showAdminInfo' ).hasClass('showAdminInfo active')) {//условие открытия/закрытия панели помошь
        $('.wrapInfoAdmin').css({'display': 'none'});
        }else{$('.wrapInfoAdmin').css({'display': 'block'});}        
      });
   //Админ панель
    $('.showHostingInfo').click('click', function() {//нажимаем кнопку помоши
      $('.showHostingInfo').toggleClass('active');
      if ($('#showHostingInfo' ).hasClass('showHostingInfo active')) {//условие открытия/закрытия панели помошь
        $('.wrapInfoHosting').css({'display': 'none'});
        }else{$('.wrapInfoHosting').css({'display': 'block'});}        
      });
   });
   //Кнопка для внесения изменений в ИНФОПАНЕЛЬ
  let save = document.getElementsByClassName("saveHost");
  let a;
  for (a = 0; a < save.length; a++) {
    save[a].addEventListener("click", function() {
      let nameButton = this.name;
      let point = document.getElementById(nameButton);//Ориентир       
      let panel = point.nextElementSibling;//следуюший элемент
      let text = point.previousElementSibling//предыдуший элемент       
          if (panel.style.display === "inline") {
            point.classList.toggle("activeSave");
            panel.style.display = "none";
            text.style.display = "";
          } else {
            panel.style.display = "inline";                                                                  
            text.style.display = "none";
          }
      //вычитываем из инпута
      let nameValue = this.name;
      let selectValue = document.getElementById("value"+nameValue)  
      //отправка на сервер данных 
        const edit = selectValue.name;      
        const fale = 'info.json'; 
        const params = "edit="+edit+"&name="+selectValue.value+"&fale="+fale;  
        const xhr = new XMLHttpRequest(); 
        xhr.open('Post','/functions/functions.php',true);
        //В заголовке говорим что тип передаваемых данных закодирован. 
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");        
        xhr.send(params);
        xhr.onreadystatechange = function() {
          if (xhr.status >= 200 && xhr.status < 300 || xhr.status == 304) {console.log("Запрос - " + this.statusText);
            }else {console.log("Ошибка в сетевом запросе - " + this.statusText + " - " + this.status)}
        } 
        //перезагрузка страницы
        window.location.reload();
    })
  }

      var sth = document.getElementsByClassName("saveTextHost");
      var i;
      for (i = 0; i < sth.length; i++) { 
        sth[i].addEventListener("click", function() {
          /* Переключение между добавлением и удалением класса "active",
          чтобы выделить кнопку, управляющую панелью */ 
          this.classList.toggle("activeSave");
          /* Переключение между скрытием и отображением активной панели */
        var panel = this.nextElementSibling;//следуюший элемент
        var text = this.previousElementSibling//предыдуший элемент       
          if (panel.style.display === "inline") {
            panel.style.display = "none";
            text.style.display = "";
          } else {
            panel.style.display = "inline";                                                                  
            text.style.display = "none";
          }
        })
      }    
   //Анимация кнопок для редактирования ПАРОЛЯ - панель USER
   $(document).ready(function() {
    $('.vievPassword').click('click', function() {//нажимаем кнопку отобразить/скрыть
          $('.vievPassword').toggleClass('active');
          if ($('.vievPassword' ).hasClass('vievPassword active')) {
            $('.vievPassword').html('<i class="far fa-eye-slash"></i>');//замена символа кнопки
            $('#password').attr('type','text');//замена атрибута - в пользователях
            $('.form-controlPassword').attr('type','text');//замена атрибута - при авторизации
            $('.vievPassword').attr('title','Показать');
          } else {
            $('.vievPassword').html('<i class="far fa-eye"></i>');//замена символа кнопки
            $('#password').attr('type','password');//замена атрибута
            $('.form-controlPassword').attr('type','password');//замена атрибута - при авторизации
            $('.vievPassword').attr('title','Скрыть');
          }      
      });      
    $('.exitPassword').click('click', function() {//нажимаем кнопку отмена генерации кода
      //при нажадии очишаем value  
        $('#password').val('');
        $('#password').attr('value','');
        //Очишаем панель соответстия пароля
        $('#block_check').css({'width': ''});
        $('#block_check').css({'background-color': ''});
        $('#block_check').css({'padding': ''});
        $('#block_check').html('');
      });
    $('.generatePassword').click('click', function() {//нажимаем кнопку генерации кода    
      $('#password').val('');//очишаем value
       //генерируем пароль
        let len = 25;
        function gen_password(len){
            var password = "";
            var symbols = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!№;%:?*()_+=";
            for (var i = 0; i < len; i++){
                password += symbols.charAt(Math.floor(Math.random() * symbols.length));     
            }
            return password;
        } 
        var passGenerall = gen_password(len);
        //добавляем сгенерированный код
        $('#password').val(passGenerall);
        $('#password').attr('value',passGenerall);
        //добавляем панель соответстия пароля
        $('#block_check').css({'width': '100%'});
        $('#block_check').css({'background-color': '#61ac27'});
        $('#block_check').css({'padding': '7px 0'});
        $('#block_check').html('Надёжный');
      });  
   }); 
   
 
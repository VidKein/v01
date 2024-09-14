//Считываем и преобразуем запрос из URL при первой загрузки
var url_zapros = location.search.split('photo=')[1];
var sliderNamber = url_zapros-1;
var backward;
var forward;

//Скрипт обших настроек слайдера+отображение информации о картинке
$(document).ready(function() {
//Отображение картинки по запросу из URL при первой загрузке
   jQuery(document).ready((function(){
     $('.sl').slick('slickGoTo', sliderNamber, false);   
    }));
    if (document.documentElement.clientWidth >=750) {
        backward = '.backward';
        forward = '.forward';
    } else {
        backward = '.backwardMini';
        forward = '.forwardMini';
    }
    $('.sl').slick({
        lazyLoad: 'ondemand',//ленивая загрузка
        pauseOnFocus: false,//не останавливает при нажатии на картинку
        pauseOnHover: false,//не останавливает при наведении курсора
        autoplaySpeed: 3000,//скорость проигрывания
        adaptiveHeight: true,//адаптация картинок
        cssEase: 'linear',//переход с затемнениями
        fade: true,//переход с затемнениями
        waitForAnimate: true,//игнорирует запросы на продвижение слайда во время анимации
        draggable: false,//отключает передвижение картинок слайдера при помоши мышки
        //заменитель стрелок
        prevArrow: document.querySelector(backward),
        nextArrow: document.querySelector(forward)
    });  
    //включаем автопроигрыватель+картинки+информация о фотогрвфии
    $('.play').click(function () {
        $('.sl').slick('slickPlay');
        $('.sl').on('afterChange', function(event, slick, currentSlide){//СОБЫТИЕ afterChange -- обратный вызов после смены слайда, переменная события currentSlide -- Возвращает индекс текущего слайда
            //вычитываем адрес с url
            var url_all = window.location.href;
            var namber_off_play = currentSlide;//номер текушего слайдера
            //обновляем адрес с url
            let new_url = new URL(url_all);
            new_url.searchParams.set('photo',(+namber_off_play+1));  
            window.history.pushState(url_all, 'Title', new_url);
            $( "#namber" ).text(+namber_off_play+1);//выводим номер текушего слайдера в счетчи
            $( "#namberMini" ).text(+namber_off_play+1);//выводим номер текушего слайдера в счетчи
            var starting_point = 0;   
            var xs = document.querySelectorAll(".content-foto");
            var end_poind = (xs.length)-1;
            var namber_img = $( ".slick-active" ).attr( "data-slick-index" );//вычитываем номер отображаемой картинки в статике
            document.getElementsByClassName("content-foto")[namber_img].style.display = "none";
            if (namber_img > starting_point && namber_img <= end_poind) {
                document.getElementsByClassName("content-foto")[namber_img].style.display = "block";//включаем отображения картинки
                $('.info-foto').each(function(){ 
                    document.getElementsByClassName("content-foto")[namber_img-1].style.display = "none";  //отключает отображения картинки
                }); 
            } else if (namber_img == starting_point) {document.getElementsByClassName("content-foto")[end_poind].style.display = "none";//отключает отображения последней картинки
            document.getElementsByClassName("content-foto")[namber_img].style.display = "block";}//включаем отображения картинки
        });
   });
    $('.stop').click(function () {//пауза автопроигрывателя
        $('.sl').slick('slickPause');
    });
    //Мини
    $('.playMini').click(function () {
        $('.sl').slick('slickPlay');
        $('.sl').on('afterChange', function(event, slick, currentSlide){//СОБЫТИЕ afterChange -- обратный вызов после смены слайда, переменная события currentSlide -- Возвращает индекс текущего слайда
            //вычитываем адрес с url
            var url_all = window.location.href;
            var namber_off_play = currentSlide;//номер текушего слайдера
            //обновляем адрес с url
            let new_url = new URL(url_all);
            new_url.searchParams.set('photo',(+namber_off_play+1));  
            window.history.pushState(url_all, 'Title', new_url);
            $( "#namber" ).text(+namber_off_play+1);//выводим номер текушего слайдера в счетчи
            $( "#namberMini" ).text(+namber_off_play+1);//выводим номер текушего слайдера в счетчи
            var starting_point = 0;   
            var xs = document.querySelectorAll(".content-foto");
            var end_poind = (xs.length)-1;
            var namber_img = $( ".slick-active" ).attr( "data-slick-index" );//вычитываем номер отображаемой картинки в статике
            document.getElementsByClassName("content-foto")[namber_img].style.display = "none";
            if (namber_img > starting_point && namber_img <= end_poind) {
                document.getElementsByClassName("content-foto")[namber_img].style.display = "block";//включаем отображения картинки
                $('.info-foto').each(function(){ 
                    document.getElementsByClassName("content-foto")[namber_img-1].style.display = "none";  //отключает отображения картинки
                }); 
            } else if (namber_img == starting_point) {document.getElementsByClassName("content-foto")[end_poind].style.display = "none";//отключает отображения последней картинки
            document.getElementsByClassName("content-foto")[namber_img].style.display = "block";}//включаем отображения картинки
        });
    });
    $('.stopMini').click(function () {//пауза автопроигрывателя
        $('.sl').slick('slickPause');
    });       
});

//Скрипт отображения информации о картинках при нажатии кнопок <--/-->
$(document).ready(function(){
    var starting_point = 0;   
    var xs = document.querySelectorAll(".content-foto");
    var end_poind = (xs.length)-1;
    var $next = $(".forward");//кнопка вперед
    var $prev = $(".backward");//кнопка назад
    var $nextMini = $(".forwardMini");//кнопка вперед МИНИ
    var $prevMini = $(".backwardMini");//кнопка назад МИНИ
    //вычитываем адрес с url
    var url_all = window.location.href;
    $("#namber").text(+sliderNamber+1);//выводим это в счетчик на странице
    $("#namberMini").text(+sliderNamber+1);//выводим это в счетчик на странице МИНИ
    document.getElementsByClassName("content-foto")[sliderNamber].style.display = "block";//отображаем инфо о первой картинке с индексом -- 0

    //ВПЕРЕД
    $next.click('click', function(){
        var namber_img = $( ".slick-active" ).attr( "data-slick-index" );//вычитываем номер отображаемой картинки при нажатии на кнопку вперед 
        //обновляем адрес с url
        let new_url = new URL(url_all);
        new_url.searchParams.set('photo',(+namber_img+1));  
        window.history.pushState(url_all, 'Title', new_url);
        if (namber_img > starting_point && namber_img <= end_poind) {
                $( "#namber" ).text(+namber_img+1);//выводим это в счетчик на странице
                document.getElementsByClassName("content-foto")[namber_img].style.display = "block";//включаем отображения картинки
                $('.info-foto').each(function(){ 
                    document.getElementsByClassName("content-foto")[namber_img-1].style.display = "none";  //отключает отображения картинки
                }); 
            } else if (namber_img == starting_point){ 
                   $("#namber").text(+starting_point+1);//выводим это в счетчик на странице
                   document.getElementsByClassName("content-foto")[end_poind].style.display = "none";//отключает отображения последней картинки
                   document.getElementsByClassName("content-foto")[namber_img].style.display = "block";}//включаем отображения картинки
    });
    //НАЗАД 
    $prev.click('click', function(){
    var namber_img = $( ".slick-active" ).attr( "data-slick-index" );//вычитываем номер отображаемой картинки при нажатии на кнопку назад
    //обновляем адрес с url
    let new_url = new URL(url_all);
    new_url.searchParams.set('photo',(+namber_img+1));  
    window.history.pushState(url_all, 'Title', new_url);
    if (namber_img >= starting_point && namber_img < end_poind) {
            $( "#namber" ).text(+namber_img+1);//выводим это в счетчик на странице
            document.getElementsByClassName("content-foto")[namber_img].style.display = "block";//включаем отображения картинки
            $('.info-foto').each(function(){ 
                document.getElementsByClassName("content-foto")[+namber_img + 1].style.display = "none";  //отключает отображения картинки
            }); 
        } else if (namber_img == end_poind){
             $("#namber").text(+end_poind+1);//выводим это в счетчик на странице
             document.getElementsByClassName("content-foto")[starting_point].style.display = "none";//отключает отображения начальной картинки
             document.getElementsByClassName("content-foto")[namber_img].style.display = "block";}//включаем отображения картинки
        }); 
    //Мини
    //ВПЕРЕД
    $nextMini.click('click', function(){
        var namber_img = $( ".slick-active" ).attr( "data-slick-index" );//вычитываем номер отображаемой картинки при нажатии на кнопку вперед 
        //обновляем адрес с url
        let new_url = new URL(url_all);
        new_url.searchParams.set('photo',(+namber_img+1));  
        window.history.pushState(url_all, 'Title', new_url);
        if (namber_img > starting_point && namber_img <= end_poind) {
                $( "#namberMini" ).text(+namber_img+1);//выводим это в счетчик на странице
                document.getElementsByClassName("content-foto")[namber_img].style.display = "block";//включаем отображения картинки
                $('.info-foto').each(function(){ 
                    document.getElementsByClassName("content-foto")[namber_img-1].style.display = "none";  //отключает отображения картинки
                }); 
            } else if (namber_img == starting_point){ 
                   $("#namberMini").text(+starting_point+1);//выводим это в счетчик на странице
                   document.getElementsByClassName("content-foto")[end_poind].style.display = "none";//отключает отображения последней картинки
                   document.getElementsByClassName("content-foto")[namber_img].style.display = "block";}//включаем отображения картинки
                   //Выводим название картинки
                   nameFoto();
    });
    //НАЗАД 
    $prevMini.click('click', function(){
    var namber_img = $( ".slick-active" ).attr( "data-slick-index" );//вычитываем номер отображаемой картинки при нажатии на кнопку назад
    //обновляем адрес с url
    let new_url = new URL(url_all);
    new_url.searchParams.set('photo',(+namber_img+1));  
    window.history.pushState(url_all, 'Title', new_url);
    if (namber_img >= starting_point && namber_img < end_poind) {
            $( "#namberMini" ).text(+namber_img+1);//выводим это в счетчик на странице
            document.getElementsByClassName("content-foto")[namber_img].style.display = "block";//включаем отображения картинки
            $('.info-foto').each(function(){ 
                document.getElementsByClassName("content-foto")[+namber_img + 1].style.display = "none";  //отключает отображения картинки
            }); 
        } else if (namber_img == end_poind){
             $("#namberMini").text(+end_poind+1);//выводим это в счетчик на странице
             document.getElementsByClassName("content-foto")[starting_point].style.display = "none";//отключает отображения начальной картинки
             document.getElementsByClassName("content-foto")[namber_img].style.display = "block";}//включаем отображения картинки
             //Выводим название картинки
             nameFoto();
        }); 
//Вачитываем информацию о картинке
 function nameFoto() {
    var blokInfoFoto = document.querySelector(".blokInfoFoto");    
    for (let i = 0; i < blokInfoFoto.children.length; i++) { 
      if (blokInfoFoto.children[i].style.display == "block") {
        document.querySelector("#name").innerHTML = blokInfoFoto.children[i].children[0].innerHTML;
        document.querySelector("#description").innerHTML = blokInfoFoto.children[i].children[1].innerHTML;
      } 
    }
  }    
});

//Скрипт отображения информации о картинках при нажатии кнопок клавиш на клавиатуре влево/вправо
$(document).on('keydown',function (e) { 
    var key = e.which;
        if ($('#social_metca' ).hasClass('holder_content active')) {//Отключаем нажатие кнопок клавиш влево/вправо на клавиатуре при открытых соц сетях
          if( key == 37 || key == 39 ){
            e.preventDefault();
            return false; 
          }
        }else {var starting_point = 0;   
               var xs = document.querySelectorAll(".content-foto");
               var end_poind = (xs.length)-1;
               //вычитываем адрес с url
               var url_all = window.location.href;
               var namber_img = $( ".slick-active" ).attr( "data-slick-index" );//вычитываем номер отображаемой картинки в статике
               $( "#namber" ).text(+namber_img+1);//выводим это в счетчик на странице
               $( "#namberMini" ).text(+namber_img+1);//выводим это в счетчик на странице
               document.getElementsByClassName("content-foto")[namber_img].style.display = "block";//отображаем инфо о первой картинке с индексом -- 0
                 if (e.which == 39) {$('.sl').slick('slickNext');//запускает следующий слайд при нажатии кнопки вправо
                                    //ВПЕРЕД
                                        var namber_img = $( ".slick-active" ).attr( "data-slick-index" );//вычитываем номер отображаемой картинки при нажатии на кнопку вперед 
                                        //обновляем адрес с url
                                        let new_url = new URL(url_all);
                                        new_url.searchParams.set('photo',(+namber_img+1));  
                                        window.history.pushState(url_all, 'Title', new_url);
                                        if (namber_img > starting_point && namber_img <= end_poind) {
                                                $( "#namber" ).text(+namber_img+1);//выводим это в счетчик на странице
                                                $( "#namberMini" ).text(+namber_img+1);//выводим это в счетчик на странице
                                                document.getElementsByClassName("content-foto")[namber_img].style.display = "block";//включаем отображения картинки
                                                   $('.info-foto').each(function(){ 
                                                    document.getElementsByClassName("content-foto")[namber_img-1].style.display = "none";  //отключает отображения картинки
                                                }); 
                                            } else if (namber_img == starting_point) {
                                                $("#namber").text(+starting_point+1);//выводим это в счетчик на странице
                                                $("#namberMini").text(+starting_point+1);//выводим это в счетчик на странице
                                                document.getElementsByClassName("content-foto")[end_poind].style.display = "none";//отключает отображения последней картинки
                                                document.getElementsByClassName("content-foto")[namber_img].style.display = "block";}//включаем отображения картинки
                                                //Выводим название картинки
                                                nameFoto();
                     }
                 else if (e.which == 37) {$('.sl').slick('slickPrev');//запускает следующий слайд при нажатии кнопки влево
                                    //НАЗАД 
                                    var namber_img = $( ".slick-active" ).attr( "data-slick-index" );//вычитываем номер отображаемой картинки при нажатии на кнопку назад
                                    //обновляем адрес с url
                                    let new_url = new URL(url_all);
                                    new_url.searchParams.set('photo',(+namber_img+1));  
                                    window.history.pushState(url_all, 'Title', new_url);
                                    if (namber_img >= starting_point && namber_img < end_poind) {
                                            $( "#namber" ).text(+namber_img+1);//выводим это в счетчик на странице
                                            $( "#namberMini" ).text(+namber_img+1);//выводим это в счетчик на странице
                                            document.getElementsByClassName("content-foto")[namber_img].style.display = "block";//включаем отображения картинки
                                            $('.info-foto').each(function(){ 
                                                document.getElementsByClassName("content-foto")[+namber_img + 1].style.display = "none";  //отключает отображения картинки
                                            }); 
                                        } else if (namber_img == end_poind) {
                                            $("#namber").text(+end_poind+1);//выводим это в счетчик на странице
                                            $("#namberMini").text(+end_poind+1);//выводим это в счетчик на странице
                                            document.getElementsByClassName("content-foto")[starting_point].style.display = "none";//отключает отображения начальной картинки
                                            document.getElementsByClassName("content-foto")[namber_img].style.display = "block";}//включаем отображения картинки
                                            //Выводим название картинки
                                            nameFoto();
                    }
        }
//Вачитываем информацию о картинке
 function nameFoto() {
    var blokInfoFoto = document.querySelector(".blokInfoFoto");    
    for (let i = 0; i < blokInfoFoto.children.length; i++) { 
        console.log(blokInfoFoto);
        
      if (blokInfoFoto.children[i].style.display == "block") {
        document.querySelector("#name").innerHTML = blokInfoFoto.children[i].children[0].innerHTML;
        document.querySelector("#description").innerHTML = blokInfoFoto.children[i].children[1].innerHTML;
      } 
    }
  }
  }); 
  
//при нажатии пробела включается проигрыватель/при повторном нажатии пробела пауза
$(function(){
            var BackspasePlay = false;
            function moveRect( e ) {
               switch ( e.which ) {
                   case 32: // если нажата клавиша Backspase            
                        for ( i = 0; i < 1; i++ ) {
                            if ( !BackspasePlay ) {
                                BackspasePlay = true;//проверка на сушествование переменной
                                //убераем кнопку проигрывать -- показываем кнопку пауза
                                $(".play").toggleClass('active');//маркер для соцсетей
                                $(".stop").css({'display': 'block'});
                                $(".play").css({'display': 'none'});
                                //убераем кнопку проигрывать -- показываем кнопку пауза Мини
                                $(".playMini").toggleClass('active');//маркер для соцсетей
                                $(".stopMini").css({'display': 'block'});
                                $(".playMini").css({'display': 'none'});
                                //включаем промгрыватель
                                $('.sl').slick('slickPlay');
                                //включаем пролистывание фото
                                $('.sl').on('afterChange', function(event, slick, currentSlide){//СОБЫТИЕ afterChange -- обратный вызов после смены слайда, переменная события currentSlide -- Возвращает индекс текущего слайда
                                    var namber_off_play = currentSlide;//номер текушего слайдера
                                    //вычитываем адрес с url
                                    var url_all = window.location.href;
                                    $( "#namber" ).text(+namber_off_play+1);//выводим номер текушего слайдера в счетчик
                                    $( "#namberMini" ).text(+namber_off_play+1);//выводим номер текушего слайдера в счетчик
                                    //обновляем адрес с url
                                    let new_url = new URL(url_all);
                                    new_url.searchParams.set('photo',(+namber_off_play+1));  
                                    window.history.pushState(url_all, 'Title', new_url);
                                    var starting_point = 0;   
                                    var xs = document.querySelectorAll(".content-foto");
                                    var end_poind = (xs.length)-1;
                                    var namber_img = $( ".slick-active" ).attr( "data-slick-index" );//вычитываем номер отображаемой картинки в статике
                                    document.getElementsByClassName("content-foto")[namber_img].style.display = "none";
                                    if (namber_img > starting_point && namber_img <= end_poind) {
                                        document.getElementsByClassName("content-foto")[namber_img].style.display = "block";//включаем отображения картинки
                                        $('.info-foto').each(function(){ 
                                            document.getElementsByClassName("content-foto")[namber_img-1].style.display = "none";  //отключает отображения картинки
                                        }); 
                                    } else if (namber_img == starting_point) {document.getElementsByClassName("content-foto")[end_poind].style.display = "none";//отключает отображения последней картинки
                                    document.getElementsByClassName("content-foto")[namber_img].style.display = "block";}//включаем отображения картинки
                                });
                          } else {
                                BackspasePlay = false;//проверка на сушествование переменной
                                //включаем проигрыватель
                                $('.sl').slick('slickPause');
                                //убераем кнопку пауза -- показываем кнопку проигрывать
                                $(".play").toggleClass('active');//маркер для соцсетей
                                $(".stop").css({'display': 'none'});
                                $(".play").css({'display': 'block'});
                                //убераем кнопку пауза -- показываем кнопку проигрывать
                                $(".playMini").toggleClass('active');//маркер для соцсетей
                                $(".stopMini").css({'display': 'none'});
                                $(".playMini").css({'display': 'block'});
                                }
                        };
                    break;
                };
            };          
            addEventListener( "keydown", moveRect );
});
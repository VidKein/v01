function addSoc(a) {
    var h=encodeURIComponent(window.location.href+window.location.hash);//адресс страницы
    console.log(window.location.href+window.location.hash);
    var t=encodeURIComponent(document.title);//Тайтл документа
    console.log(document.title);
    var src_img = $(".slick-active > img").attr( "src" );//вычитываем адрес картинки
    var img = origin_web+"/"+src_img;//создаем путь - добовляем домен переменная origin_web 
    console.log(img);
    if(a=='facebook'){ h='www.facebook.com/share.php?u='+h;
    //подсчет кликов
    let edit = 1;
          let name = 'facebook';
          let fale = 'share.json'; 
          const params = "edit="+edit+"&name="+name+"&fale="+fale;     
          const xhr = new XMLHttpRequest();
          xhr.open('Post','/functions/functions.php',true);
          //В заголовке говорим что тип передаваемых данных закодирован. 
          xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          xhr.onreadystatechange = function() {
            if (xhr.readyState !== 4 || xhr.status !== 200) {console.log(this.responseText);}
                const response = xhr.response;    
          }
          xhr.send(params);
    }else if(a=='twitter'){ h='twitter.com/share?url='+h+'&text='+t+'&hashtags=my_hashtag';
    //подсчет кликов
    let edit = 1;
          let name = 'twitter';
          let fale = 'share.json'; 
          const params = "edit="+edit+"&name="+name+"&fale="+fale;     
          const xhr = new XMLHttpRequest();
          xhr.open('Post','/functions/functions.php',true);
          //В заголовке говорим что тип передаваемых данных закодирован. 
          xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          xhr.onreadystatechange = function() {
            if (xhr.readyState !== 4 || xhr.status !== 200) {console.log(this.responseText);}
                const response = xhr.response;    
          }
          xhr.send(params);
    }else if(a=='pinterest'){ h='www.pinterest.com/pin/create/button/?url='+h+'&media='+img+'&description='+t;
    //подсчет кликов
    let edit = 1;
          let name = 'pinterest';
          let fale = 'share.json'; 
          const params = "edit="+edit+"&name="+name+"&fale="+fale;     
          const xhr = new XMLHttpRequest();
          xhr.open('Post','/functions/functions.php',true);
          //В заголовке говорим что тип передаваемых данных закодирован. 
          xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          xhr.onreadystatechange = function() {
            if (xhr.readyState !== 4 || xhr.status !== 200) {console.log(this.responseText);}
                const response = xhr.response;    
          }
          xhr.send(params);
    }else return;
    window.open('http://'+h,'Social','screenX=500,screenY=100,height=500,width=500,location=no,toolbar=yes,menubar=no,status=no');
    return false;}
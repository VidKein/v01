// Проверка на валидность введеного Password       
        var s_letters = "qwertyuiopasdfghjklzxcvbnm"; // Буквы в нижнем регистре
        var b_letters = "QWERTYUIOPLKJHGFDSAZXCVBNM"; // Буквы в верхнем регистре
        var digits = "0123456789"; // Цифры
        var specials = "!@#$%^&*()_-+=\|/.,:;[]{}"; // Спецсимволы
            
        var input_test = document.getElementById('password');//получаем поле
        var block_check = document.getElementById('block_check');//получаем блок с индикатором    

        input_test.addEventListener('keyup', function(){
        var input_test_val = input_test.value;//получаем значение из поля
    
        var is_s = false; // Есть ли в пароле буквы в нижнем регистре
        var is_b = false; // Есть ли в пароле буквы в верхнем регистре
        var is_d = false; // Есть ли в пароле цифры
        var is_sp = false; // Есть ли в пароле спецсимволы
                
        for (var i = 0; i < input_test_val.length; i++) {
            /* Проверяем каждый символ пароля на принадлежность к тому или иному типу */
            if (!is_s && s_letters.indexOf(input_test_val[i]) != -1) {
                is_s = true
            }
            else if (!is_b && b_letters.indexOf(input_test_val[i]) != -1) {
                is_b = true
            }
            else if (!is_d && digits.indexOf(input_test_val[i]) != -1) {
                is_d = true
            }
            else if (!is_sp && specials.indexOf(input_test_val[i]) != -1) {
                is_sp = true
            }
        }

        var rating = 0;
        if (is_s) rating++; // Если в пароле есть символы в нижнем регистре, то увеличиваем рейтинг сложности
        if (is_b) rating++; // Если в пароле есть символы в верхнем регистре, то увеличиваем рейтинг сложности
        if (is_d) rating++; // Если в пароле есть цифры, то увеличиваем рейтинг сложности
        if (is_sp) rating++; // Если в пароле есть спецсимволы, то увеличиваем рейтинг сложности
        /* Далее идёт анализ длины пароля и полученного рейтинга, и на основании этого готовится текстовое описание сложности пароля */
        if (input_test_val.length < 6 && rating < 3) {
            block_check.style.width = "100%";
            block_check.style.padding = "7px 0px";
            block_check.style.backgroundColor = '#FFABAF';
            block_check.innerText = 'Очень слабый'; 
        }
        else if (input_test_val.length < 6 && rating >= 3) {
            block_check.style.width = "100%";
            block_check.style.padding = "7px 0px";
            block_check.style.backgroundColor = '#ffdb00';
            block_check.innerText = 'Средний'; 
        }
        else if (input_test_val.length >= 8 && rating < 3) {
            block_check.style.width = "100%";
            block_check.style.padding = "7px 0px";
            block_check.style.backgroundColor = '#ffdb00';
            block_check.innerText = 'Средний'; 
        }
        else if (input_test_val.length >= 8 && rating >= 3) {
            block_check.style.width = "100%";
            block_check.style.padding = "7px 0px";
            block_check.style.backgroundColor = '#61ac27';
            block_check.innerText = 'Надёжный'; 
        }
        else if (input_test_val.length >= 6 && rating == 1) {
            block_check.style.width = "100%";
            block_check.style.padding = "7px 0px";
            block_check.style.backgroundColor = '#FFABAF';
            block_check.innerText = 'Очень слабый'; 
        }
        else if (input_test_val.length >= 6 && rating > 1 && rating < 4) {
            block_check.style.width = "100%";
            block_check.style.padding = "7px 0px";
            block_check.style.backgroundColor = '#ffdb00';
            block_check.innerText = 'Средний'; 
        }
        else if (input_test_val.length >= 6 && rating == 4) {
            block_check.style.width = "100%";
            block_check.style.padding = "7px 0px";
            block_check.style.backgroundColor = '#61ac27';
            block_check.innerText = 'Надёжный'; 
        };
        }); 
  
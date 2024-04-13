   <div class="content">
            <div class="content-1">
                  <a class="info" title="<?php echo help_vars($array_settings,'title_top_nav'); ?>" href="<?php echo "$_SERVER[PHP_SELF]?page=gallery&categories=all"?>"><?php echo help_vars($array_settings,'text_top_nav'); ?>:</a>   
                  <ul class="navTop">
                     <?php
                        foreach($array_trips as $key => $value){               
                           print  "<li><a class=\"sheet-inner-content-1\" title=\"$value\" href=\"$_SERVER[PHP_SELF]?page=gallery&categories=$key\">$value</a></li>" ;
                        }
                     ?>
                        
                  </ul>
                  <ul class="navBottom">
                     <?php page_see_nav('nav', $array_menus);?>   
                  </ul>
            </div>      
            <?php
               require_once "bottom.php";
            ?>
    </div> 
  
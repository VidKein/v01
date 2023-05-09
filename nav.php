   <div class="content">
      <div class="inner-content">
        <div>
            <div class="inner-content-1">
                  <a class="info" title="<?php echo help_vars($array_settings,'title_top_nav'); ?>" href="<?php echo "$_SERVER[PHP_SELF]?page=gallery&categories=all"?>"><?php echo help_vars($array_settings,'text_top_nav'); ?>:</a>   
                  <ul>
                     <?php
                        foreach($array_trips as $key => $value){               
                           print  "<li><a class=\"sheet-inner-content-1\" title=\"$value\" href=\"$_SERVER[PHP_SELF]?page=gallery&categories=$key\">$value</a></li>" ;
                        }
                     ?>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <?php page_see_nav('nav', $array_menus);?>   
                     </ul>
                  <?php
                     require_once "bottom.php";
                  ?>
           </div>
         </div> 
       </div>
    </div> 
  
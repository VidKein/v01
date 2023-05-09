<div class="content2">
		<div class="inner-content-2">
			<?php
						foreach($array_socials_class as $social_key => $social_value ){
			?>
									<div class="<?php echo $social_value;?>">
												<a href="<?php echo $array_socials_linc[$social_key];?>" target="_blank" title="<?php echo $social_key;?>">
														<svg role="img" viewBox="<?php echo $array_socials_box[$social_key];?>">
															<path fill="currentColor" d="<?php echo $array_socials_color[$social_key];?>"/>
													   </svg>
												</a>
									</div>
			<?php 
						}
			?>
		</div>
</div>
   <div class="content3"><?php page_see_nav('bottom', $array_menus);?>
</div>   
 

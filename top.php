		<div class="left_up">
		    <span class="iconNav"><i class="fa fa-bars" aria-hidden="true" title="Меню"></i></span>
			<a class="logo" title="<?php echo help_vars($array_settings,'title_prof');?>"  href="<?php echo "$_SERVER[PHP_SELF]"?>">
			<span class="logo_name"><?php echo help_vars($array_settings,'text_main');?></span>
		    <span class="logo_funktion"><?php echo help_vars($array_settings,'text_prof');?></span>
			</a>
		</div>
		<div class="rigtn_up">
			<span class="iconSearch">
				<input class="searchInput" type="text" placeholder="Поиск">
				<span class="clear" title="Очистить поис">x</span>
				<i id="search" class="fa fa-search" aria-hidden="true" title="Поиск по сайту"></i>&#149
				<div class="searchResultsContainer">
					<div class="ResultsContainer">
						<div class="quantity">
							Найдено : 
							<span class="quantityInfo"></span>
							<hr>
						</div>
						<div class="Results">
							<ul class="tablResults">

							</ul>
						</div>
					</div>
				</div>
			</span>
			<span class="iconKontakt"><?php page_see_nav('top', $array_menus);?>&#149</span>
			<ul class="languageSelect" id="languageSelect" title="Язык сайта"> 
			    <li data-lang="cz" id="cz">CZ</li>
        		<li data-lang="uk" id="uk">UA</li>
        		<li data-lang="ru" id="ru">RU</li> 
        		<li data-lang="en" id="en">ENG</li>
    		</ul>
		</div>
	
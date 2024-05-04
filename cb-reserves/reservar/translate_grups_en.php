<?php
if (!isset($lang)) $lang='cat';
if (!isset($PERSONES_GRUP)) $PERSONES_GRUP=12;



$translate['ANULAT___INFO_COMANDA_GRUPS']="In group reservations you should choose, at least, one menu for each diner (counting adults, juniors and children)<br>"
    . "For more than 17 people you can not choose from dish-menu and you must select set-menus for all of you";
$translate['INFO_COMANDA_GRUPS']="Select the dishes or menus you will take. Keep in mind that you will have to choose all dishes or all full menus. <b> Full menus and dishes can not be combined in the same reservation </b> <br> "
    . "<br><ul> <li> If you are <b> up to 17 </b> diners, the selection of dishes <b> is optional </b>, but if you want to make it easier for us, you can choose dishes from the menu or full menus, but <b> it is not possible to combine dishes and full menus </b> </li> "
    . "<li> If you are <b> more than 17 </b>, you need to select as many <b>full menus (dishes not allowed)</b> as guests (including children) to complete the reservation   </li> </ul>";
$translate['Escull els menús']="Choose menus";
 $translate['Veure els menús']='See menus';
 $translate['Menús']='Set menus';

$translate['INFO_QUANTS_SOU_GRUPS']='Tell us how many people will come, indicate firstly people over 14 years of age. Also, mark the number of juniors and children. 
		<br/> <br/>
<b>We will reserve spaces for the number of diners shown here. The reservation will not be valid for a number of people that does not coincide with the reservation request. </b>
			 <br/>
		<b>(WE CANNOT GUARANTEE THE AVAILABILITY OF HIGH CHAIRS).</b><br/>
<br/> <br/>
		We only allow access to guide dogs accompanied by blind people 
<br/> <br/>
		<em> If, in total, you are less than <b> '. ($PERSONES_GRUP ).'</b> people, mark the "<='. ($PERSONES_GRUP-1 ).'" </em> <br/> <br/>
<b> TOTAL PEOPLE</b>: ';

	$translate['INFO_CARTA_GRUPS']='You should indicate the adults’ menu.
	<br/><strong style="font-size:1.2em"> If you are accompanied by children/juniors, you also need to indicate the menu you would like for them </strong>
			<br/><br/>
For vegetarians we have a menu of grilled vegetables for 25€. Add a commentary in the <b>Other Information</b> fi the next stage of the reservation so that we are informed';
     

        
        
$translate['Escull el menú']='Choose the menu';
$translate['Menú per a adults']='Menu for adults';
$translate['Menú per a juniors']='Menu for juniors (children from 10 to 14 years old)';
$translate['Menú per a nens']='Menu for children (children from 4 to 9 years old)';
$translate['CARTA_FINS_20']="Until 20 people, the menus pre-selection is optional and you can do it in the restaurant";

$translate['ALERTA_INFO_GRUPS']='The reservation <b>request</b> has been sent.
<br/><br/>
<b>this does NOT mean that it is confirmed. </b>.
<br/><br/>
We have to verify the availability of a table for the date you have requested.  
hortly you will receive an email informing you if we have been able to reserve a table for you and how to continue 
the process to confirm the reservation 
<br/><br/>

<div class="alert alert-danger">
If you have <b>to modify </b> the number of people, you must notice, at least <b> 3 days before the booking date </b> to the mail restaurant@can-borrell.com or call 936929723 / 936910605 
</div>

<br/> <br/>

Check your emails in the following two or three hours and be aware that the <b>RESERVATION IS NOT YET CONFIRMED</b>

<br/><br/>

we always respond to requests within one day. If in twenty four hours you haven’t 
received a response it could be due to a problem with the email. 
Check your spam folder, if you cannot find the restaurants email message contact us by sending an email giving us: 
<ul>
<li>
Another email address where we can contact you 
</li>
<li>
		Your name
</li>
<li>
The date of the reservation request
</li>
<li>
The number of diners 
</li>
</ul>

<br/><br/>
The price of the deposit is discounted from your bill, therefore there is no added expense, 
this applies even if you change the number of diners when confirming the reservation.'					
.'<div class = "info-paga-i-senyal">Attention: If you cannot come on the day of your reservation <b>Attention: If you cannot come on the day of your reservation your deposit will be refunded if 48 hours \ notice is given. </b>. '
    . 'Otherwise, the amount paid will not be returned </div> '
.'<br/><br/>Thank you for using this service.<br/><br/>';






// LLISTAT MENUS

/*******************************************************************************************/
// MENU 1
/*******************************************************************************************/
	$translate['titol_menu_2001']=$translate['titol_menu_1']='Menú nº1';
	$translate['menu_2001']=$translate['menu_1']='
	<div id="menu-2001" class="menu-content">
<p><strong>STARTERS <em>ENTRANTS</em></strong><br>
<i>All shared in table</i></p>
<ul>
<li>Green salad <em>Amanida</em></li>
<li>Escalivada (roast aubergine, onion and pepper) <em>Escalivada</em></li>
<li>Roast mushrooms <em>Gírgoles</em></li>
<li>Roast asparagus (in season) <em>Espàrrecs brasa</em></li>
<li>Roast artichokes (in season)<em>Carxofes (temporada)</em></li>
<li>Haricot beans with salted pork <em>Mongetes amb cansalada</em></li>
<li>Fried Potatoes <em>Patates fregides</em></li>
<li>All i Oli (garlic mayonnaise)<em> All i Oli</em></li>
<li>Toasted bread with tomato <em>Pa torrat amb tomàquet</em></li>
</ul>
<p><strong>GRILLED MEAT <em>GRAELLADA</em></strong><br>
<i>Single</i></p>
<ul class="plat1">
<li>Lamb 2 pieces<em>Xai</em> </li>
<li>Rabbit 1/4<em>Conill</em></li>
<li>Catalan sausage 1/2<em>Botifarra</em></li>
</ul>
<div class="complements">
<h6>ACCESSORIES</h6>
<p>  If you do not want barbecue, you can add accessories:</p>
<ul class="dots">
<li class="field">Roast veal chop <em>Costella de vedella a la brasa</em>  <span class="field field2" style="font-size:0.8em"><span class="preu">9.50</span>€</span></li>
<li><span class="field">Roast lamb back <em>Espatlla de xai a la brasa</em></span> <span class="field field2" style="font-size:0.8em"><span class="preu">10.40</span>€</span></li>
<li><span class="field">Roast pork feet <em>Espatlla de xai a la brasa</em></span> <span class="field field2" style="font-size:0.8em"><span class="preu">10.25</span>€</span></li>
<li><span class="field">Roast cod <em>Bacallà a la llauna&gt;</em></span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Roast snails <em>Cargols a la llauna</em></span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Roast gilthead <em>Moixarra a la brasa</em></span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Roast sea bass <em>Lubina a la brasa</em></span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
</ul>
</div>
<div class="cb"></div>
<p><strong>WINE CELLAR <em>CELLER</em></strong></p>
<ul>
<li>House wine <em>Vi de la Casa</em></li>
<li>Soda water <em>Gasosa</em></li>
<li>Soft drink <em>Refresc</em></li>
<li>Mineral water <em>Aigua</em></li>
<li>1 beer included</li>
</ul>
<p><strong>DESSERTS <em>POSTRES</em></strong></p>
<ul>
<li>Crême caramel <em>Flam casolà </em></li>
<li>ice cream <em>Gelats</em></li>
<li>Catalan Custard Cream <em>Crema catalana</em></li>
</ul>
<p><strong>COFFEES<em> CAFÈS, TALLATS</em></strong></p>
<div id="ressenya" class="caixa-preus caixa-negre caixa-left">
<h6><span class="preu">{preu_2001}</span> Euros / Per Adult (vat. included)</h6>
<h6><span class="preu">{preu_2002}</span> Euros / Per Adult with cava&nbsp;(vat. included)</h6>
<p><span style="font-size: 0.8em;">&nbsp;</span></p>
<hr>
<h6 class="infantil"><span style="font-weight: bold;"> – Menú Infantil</span> (nens de 4 a 9 anys)<br>
<i>Macarrons, pollastre arrebossat o croquetes amb patates, refresc i gelat</i><br>
<span class="preu">{preu_2037}</span> Euros/unit (vat. included)</h6>
<h6 class="infantil"><span style="font-weight: bold;"> – Menú Junior</span> (de 10 a 14 anys)<br>
<i>Macarrons o entremès, pollastre o botifarra amb patates, refresc i gelat</i><br>
<span class="preu">{preu_2036}</span> Euros/unit (vat. included)</h6>
</div>
</div>
';

/*******************************************************************************************/
// MENU 1 CEL
/*******************************************************************************************/
	$translate['titol_menu_2025']=$translate['titol_menu_2024']=$translate['titol_menu_1c']='MEN&Uacute; Nº 1 CELEBRACI&Oacute;N';
	$translate['menu_2025']=$translate['menu_1c']=$translate['menu_2024']='
<div id="menu-2001" class="menu-content">
<p><strong>STARTERS <em>ENTRANTS</em></strong><br>
<i>All shared in table</i></p>
<ul>
<li>Salad <em>Amanida</em></li>
<li>Escalivada (roast aubergine, onion and pepper) <em>Escalivada</em></li>
<li>Roast mushrooms <em>Gírgoles</em></li>
<li>Roast asparagus (in season) <em> Espàrrecs brasa  (temporada)</em></li>
<li>Artichokes (in season) <em>Carxofes (temporada)</em></li>
<li>Haricot beans with salt pork <em>Mongetes amb cansalada</em></li>
<li>Potatoes <em>Patates fregides</em></li>
<li>All i Oli (garlic mayonnaise) <em>All i Oli</em></li>
<li>Toasted bread with tomato <em>Pa torrat amb tomàquet</em></li>
</ul>
<p>&nbsp;</p>
<p><strong>GRILLED MEAT <em>GRAELLADA</em></strong><br>
<i>Single</i></p>
<ul class="plat1">
<li>Lamb <em>Xai</em></li>
<li>Rabbit <em>Conill</em></li>
<li>Roast catalan sausage <em>Botifarra</em></li>
</ul>
<div class="complements">
<h6>ACCESSORIES</h6>
<p>  If you do not want barbecue, you can add accessories:</p>
<ul class="dots">
<li class="field">Roast veal chop <em>Costella de vedella a la brasa</em>  <span class="field field2" style="font-size:0.8em"><span class="preu">9.50</span>€</span></li>
<li><span class="field">Roast lamb back <em>Espatlla de xai a la brasa</em></span> <span class="field field2" style="font-size:0.8em"><span class="preu">10.40</span>€</span></li>
<li><span class="field">Roast pork feet <em>Espatlla de xai a la brasa</em></span> <span class="field field2" style="font-size:0.8em"><span class="preu">10.25</span>€</span></li>
<li><span class="field">Roast cod <em>Bacallà a la llauna&gt;</em></span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Roast snails <em>Cargols a la llauna</em></span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Roast gilthead <em>Moixarra a la brasa</em></span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Roast sea bass <em>Lubina a la brasa</em></span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
</ul>
</div>
<div class="cb"></div>
<p><strong>WINE CELLAR <em>CELLER</em></strong></p>
<ul>
<li>House wine <em>Vi de la Casa</em></li>
<li>Soda water <em>Gasosa</em></li>
<li>Soft drink <em>Refresc</em></li>
<li>Mineral Water <em>Aigua</em></li>
<li>Beer included <em>Cerveza</em></li>
</ul>
<p>&nbsp;</p>
<p><strong>DESSERTS <em>POSTRES</em></strong></p>
<ul>
<li>Celebration Massini cake<em> Pastís massini</em></li>
</ul>
<p><strong>COFFEES<em>CAFÈS, TALLATS</em></strong></p>
<div id="ressenya" class="caixa-preus caixa-negre caixa-left">
<h6><span class="preu">{preu_2025}</span> Euros/ Per Adult with cava (vat. included)</h6>
<hr>
<h6 class="infantil"><span style="font-weight: bold;"> -Children’s Menu (children ages 4 to 9) </span><br>
Macaroni, fried chicken breast or croquettes with potatoes, soft drink and ice cream<br>
<span class="preu">{preu_2037}</span> Euros/unit (vat. included)</h6>
<h6 class="infantil"><span style="font-weight: bold;"> – Menú Junior</span> (de 10 a 14 anys)<br>
Macaroni or appetizer, chicken or roast catalan sausage with potatoes, soft drink and ice cream<br>
<span class="preu">{preu_2036}</span> Euros/unit (vat. included)</h6>
</div>
</div>
';

/*******************************************************************************************/
// MENU 2
/*******************************************************************************************/
	$translate['titol_menu_2003']=$translate['titol_menu_2']='MEN&Uacute; Nº 2';
	$translate['menu_2003']=$translate['menu_2']='
<div id="menu-2001" class="menu-content">
<div class="carta-fotos">
<p><strong>STARTERS <em>ENTRANTS</em></strong><br>
<i>All shared in table</i></p>
<ul>
<li>Long pork sausage <em>Llonganissa</em></li>
<li>Chorizo sausage <em>Xoriço</em></li>
<li>Jabugo Paté<em> Paté de Jabugo</em></li>
<li>Salad <em>Amanida</em></li>
<li>Escalivada (roast aubergine, onion and pepper) <em>Escalivada</em></li>
<li>All i Oli (garlic mayonnaise) <em>All i Oli</em></li>
<li>Toasted bread with tomato <em>Pa torrat amb tomàquet</em></li>
</ul>
<p>&nbsp;</p>
<p><strong>SECOND COURSES <em>SEGONS</em></strong></p>
<ul>
<li>Haricot beans with salted pork <em>Mongetes amb cansalada</em></li>
<li>Fried potatoes <em>Patates fregides</em></li>
</ul>
<p>&nbsp;</p>
<div class="cb"></div>
<p><strong>GRILLED MEAT <em>GRAELLADA</em></strong><br>
<i>Single</i></p>
<ul class="plat1">
<li>Lamb 2 pieces<em>Xai</em></li>
<li>Rabbit 1/4<em>Conill</em></li>
<li>Roast catalan sausage 1/2<em>Botifarra</em></li>
</ul>
<div class="complements">
<h6>ACCESSORIES</h6>
<p>  If you do not want barbecue, you can add accessories:</p>
<ul class="dots">
<li class="field">Roast veal chop <em>Costella de vedella a la brasa</em>  <span class="field field2" style="font-size:0.8em"><span class="preu">9.50</span>€</span></li>
<li><span class="field">Roast lamb back <em>Espatlla de xai a la brasa</em></span> <span class="field field2" style="font-size:0.8em"><span class="preu">10.40</span>€</span></li>
<li><span class="field">Roast pork feet <em>Espatlla de xai a la brasa</em></span> <span class="field field2" style="font-size:0.8em"><span class="preu">10.25</span>€</span></li>
<li><span class="field">Roast cod <em>Bacallà a la llauna&gt;</em></span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Roast snails <em>Cargols a la llauna</em></span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Roast gilthead <em>Moixarra a la brasa</em></span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Roast sea bass <em>Lubina a la brasa</em></span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
</ul>
</div>
<div class="cb"></div>
<p><strong>WINE CELLAR CELLER</strong></p>
<ul>
<li>House wine <em>Vi de la Casa</em></li>
<li>Soda water <em>Gasosa</em></li>
<li>Soft drink <em>Refresc</em></li>
<li>Mineral Water <em>Aigua</em></li>
<li>1 beer included <em>1 Cerveza</em></li>
</ul>
<p><strong>DESSERTS <em>POSTRES</em></strong></p>
<ul>
<li>Crême caramel <em>Flam casolà </em></li>
<li>Ice cream<em>Gelats</em></li>
<li>Catalan Custard Cream <em>Crema catalana</em></li>
</ul>
<p><strong>COFFEES<em>CAFÈS, TALLATS</em></strong></p>
</div>
<div id="ressenya" class="caixa-preus caixa-negre caixa-left">
<h6><span class="preu">{preu_2003}</span> Euros/ Per Adult (vat. included)</h6>
<h6><span class="preu">{preu_2004}</span> Euros/ Per Adult with cava (vat. included)</h6>
<hr>
<h6 class="infantil"><span style="font-weight: bold;">– Children’s Menu (children ages 4 to 9) </span><br>
Macaroni, fried chicken breast or croquettes with potatoes, soft drink and ice cream<br>
<span class="preu">{preu_2036}</span> Euros (vat. included)</h6>
<h6 class="infantil"><span style="font-weight: bold;">– Junior Menu (children ages 10 to 14) </span><br>
Macaroni or appetizer, chicken or roast catalan sausage with potatoes, soft drink and ice cream<br>
<span class="preu">{preu_2037}</span> Euros (vat. included)</h6>
</div>
</div>
';

/*******************************************************************************************/
// MENU 2 CEL
/*******************************************************************************************/
	$translate['titol_menu_2027']=$translate['titol_menu_2023']=$translate['titol_menu_2c']='MEN&Uacute; Nº 2 CELEBRACIÓN';
	$translate['menu_2027']=$translate['menu_2023']=$translate['menu_2c']=' 
<div id="menu-2001" class="menu-content">
<p><strong>STARTERS <em>ENTRANTS</em></strong><br>
<i>All shared in table</i></p>
<ul>
<li>Long pork sausage <em>Llonganissa</em></li>
<li>Chorizo sausage <em>Xoriço</em></li>
<li>Jabugo Paté <em>Paté de Jabugo</em></li>
<li>Salad <em>Amanida</em></li>
<li>Escalivada (roast aubergine, onion and pepper) <em>Escalivada</em></li>
<li>All i Oli (garlic mayonnaise) <em>All i Oli</em></li>
<li>Toasted bread with tomato <em>Pa torrat amb tomàquet</em></li>
</ul>
<p><strong>SECOND COURSES <em>SEGONS</em></strong></p>
<ul>
<li>Haricot beans with salted pork <em>Mongetes amb cansalada</em></li>
<li>Fried Potatoes <em>Patates fregides</em></li>
</ul>
<div class="cb"></div>
<p><strong>GRILLED MEAT <em>GRAELLADA</em></strong><br>
<i>Single</i></p>
<ul class="plat1">
<li>Lamb 2 pieces<em>Xai</em></li>
<li>Rabbit 1/4<em>Conill</em></li>
<li>Roast catalan sausage 1/2<em>Botifarra</em></li>
</ul>
<div class="complements">
<h6>ACCESSORIES</h6>
<p>  If you do not want barbecue, you can add accessories:</p>
<ul class="dots">
<li class="field">Roast veal chop <em>Costella de vedella a la brasa</em>  <span class="field field2" style="font-size:0.8em"><span class="preu">9.50</span>€</span></li>
<li><span class="field">Roast lamb back <em>Espatlla de xai a la brasa</em></span> <span class="field field2" style="font-size:0.8em"><span class="preu">10.40</span>€</span></li>
<li><span class="field">Roast pork feet <em>Espatlla de xai a la brasa</em></span> <span class="field field2" style="font-size:0.8em"><span class="preu">10.25</span>€</span></li>
<li><span class="field">Roast cod <em>Bacallà a la llauna&gt;</em></span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Roast snails <em>Cargols a la llauna</em></span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Roast gilthead <em>Moixarra a la brasa</em></span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Roast sea bass <em>Lubina a la brasa</em></span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
</ul>
</div>
<div class="cb"></div>
<p><strong>WINE CELLAR <em>CELLER</em></strong></p>
<ul>
<li>House wine <em>Vi de la Casa</em></li>
<li>Soda water <em>Gasosa</em></li>
<li>Soft drink <em>Refresc</em></li>
<li>Mineral water <em>Aigua</em></li>
<li>1 beer included <em>1 Cerveza</em></li>
</ul>
<p><strong>DESSERTS <em>POSTRES</em></strong></p>
<ul>
<li>celebration Massini cake <em>Pastís celebració massini</em></li>
</ul>
<p><strong>COFFEES <em>TALLATS</em></strong></p>
<div id="ressenya" class="caixa-preus caixa-negre caixa-left">
<h6><span class="preu">{preu_2027}</span> Euros / adult with cava (vat. Included)</h6>
<h6 class="infantil"><span style="font-weight: bold;">– Children’s Menu (children ages 4 to 9) </span><br>
Macaroni, fried chicken breast or croquettes with potatoes, soft drink and ice cream<br>
<span class="preu">{preu_2037}</span> Euros/unit (vat. included)</h6>
<h6 class="infantil"><span style="font-weight: bold;">– Junior Menu (children ages 10 to 14)</span><br>
Macaroni or appetizer, chicken or roast catalan sausage with potatoes, soft drink and ice cream<br>
<span class="preu">{preu_2036}</span> Euros/unit (vat. included)</h6>
</div>
</div>
';

/*******************************************************************************************/
// MENU 3
/*******************************************************************************************/
	$translate['titol_menu_2012']=$translate['titol_menu_3']='MEN&Uacute; Nº 3';
	$translate['menu_2012']=$translate['menu_3']='
<div id="menu-2012" class="menu-content">
<p><strong>STARTERS <em>ENTRANTS</em></strong><br>
All shared in table</p>
<ul>
<li>Salad <em>Amanida</em></li>
<li>Escalivada (Roasted red peppers and aubergine) <em>Escalivada </em></li>
<li>Assorted pates <em>Assortit de patés</em></li>
<li>Long pork sausage <em>Llonganissa de pagès</em></li>
<li>Chorizo sausage from Salamanca <em>Xoriço de Salamanca</em></li>
<li>Toasted bread with tomato and garlic <em>Pa torrat amb tomàquet i alls</em></li>
<li>All i Oli (garlic mayonnaise) <em>All i Oli</em></li>
</ul>
<p><strong>ROAST MEAT <em>GRAELLADA</em></strong><br>
<i>Single</i></p>
<ul class="plat1">
<li>Roast catalan sausage 1/2<em>Butifarra a la brasa</em></li>
<li>Roast chicken 1/4<em>Pollastre a la brasa</em></li>
<li>Roast rabbit 1/4<em>Conill a la brasa</em></li>
<li>Fried Potatoes Patates fregides</li>
<li>Haricot beans with salt pork <em>Mongeta amb cansalada</em></li>
</ul>
<div class="complements">
<h6>ACCESSORIES</h6>
<p>  If you do not want barbecue, you can add accessories:</p>
<ul class="dots">
<li class="field">Roast veal chop <em>Costella de vedella a la brasa</em>  <span class="field field2" style="font-size:0.8em"><span class="preu">9.50</span>€</span></li>
<li><span class="field">Roast lamb back <em>Espatlla de xai a la brasa</em></span> <span class="field field2" style="font-size:0.8em"><span class="preu">10.40</span>€</span></li>
<li><span class="field">Roast pork feet <em>Espatlla de xai a la brasa</em></span> <span class="field field2" style="font-size:0.8em"><span class="preu">10.25</span>€</span></li>
<li><span class="field">Roast cod <em>Bacallà a la llauna&gt;</em></span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Roast snails <em>Cargols a la llauna</em></span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Roast gilthead <em>Moixarra a la brasa</em></span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Roast sea bass <em>Lubina a la brasa</em></span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
</ul>
</div>
<div class="cb"></div>
<p><strong>WINE CELLAR <em>CELLER</em></strong></p>
<ul>
<li>House wine<em>Vi de la Casa</em></li>
<li>Soda water <em>Gasosa</em></li>
<li>Soft drink <em>Refresc</em></li>
<li>Mineral water <em>Aigua</em></li>
<li>1 beer included <em>1 Cerveza</em></li>
</ul>
<p><strong>DESSERTS <em>POSTRES</em></strong></p>
<ul>
<li>Crême caramel <em>Flam casolà </em></li>
<li>Ice cream<em>Gelats</em></li>
<li>Catalan Custard Cream <em>Crema catalana</em></li>
</ul>
<p><strong>COFFEES <em>CAFÈS, TALLATS </em></strong></p>
<div id="ressenya" class="caixa-preus caixa-negre caixa-left">
<h6><span class="preu">{preu_2012}</span> Euros adults (vat. included)</h6>
<h6 class="infantil"></h6>
</div>
</div>
';

/*******************************************************************************************/
// MENU 4
/*******************************************************************************************/
	$translate['titol_menu_2007']=$translate['titol_menu_4']='MEN&Uacute; Nº 4';
	$translate['menu_2007']=$translate['menu_4']='
<div id="menu-2001" class="menu-content">
<hr>
<div class="alert alert-info">This menu will only be available up to 20 people. If you would like more of this number, please notify us in advance</div>
<p>&nbsp;</p>
<p><strong>STARTERS <em>ENTRANTS</em></strong></p>
<ul>
<li>Assortment&nbsp;of grilled/roasted vegetables&nbsp;with “romesco” sauce<em> Variat de verdures a la brasa<br>
</em><code>(per person)</code><p></p>
<ul>
<li>Aubergine <em>Alberginia</em></li>
<li>Pepper <em>Pebrot</em></li>
<li>Courgette <em>Carbassó</em></li>
<li>Asparagus <em>Esparrecs</em></li>
<li>Artichokes (in season) <em>Carxofes (temporada)</em></li>
</ul>
</li>
</ul>
<p><strong>GRILLED MEATS <em>CARNS A LA BRASA</em></strong><br>
<code>(Individual serving of your choice)</code></p>
<ul class="plat1">
<li>Rabbit <em>Conill</em></li>
<li>Catalan sausage <em>Botifarra</em></li>
<li>Chicken <em>Pollastre</em></li>
<li>Pork “secret”<em>Secret de pork</em></li>
<li>Pork jaw <em>Galta de porc</em></li>
<li>Pork feet <em>Peus de porc&nbsp;</em></li>
</ul>
<p>&nbsp;</p>
<p><!--


<div class="complements">
  

<h6>ACCESSORIES</h6>


  If you do not want barbecue, you can add accessories:
  

<ul class="dots">
    

<li class="field">Roast veal chop <em>Costella de vedella a la brasa</em>  <span class="field field2" style="font-size:0.8em">[cb_preu_plat id=2051]€</span></li>


    

<li><span class="field">Roast lamb back <em>Espatlla de xai a la brasa</em></span> <span class="field field2" style="font-size:0.8em">[cb_preu_plat id=2050]€</span></li>


    

<li><span class="field">Roast cod <em>Bacallà a la llauna></em></span> <span class="field field2" style="font-size:0.8em">[cb_preu_plat id=2055]€</span></li>


    

<li><span class="field">Roast snails <em>Cargols a la llauna</em></span> <span class="field field2" style="font-size:0.8em">[cb_preu_plat id=2052]€</span></li>


    

<li><span class="field">Roast gilthead <em>Moixarra a la brasa</em></span> <span class="field field2" style="font-size:0.8em">[cb_preu_plat id=2053]€</span></li>


    

<li><span class="field">Roast sea bass <em>Lubina a la brasa</em></span> <span class="field field2" style="font-size:0.8em">[cb_preu_plat id=2054]€</span></li>


  </ul>


</div>


--></p>
<div class="cb"></div>
<p><strong>SIDE DISHES <em>GUARNICIONS</em></strong></p>
<ul>
<li>Haricot beans with salted pork <em>Mongetes amb cansalada</em></li>
<li>Fried Potatoes <em>Patates fregides&nbsp;</em></li>
<li>All i Oli (garlic mayonnaise) <em>All i Oli</em></li>
<li>Toasted bread with tomato <em>Pa torrat amb tomàquet</em></li>
</ul>
<p><strong>WINE CELLAR <em>CELLER</em></strong></p>
<ul>
<li>House wine or Sangria <em>Vi de la Casa o Sangria</em></li>
<li>Soda water <em>Gasosa</em></li>
<li>Mineral water <em>Aigua</em></li>
<li>Soft Drink <em>Refrescs</em></li>
</ul>
<p><strong>DESSERTS <em>POSTRES</em></strong></p>
<ul>
<li>Crême caramel <em>Flam casolà </em></li>
<li>Ice cream <em>Gelats</em></li>
<li>Catalan Custard Cream <em>Crema catalana</em></li>
</ul>
<p><strong>COFFEES <em>CAFÈS, TALLATS</em></strong></p>
<p>&nbsp;</p>
<div id="ressenya" class="caixa-preus caixa-negre caixa-left"><span class="preu">{preu_2007}</span> Euros (vat. included)</div>
</div>
';

/*******************************************************************************************/
// MENU comunio
/*******************************************************************************************/
	$translate['titol_menu_2013']=$translate['titol_menu_comunio']='MEN&Uacute; COMUNION';
	$translate['menu_2013']=$translate['menu_comunio']='
<div id="menu-2001" class="menu-content">
<p><strong>VERMOUTH <em>VERMUT</em></strong></p>
<ul>
<li>Beer</li>
<li>Soft drink</li>
</ul>
<p>&nbsp;</p>
<p><strong>APERITIFS <em>APERITU</em></strong></p>
<ul>
<li>Chips <em>Patates xips</em></li>
<li>Salted almonds <em>Atmetlles salades</em></li>
<li>Stuffed olives <em>Olives farcides</em></li>
<li>Deep fried squid rings <em>Calamars a la romana</em></li>
<li>Omelette peices <em>Tacs truita</em></li>
</ul>
<p><strong>STARTERS <em>PRIMERS</em></strong></p>
<ul>
<li>Individual appetisers <em>Entremesos individual</em></li>
<li>Salad and pates <em>Amanida i Patés</em></li>
<li>Toasted bread with tomato <em>Pa torrat amb tomàquet</em></li>
</ul>
<p><strong>SECOND COURSE (GRILLED) <em>SEGONS (Graellada)</em></strong></p>
<ul>
<li>Fried Potatoes <em>Patates fregides</em></li>
<li>Lamb <em>Be</em></li>
<li>Catalan black sausage <em>Botifarra negra</em></li>
<li>Rabbit <em>Conill</em></li>
<li>Chicken <em>Pollastre</em></li>
<li>Catalan sausage <em>Botifarra</em></li>
<li>All i Oli (garlic mayonnaise) <em>All i Oli</em></li>
</ul>
<p><strong>CELEBRATION CAKE <em>PASTÍS DE CELEBRACIÓ</em></strong></p>
<p>&nbsp;</p>
<p><strong>WINE CELLAR <em>CELLER</em></strong></p>
<ul>
<li>Cabernet red or rosé <em>Vi Cabernet negre o rosat</em></li>
<li>Brut reserva <em>Cava Brut Reserva</em></li>
<li>Water and Soft drinks <em>Aigua i refrescs</em></li>
</ul>
<p><strong>COFFEES<em>TALLATS</em></strong></p>
<p>&nbsp;</p>
<div id="ressenya" class="caixa-preus caixa-negre caixa-left">
<h6><span class="preu">{preu_2013}</span> Euros / adult &nbsp;(vat. Included)</h6>
<hr>
<h6 class="infantil"><span style="font-weight: bold;">– Children’s Menu (children ages 4 to 9) </span><br>
<span class="preu">{preu_2017}</span> Euros/unit (vat. included)</h6>
<h6 class="infantil"><span style="font-weight: bold;">– Junior Menu (children ages 10 to 14)</span><br>
<span class="preu">{preu_2018}</span> Euros/unit (vat. included)</h6>
</div>
</div>
';

/*******************************************************************************************/
// MENU casament
/*******************************************************************************************/
	$translate['titol_menu_2016']=$translate['titol_menu_casament']='MEN&Uacute; BODA';
	$translate['menu_2016']=$translate['menu_casament']='
<div class="panel-body"><strong>APERITIFS <em>APERITU</em></strong>
<ul>
<li>Prawns <em>Llagostins</em></li>
<li>Chips<em> Patates xips</em></li>
<li>Salted almonds <em>Atmetlles salades</em></li>
<li>Stuffed olives <em>Olives farcides</em></li>
<li>Deep fried squid rings <em>Calamars a la romana</em></li>
<li>Omelette peices <em>Tacs truita</em></li>
<li>Sorbet <em>Sorbet</em></li>
</ul>
<p>&nbsp;</p>
<p><strong>STARTERS <em>PRIMERS</em></strong></p>
<ul>
<li>Appetisers <em>Entremesos</em></li>
<li>Salad <em>Amanida</em></li>
<li>Escalivada (roast aubergine, onion and pepper) <em>Escalivada</em></li>
<li>Asparagus <em>Espàrrecs</em></li>
<li>Roast mushrooms <em>Gírgoles</em></li>
<li>Toasted bread with tomato <em>Pa torrat amb tomàquet</em></li>
</ul>
<p><strong>SECOND COURSE (GRILLED) <em>SEGONS (Graellada)</em></strong></p>
<ul>
<li>Lamb <em>Xai</em></li>
<li>Catalan black sausage <em>Botifarra negra</em></li>
<li>Rabbit <em>Conill</em></li>
<li>Chicken <em>Pollastre</em></li>
<li>Catalan sausage <em>Botifarra</em></li>
<li>All i Oli (garlic mayonnaise) <em>All i Oli</em></li>
</ul>
<p><strong>WEDDING CAKE <em>PASTÍS DE CASAMENT</em></strong></p>
<p>&nbsp;</p>
<p><strong>WINE CELLAR <em>CELLER</em></strong></p>
<ul>
<li>Cabernet red or rosé <em>Vi Cabernet negre o rosat</em></li>
<li>Brut reserva Sardà <em>Cava Brut Reserva Sardà</em></li>
<li>Water and Soft drinks <em>Aigua i refrescs</em></li>
</ul>
<p>&nbsp;</p>
<p><strong>COFFEES <em>TALLATS</em></strong></p>
<p>&nbsp;</p>
<p><strong>Includes floral center piece<em> Inclós centre de flors&nbsp;</em></strong></p>
<div id="ressenya" class="caixa-preus caixa-negre caixa-left">
<h6><span class="preu">{preu_2016}</span> Euros / adult &nbsp;(vat. Included)</h6>
<hr>
<h6 class="infantil"><span style="font-weight: bold;">– Children’s Menu (children ages 4 to 9) </span><br>
<span class="preu">{preu_2011}</span> Euros/unit (vat. included)</h6>
<h6 class="infantil"><span style="font-weight: bold;">– Junior Menu (children ages 10 to 14)</span><br>
<span class="preu">{preu_2022}</span> Euros/unit (vat. included)</h6>
</div>
</div>
';

/*******************************************************************************************/
// MENU calsots
/*******************************************************************************************/
	$translate['titol_menu_2010']=$translate['titol_menu_calsots']='MEN&Uacute; CALÇOTADA';
	$translate['menu_2010']=$translate['menu_calsots']='
<div class="panel-body"><div class="alert alert-warning">
   <span class="glyphicon glyphicon-info-sign" style="font-size:1em">  The calçotada menu cannot be combined with other menus. <b>All assistants must ask for the same.</b>   </span>
</div>
<p><strong>STARTERS <em>ENTRANTS</em></strong></p>
<ul>
<li>CALÇOTS , soft&nbsp;spring&nbsp;onions (in season)<br>
    <i><code>No calçots limit</code><br>
<code>Cannot be combined with other menus (all of you must order calçotada)</code><br>
</i>
</li>
<li>Haricot beans with salted pork <em>Mongetes amb cansalada</em></li>
<li>Fried Potatoes <em>Patates fregides&nbsp;</em></li>
<li>All i Oli (garlic mayonnaise)<em> All i Oli</em></li>
<li>Toasted bread with tomato <em>Pa torrat amb tomàquet</em></li>
</ul>
<p>&nbsp;</p>
<p><strong>GRILLED MEAT <em>GRAELLADA</em> (individual)</strong></p>
<ul class="plat1">
<li>Lamb <em>Xai</em> (2 pieces)</li>
<li>Rabbit <em>Conill</em> (1/4)</li>
<li>Catalan sausage <em>Botifarra</em> (1/2)</li>
</ul>
<div class="complements">
<h6>ACCESSORIES</h6>
<p>  If you do not want barbecue, you can add accessories:</p>
<ul class="dots">
<li class="field">Roast veal chop <em>Costella de vedella a la brasa</em>  <span class="field field2" style="font-size:0.8em"><span class="preu">9.50</span>€</span></li>
<li><span class="field">Roast lamb back <em>Espatlla de xai a la brasa</em></span> <span class="field field2" style="font-size:0.8em"><span class="preu">10.40</span>€</span></li>
<li><span class="field">Roast pork feet <em>Peus de porc</em></span> <span class="field field2" style="font-size:0.8em"><span class="preu">4.00</span>€</span></li>
<li><span class="field">Roast cod <em>Bacallà a la llauna&gt;</em></span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Roast snails <em>Cargols a la llauna</em></span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Roast gilthead <em>Moixarra a la brasa</em></span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Roast sea bass <em>Lubina a la brasa</em></span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
</ul>
</div>
<div class="cb"></div>
<p><strong>WINE CELLAR <em>CELLER</em></strong></p>
<ul>
<li>House wine <em>Vi de la Casa</em></li>
<li>Soda water <em>Gasosa</em></li>
<li>Soft drink <em>Refresc</em></li>
<li>Mineral water <em>Aigua</em></li>
<li>1 Beer included</li>
</ul>
<p><strong>DESSERTS <em>POSTRES</em></strong></p>
<ul>
<li>Crême caramel <em>Flam casolà </em></li>
<li>Lemon sorbet <em>Copa sorbet llimona</em></li>
<li>Catalan Custard Cream <em>Crema catalana</em></li>
</ul>
<p><strong>COFFEES  <em>TALLATS </em></strong></p>
<p>&nbsp;</p>
<div id="ressenya" class="caixa-preus caixa-negre caixa-left">
<h6><span class="preu">{preu_2010}</span> Euros/ adults (vat. included)</h6>
<h6><span class="preu">{preu_2011}</span> Euros/ adults with CAVA(vat. included)</h6>
<h6 class="infantil"><span style="font-weight: bold;">-Children’s Menu (children ages 4 to 9) </span><br>
Macaroni, fried chicken breast or croquettes with potatoes, soft drink and ice cream<br>
<span class="preu">{preu_2037}</span> Euros/unit (vat. included)</h6>
<h6 class="infantil"><span style="font-weight: bold;">– Menú Junior</span> (de 10 a 14 anys)<br>
Macaroni or appetizer, chicken or roast catalan sausage with potatoes, soft drink and ice cream<br>
<span class="preu">{preu_2036}</span> Euros/unit (vat. included)</h6>
</div>
</div>
';


/*******************************************************************************************/
// MENU VEGETARIÀ
/*******************************************************************************************/
	$translate['titol_menu_990060']=$translate['titol_menu_vegetaria']='MEN&Uacute; VEGETARIÀ';
	$translate['menu_990060']=$translate['menu_vegetaria']='
<div id="menu-2008" class="menu-content">
<p>&nbsp;</p>
<p>On this menu you can choose one from the&nbsp;following:</p>
<ul>
<li>Xatonada (Endive, cod and anchovy salad served with dressing) <em>Xatonada</em></li>
<li>Salad <em>Amanida</em></li>
<li>Oyster mushrooms <em>Gírgoles</em></li>
<li>Asparagus <em>Espàrrecs</em></li>
<li>Escalivada (Roasted red peppers and aubergine) <em>Escalivada</em></li>
<li>Roast artichokes (in season) <em>Carxofes (temporada)</em></li>
<p> 	<!-- 

<li>Calçots, (<span style="line-height: 1.5;">Barbecued spring onions, served with Romesco&nbsp;sauce) -&nbsp;</span>(in season) <em>Calçots (temporada)</em></li>

 --></p>
<li>Grilled vegetables <em>Graellada de verdures&nbsp;</em></li>
</ul>
<p>&nbsp;</p>
<p><strong>Accompaniment with</strong></p>
<ul>
<li>Beans <em>Mongetes</em></li>
<li>Chips&nbsp;<em>Patates fregides&nbsp;</em></li>
<li>All i Oli (garlic mayonnaise)&nbsp;<em>All i Oli</em></li>
<li>Tomato and garlic toasted bread <em>Pa torrat amb tomàquet</em></li>
</ul>
<p><strong>DESSERTS <em>POSTRES</em></strong></p>
<ul>
<li>Seasonal fruit</li>
<li>Crême caramel <em>Flam casolà </em></li>
<li>Lemon Mus<em>Mus de llimona</em></li>
<li>Icecream<em>Helado</em></li>
</ul>
<p><strong>Drinks and coffees </strong></p>
<p>&nbsp;</p>
<div id="ressenya" class="caixa-preus caixa-negre caixa-left">
<span class="preu">{preu_2008}</span> Euros/ Per Adult (vat. included)<p></p>
</div>
</div>
';


/*******************************************************************************************/
/*******************************************************************************************/
/*******************************************************************************************/
/*******************************************************************************************/
/*******************************************************************************************/
/*******************************************************************************************/
// INFANTILS / JUNIORS
/*******************************************************************************************/
	$translate['titol_menu_2037']=$translate['titol_menu_infantil']='
Men&uacute; Infantil (ni&ntilde;os de 4 a 9 a&ntilde;os)';
	$translate['menu_2037']=$translate['menu_infantil']='
<div id="menu-2001" class="menu-content">
<ul>
<li>Macaroni</li>
<li>Fried chicken breast or croquettes with potatoes</li>
<li>Soft drink</li>
<li>Ice cream</li>
</ul>
<div id="ressenya" class="caixa-preus caixa-negre caixa-left"><span class="preu">{preu_2037}</span> Euros (vat. included)
</div>
</div>
';

	$translate['titol_menu_2036']=$translate['titol_menu_junior']='Men&uacute; Junior (de 10 a 14 a&ntilde;os)';
	$translate['menu_2036']=$translate['menu_junior']='Macarrones o entrem&eacute;s, pollo o butifarra con patatas, refresco y helado<br/>
{preu_2036} Euros/unidad (IVA incluido)
';

	$translate['titol_menu_2017']=$translate['titol_menu_inf_comunio']='Men&uacute; Comunión (ni&ntilde;os de 4 a 9 a&ntilde;os)';
	$translate['menu_2017']=$translate['menu_inf_comunio']='{preu_2017} Euros';
	
	$translate['titol_menu_2018']=$translate['titol_menu_jun_comunio']='Men&uacute; Comunión (ni&ntilde;os de 10 a 14 a&ntilde;os)';
	$translate['menu_2018']=$translate['menu_jun_comunio']='{preu_2018} Euros';
	

	$translate['titol_menu_2021']=$translate['titol_menu_inf_casament']='Men&uacute; Boda (ni&ntilde;os de 4 a 9 a&ntilde;os)';
	$translate['menu_2021']=$translate['menu_inf_casament']='{preu_2021} Euros ';
	
	$translate['titol_menu_2022']=$translate['titol_menu_jun_casament']='Men&uacute; Boda (ni&ntilde;os de 10 a 14 a&ntilde;os)';
	$translate['menu_2022']=$translate['menu_jun_casament']='{preu_2022} Euros ';
	
        
        $translate['AVIS_MODIFICACIONS'] = '<span style = "color: red"> 
         <b> Attention: </b> </span>Until 12 hours before the reservation time <b> you can inform us of any change</b>  in the number of places by calling from 10 to 11 o’clock in the morning 
          <b>935 803 632</b> or <b>936 929 723</b>.<br/> Later than 2 hours <b>we cannot make any changes</b> to the reservation and only the places reserved will be available. 
          <br/>Before the day, you can also edit your reservation using the same section of our web page. 

                                            <br><div style="background-color:#feffb2;padding:4px;margin:12px 0;"><span style="color:red">
                                            <b>IMPORTANT: </b></span><b>Es cobraran {import_no_assitencia}€ per cada comensal 
                                            que no assisteixi al dinar.</b></div>

          <span class = "tanca-avis" style = ""> <a href="#">close</a> </span>';        


        $translateJS['MENUS_COMENSALS']="You should choose the same amount of menus as diners (adults + juniors + children)";
        
/*******************************************************     ERRORS   ***********************************/	
        
        
	require_once('translate_en.php');
	
        
        
        
	?>

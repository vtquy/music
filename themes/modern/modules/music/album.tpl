<!-- BEGIN: main -->
 <div id="searchcontent">
 <div class="box-border m-bottom"> 
 <div class="header-block1"> 
 <h3>{LANG.all_album}
 <span {active_1}><a href="{hot}">{LANG.album_hotest}</a></span>
 <span {active_2}><a href="{new}">{LANG.album_newest}</a></span></h3> 
 </div> 
 	<h2 class="album">{LANG.there_are} {num} album</h2>
	<!-- BEGIN: loop -->
	<div class="resuirt">
 		<a href="{url_listen}" class="namealbum">
 		<img class="album" width="90px" height="90px" border="0" src="{thumb}" />
		<div id="album">
 			<p style="width: 350px;"><strong>{name}</strong></a></p>
 			<p>{LANG.show_1}: <a href="{url_search_singer}">{singer}</a></p>
 			<p>{LANG.who_create_1}: <a href="{url_search_upload}">{upload}</a> | {LANG.view}: {view}</p>
 		</div>
	 	<div id="boder"></div>
 	</div>
	<!-- END: loop -->
  <div class="clear"></div>
 </div>
</div>
<!-- END: main -->
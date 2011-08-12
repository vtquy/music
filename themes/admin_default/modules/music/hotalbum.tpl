<!-- BEGIN: main -->
<table class="tab1">
	<thead>
		<tr>
			<td width="20px">STT</td>
			<td>{LANG.album_name}</td>
			<td width="100px" align="center">{LANG.hot_album_select}</td>
		</tr>
	</thead>
	<!-- BEGIN: row -->
	<tbody{class}>
		<tr>
			<td align="center">
                <select name="weight" id="weight{ID}" onchange="nv_chang_hotalbum_weight({ID});">
                    <!-- BEGIN: stt -->
                    <option value="{pos}"{selected}>{pos}</option>
                    <!-- END: stt -->
                </select>
			</td>
			<td>{album}</td>
			<td>
				<span class="add_icon">
					<a href="{LINK_ADD}">{LANG.hot_album_add}</a>
					&nbsp;&nbsp;
				</span>
			</td>
		</tr>
	</tbody>
	<!-- END: row -->
</table>
<!-- END: main -->

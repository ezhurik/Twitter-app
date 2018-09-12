<?php $this->load->view('common/header') ?>
<style>
#ui-id-2 .ui-menu-item {
    height: 30px!important;
}

#ui-id-2{
	height: 240px;
	overflow: auto;
}

</style>

<main id="main">

	<section id="facts" class="wow fadeIn" style="min-height: 380px;">
		<div class="container">      		
			<div class="row">
				<div class="col-md-6">
					<form action="/action_page.php">
						<div class="form-group">
							<label for="username">Search User</label>
							<input type="text" class="form-control" id="username">
						</div>
					</form>
				</div>
				<div class="col-md-1">
				</div>
				<div class="col-md-5" id="formatsDiv" style="display: none;">
					<div class="row" id="downloadDiv">
						
					</div>
				</div>
			</div>

			

		</div>
	</section>

</main>

<?php $this->load->view('common/footer') ?>

<script>
	$( document ).ready(function() {
		var pdf="pdf";
		var xml="xml";
		$('#nav-menu-container').hide();

		$("#username").autocomplete({
			source: function (request, response) {
				$.ajax({
					type: 'post',
					url: BASE_URL+"home/searchUser",
					data: {keyword: request.term},
					dataType: "json",
					success: function (data) {
						response($.map(data, function (item)
						{
							return{
								label: item.screen_name,
								value: item.name
							}
						}));
					}
				});
			},
			minLength: 2,
			select: function (event, ui) {
				var userName = ui.item.label;
				$('#username').val(userName);
				$('ui-id-1').css('display','none');

				$("#formatsDiv").css('display','block');	

				var downloadHtml='<div"><h4>Download '+userName+'\'s followers in following format</h4></div>';
				downloadHtml+='<div style="text-align:center" class="pb-2">';
				downloadHtml+='<a href="javascript:void(0)" onclick="downloadFollowers( \'' + userName + '\' , \'' + pdf + '\')" ><span class="pr-3">PDF</span></a>';
				downloadHtml+='<a href="javascript:void(0)" onclick="downloadFollowers( \'' + userName + '\' , \'' + xml + '\')" ><span class="pr-3">XML</span></a>';
				$('#downloadDiv').html(downloadHtml);

			}
		}).autocomplete("instance")._renderItem = function (ul, item) {
			var appendData = "<p>" + item.label + " </p>";

			return $("<li></li>")
			.data("item.autocomplete", item)
			.append(appendData)
			.appendTo(ul);
		};
	});	

	function downloadFollowers($name,$type)
		{
			$.ajax({
				type: 'post',
				url: BASE_URL+"home/downloadFollowers",
				data: {'type': $type,'username':$name,'all':'1' },
				xhrFields: {
					responseType: 'blob'
				},
				beforeSend: function(msg){
					$.LoadingOverlay("show");
				},
				success: function (blob) {
					var link=document.createElement('a');
					link.href=window.URL.createObjectURL(blob);
					link.download=$name+$.now() + "." + $type;
					link.click();
				},
				complete: function(){
					$.LoadingOverlay("hide");
				}
			});
		}

</script>
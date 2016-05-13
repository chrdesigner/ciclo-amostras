// <![CDATA[
	jQuery(function($) {
		
		$(".link_info").click(function () {

			var id = $(this).attr("id").replace(/^.(\s+)?/, "");
			var contentTobeLoaded = $("#aba_" + id).html();          

			$('#ajax').html(contentTobeLoaded).fadeIn(10, function () {
				//do whatever you want after fadeIn
			});
		});

	});
// ]]>
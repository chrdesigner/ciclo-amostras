// <![CDATA[
	jQuery(function($) {
		
		$('.clickable-row').click(function() {
	        window.document.location = $(this).data('href');
	    });

		$(".nav-links").hide(); //Hide all content
		$("#nav-informacoes ul li:first").addClass("active").show(); //Activate first tab
		$(".nav-links:first").show(); //Show first tab content

		//On Click Event
		$("#nav-informacoes ul li").click(function() {
			
			$("#nav-informacoes ul li").removeClass("active"); //Remove any "active" class
			
			$(this).addClass("active"); //Add "active" class to selected tab
			
			$(".nav-links").hide(); //Hide all tab content
			
			var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
			
			$(activeTab).fadeIn(); //Fade in the active content
			
			return false;
			
		});


	});
// ]]>
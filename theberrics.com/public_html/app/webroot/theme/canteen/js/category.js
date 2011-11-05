$(document).ready(function() { 


	$('.canteen-product-thumb').hover(
		function() { 

			$(this).find('.info').fadeIn();
			
		},
		function() { 

			$(this).find('.info').hide();
			
		}
	).click(function() { 

		var ref = $(this).find("a").attr("href");

		document.location.href = ref;
		
	});

	$('.canteen-product-thumb a').click(function() { 

		return false;

	});


	$("#reveal").click(function() { 

		$('.canteen-product-thumb').each(function() { 

			$(this).find('.info').toggle('slow');
			
		});
		
	});

	$('#filter-form input').change(function() { 

		$("#filter-form").submit();

	});

	$("#filter-form").submit(function() { 

		var q = $(this).formSerialize();

		document.location.href="?"+unescape(q);
		
		return false;
		
	});

	$("#filter-form label").hover(
		function() {

			$(this).css({"text-decoration":"underline"});

		},
		function() {

			$(this).css({"text-decoration":"none"});

		}
	);

	initCheckboxes();
	
	
	
});

function initCheckboxes() {

	$("#filter-form input[type=checkbox]:checked").each(function() {

		$(this).parent().addClass("checkbox-checked");
		
	});
	
}

(function($){
		
	$(document).ready(function(){

		$('input.box-text').bind('focus blur', function(){
			$(this).toggleClass('focus');
		});
                
                $('a.btn-search').bind('click', function(event){
                    searchTerm = encodeURIComponent($.trim($("#search_bar").val()));
                    searchTerm = searchTerm.replace("%20", "+");

                    if(searchTerm != '') {
                        window.location = '/' + searchTerm + '/1';
                    }
                    event.preventDefault();
                })

		$('.bg-thumbnail-img').hover(function(){
			$(this).find('.overlay').show();
			$(this).find('.overlay').next().css({'opacity': 0.1});
		},function(){
			$(this).find('.overlay').hide();
			$(this).find('.overlay').next().css({'opacity': 1});
		});

	});


})(jQuery);

function parseURL(url) {
    var a =  document.createElement('a');
    a.href = url;
    return {
        source: url,
        protocol: a.protocol.replace(':',''),
        host: a.hostname,
        port: a.port,
        query: a.search,
        params: (function(){
            var ret = {},
                seg = a.search.replace(/^\?/,'').split('&'),
                len = seg.length, i = 0, s;
            for (;i<len;i++) {
                if (!seg[i]) { continue; }
                s = seg[i].split('=');
                ret[s[0]] = s[1];
            }
            return ret;
        })(),
        file: (a.pathname.match(/\/([^\/?#]+)$/i) || [,''])[1],
        hash: a.hash.replace('#',''),
        path: a.pathname.replace(/^([^\/])/,'/$1'),
        relative: (a.href.match(/tps?:\/\/[^\/]+(.+)/) || [,''])[1],
        segments: a.pathname.replace(/^\//,'').split('/')
    };
}

(function($){
		
	$(document).ready(function(){

		$('input.box-text').bind('focus blur', function(){
			$(this).toggleClass('focus');
		});
                /*********SEARCH WIDGET************/
                $('a.btn-search').bind('click', function(event){
                    searchTerm = encodeURIComponent($.trim($("#search_bar").val()));
                    searchTerm = searchTerm.replace("%20", "+");
                    searchTerm = searchTerm.toLowerCase();

                    if(searchTerm != '') {
                        window.location = '/' + searchTerm ;
                    }
                    event.preventDefault();
                });
                
                $('#search_bar').keypress(function (e) {
                    var key = e.which;
                    if(key == 13)  // the enter key code
                     {
                       $('a.btn-search').click();
                       event.preventDefault();  
                     }
                });
                /***********SEARCH WIDGET ENDS******/
                /*************FLIPBOOK*************/
                i = 1;
                $('.flipbook-thumb').hover(function() {
                    thumb = this;
                    //redtube default format http://img03.redtubefiles.com/_thumbs/0000730/0730052/0730052_013m.jpg
                    originalImg = imgSrc = $(this).attr('src');
                    
                    change_thumbs = setInterval(function(){
                        myURL = parseURL(imgSrc);
                        fileName = myURL.file;
                        thumbId = myURL.segments[2];
                        
                        if(i > 15) {i = 1;}
                        
                        if(i < 10) {
                           number = "0" + i;
                        } else {
                           number = i;
                        }
                        i++;
                        
                        imgSrc = imgSrc.replace(fileName, thumbId + '_0' + number + 'm.jpg');
                        $(thumb).attr('src',imgSrc);
                    }, 700);    
                       
		},function(){
                        clearInterval(change_thumbs);
			$(thumb).attr('src', originalImg);
		});
                 /*************FLIPBOOK ENDS*************/

	});
})(jQuery);
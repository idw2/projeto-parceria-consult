/* Begin */
jQuery(document).ready(function(){

//Home Url
$home_url = jQuery('#home-url').attr('class');

/*= Preload
*************************************************/
    function addLoadEvent(func){
        var oldonload = window.onload;
        if(typeof window.onload != 'function'){
            window.onload = func;
        }else{
            window.onload = function(){
                oldonload();
                func();
            }
        }
    }

/*= Init Nav
*************************************************/
    jQuery('ul.nav').superfish({
        //animation: {height:'show'},   // slide-down effect without fade-in
        delay:     10,               // 1.2 second delay on mouseout
        dropShadows:   true
    });

/*= Header Search Form
*************************************************/
    function change_search(){
        $input_node = jQuery('#header-search input[type="text"]');
        $input_node.focus(function(){
            jQuery(this).stop(true,true).animate({
                width:'145px'
            },100);
        });
        $input_node.blur(function(){
            jQuery(this).stop(true,true).animate({
                width:'100px'
            },100);
        })
    }
    change_search();
    
/*= News Ticker
---------------------------------------------------------------------*/
    var newsTicker = jQuery('li.news-ticker');
    var tickerTimeId = 0;
    var currentNews = 0;
    var olderNews = 0;
    var sumNews = jQuery(newsTicker).size();

    function newsTickerInit(){
        jQuery(newsTicker).eq(0).fadeIn();
        newsTickerClick();
        tickerTimeId = setInterval(autoTicherScroll,6000);
    }
    newsTickerInit();

    function newsTickerClick(){
        jQuery(newsTicker).each(function(index){
            if(!jQuery(this).children('a').is(':hidden')){
                currentNews = index;
            }
        });
        jQuery('a.headline-previous').click(function(){
            clearInterval(tickerTimeId);
            olderNews = currentNews;
            if(currentNews == 0){
                currentNews = sumNews-1;
            }else{
                currentNews = currentNews-1;
            }
            jQuery(newsTicker).eq(olderNews).stop(true,true).fadeOut().queue(function(){
                jQuery(newsTicker).eq(currentNews).stop(true,true).fadeIn();
            });

            tickerTimeId = setInterval(autoTicherScroll,6000);
        });
        jQuery('a.headline-next').click(function(){
            clearInterval(tickerTimeId);
            olderNews = currentNews;
            if(currentNews == sumNews-1){
                currentNews = 0;
            }else{
                currentNews = currentNews+1;
            }
            jQuery(newsTicker).eq(olderNews).stop(true,true).fadeOut().queue(function(){
                jQuery(newsTicker).eq(currentNews).stop(true,true).fadeIn();
            });
            tickerTimeId = setInterval(autoTicherScroll,6000);
        });
    }

    function autoTicherScroll(){
        olderNews = currentNews;
        if(currentNews == sumNews-1){
            currentNews = 0;
        }else{
            currentNews = currentNews+1;
        }
        jQuery(newsTicker).eq(olderNews).stop(true,true).fadeOut().queue(function(){
            jQuery(newsTicker).eq(currentNews).stop(true,true).fadeIn();
        });
    }

/*= Slider Function
*************************************************/
    function slider_init(){
        var firstSlider = jQuery('.slides_container .hentry').eq(0);
        jQuery(firstSlider).css('height',jQuery(firstSlider).height()+'px').queue(function(){
            slider();
            jQuery("#slider").slideDown();
            jQuery('#slider a.next, #slider a.prev').css('display','block');
            jQuery('.slides_container').css('padding','0 0 0 0');
            jQuery(this).dequeue();
        });
    }
    	addLoadEvent(slider_init);

    function slider(){
        jQuery("#slider").slides({
                preload: true,
                preloadImage: $home_url+'/images/loader-white.gif',
				pause: 5000,
				hoverPause: true,
                effect: 'slide',
                next: 'next',
                prev: 'prev',
                play : 10000
        });
    }

    
/*= Correct Css
*************************************************/
    function correct_css(){
        jQuery('embed').each(function(){
            jQuery(this).attr('wmode','opaque');
        });
    }
    correct_css();

/*= Iframe Correct
*************************************************/
    function iframe_correct(){
        jQuery("iframe").each(function(){
            var ifr_source = jQuery(this).attr('src');
            var wmode = "wmode=transparent";
            if(ifr_source.indexOf('?') != -1) {
                var getQString = ifr_source.split('?');
                var oldString = getQString[1];
                var newString = getQString[0];
                jQuery(this).attr('src',newString+'?'+wmode+'&'+oldString);
            }else{
                jQuery(this).attr('src',ifr_source+'?'+wmode);
            }
        });
    }
    iframe_correct();

/*= Response Layout
*************************************************/
    function response_layout(){
            jQuery('#slider').show();
    }
    jQuery(window).bind("resize", response_layout);
    response_layout();

});

(function() {
   
    var rss = {
        
        rss_url : 'http://zendguru.wordpress.com/feed/',
        feed : '#feed',
        alex_rss_content_class : 'alex_rss_content',
        question: 'do you want to print this article?',
        print : 'for_print',
        display_noneClass : 'display_none',
        alreadyAppendStyleToHead : 0,
    
        initialize : function () { 
            this.extend();
            this.modules();
            this.setUpListeners();
            this.initializeOtherPlugins();
        },
        extend : function () {
            $.extend(this, APP);
        }, 
        modules: function () {
         
        },
        initializeOtherPlugins : function()
        {
            this.initializeGoogleRssreader();
        }, 
        setUpListeners: function () {
            //if you click to article text you need to have question if you want to print clicked article
             $(this.feed).on('click', '.'+this.alex_rss_content_class, this,  $.proxy(this.askPrintQuestion, this));
        },
        askPrintQuestion : function (event) {
                var result = confirm(this.question);
                if ( result ) {
                    this.printArticle(event);
                }

        },
        printArticle : function (event) {  
            var $targetElement = $(event.currentTarget);
            var itsHtml = $targetElement.html();
            //div where we will have content for printing
            var printElement = $('#'+this.print);
            if ( ! printElement.length ) {
                printElement = jQuery('<div>',{class:this.display_noneClass, id:this.print});
                $('body').append(printElement);
            }
            //find div and puth content
            printElement.html(itsHtml);
            if ( ! this.alreadyAppendStyleToHead ) {
                var style = jQuery("<style>", {media:'print'}).append("body>.container, body>nav {display:none;}  body>div#"+this.print+" (display:block !important;)");
                $('head').append(style);
                this.alreadyAppendStyleToHead = 1;
            }           
            // print page
            window.print() ;
        },
        initializeGoogleRssreader : function () {
            google.load("feeds", "1");
            google.setOnLoadCallback(this.gooleinItialize);
            
        },
        gooleinItialize : function () {
  
            var feed = new google.feeds.Feed(rss.rss_url);
            
            feed.load(function(result) {
            if (!result.error) {         
                var container = jQuery(rss.feed);  
                var ul = jQuery('<ul>');           

                for (var i = 0; i < result.feed.entries.length; i++) {                   
                        var entry = result.feed.entries[i]
                        var li = jQuery('<li>');
                        var a = jQuery('<a>', {
                            href: entry.link,
                            title: entry.title,
                            target : entry.link,
                            text: entry.title
                        });
                        var content = jQuery('<div/>', {
                           class: rss.alex_rss_content_class,
                           html: entry.content
                        });
                        // off all links on the content
                        content.find('a').click(function(){return false;});
                        li.append(a);
                        li.append(content);
                        
                        ul.append(li);
                }
                container.append(ul);
            }
          });
        }
    }
  
    rss.initialize();
 
}());



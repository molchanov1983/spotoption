(function() {
   
    var rss = {
        
        rss_url : 'http://zendguru.wordpress.com/feed/',
    
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

        },
        initializeGoogleRssreader : function () {
            google.load("feeds", "1");
            google.setOnLoadCallback(this.gooleinItialize);
            
        },
        gooleinItialize : function () {
  
            var feed = new google.feeds.Feed(rss.rss_url);
            
            feed.load(function(result) {
            if (!result.error) {         
                var container = document.getElementById("feed");            
                var ul = document.createElement('ul');           

                for (var i = 0; i < result.feed.entries.length; i++) {                   
                        var entry = result.feed.entries[i]
                        var li = document.createElement('li');
                        var a = document.createElement('a');
                        a.innerHTML = entry.title;
                        a.href = entry.link;
                        a.target = entry.link;
                        li.appendChild(a);
                        ul.appendChild(li);
                }
                container.appendChild(ul);
            }
          });
        }
    }
  
    rss.initialize();
 
}());



(function() {

   window.APP = {
        
        displayNone : 'display_none',
        
        initialize : function () {
            
        },
        ajax : function (params)
        {
            var obj = '';
            jQuery.ajax({
                url: params.url,
                type: params.type || "POST",
                data: params.data || '',
                async:params.async || false,
                cache: params.cache || false,                
           
                success: function(jsonstr) {
//                    console.log(jsonstr);
//                    return false;
                   obj =  jQuery.parseJSON( jsonstr );            
                },

            });
            return obj;
        },  
   
    },  


    APP.initialize();
 
}());
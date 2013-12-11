(function() {
   
    var customersAndCalls = {
    
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
          
        }, 
        setUpListeners: function () {

        }      
    }
  
    customersAndCalls.initialize();
 
}());
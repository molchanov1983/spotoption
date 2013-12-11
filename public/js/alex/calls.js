(function() {
   
    var calls = {
        //form 
        form : '#calls',
        $form : $('#calls'),
        //span or div
        for_server_error : '#for_server_error',
        //jquery templates
        onecall_tmpl : '#onecall-tmpl',
        //table
        callTableClass : 'tab-calls',
        // tag "a" (delete and update)        
        editCallClass : 'edit_call',
        deleteCallClass : 'delete_call',
        //button update 
        alexUpdateButtonClass : 'alex_update',
        // we have 2 buttons one of them has attribute name is "add" and the other "update" 
        submitAttrNameAdd : 'calls[add]',
        submitAttrNameUpdate : 'calls[update]',
        
       
        
        initialize : function () { 
            this.extend();
            this.modules();            
            this.initializeOtherPlugins();
            this.setUpListeners();
        },
        extend : function () {
            $.extend(this, APP);
        },
 
        modules: function () {
          
        },
        initializeOtherPlugins : function()
        {
            this.initializeJqueryTmpl();
            this.initializeJqueryValidate();
        }, 
        setUpListeners: function () {
            // i donot need to create this because i use jquery validate plugin which if validation is true calss formsubmit function automatically
            //  this.$form.on('submit', '', this,  $.proxy(this.submitForm, this))
            //edit call
             $('.'+this.callTableClass).on('click', 'a.'+this.editCallClass, this,  $.proxy(this.editCall, this));
            //delete call
            $('.'+this.callTableClass).on('click', 'a.'+this.deleteCallClass, this,  $.proxy(this.deleteCall, this));
            
            
        },
        initializeJqueryTmpl : function () {
            this.insertAllCallToTable();
        },
        initializeJqueryValidate : function () {
            var self = this;   
            
            this.$form.validate({
               rules: {
                        customers: {required: true },
                        subject: {required: true },
                        content: {required: true },      
                      },
                messages: {
                        customers: {required: "needs to be not empty"},
                        subject: {required: "needs to be not empty"},
                        content: {required: "needs to be not empty"},
                },
                 submitHandler : function (form) {
                     var $clickedButton = $(this.submitButton);      
                     var isNew = false;
                     if ( self.submitAttrNameUpdate === $clickedButton.attr('name') ) {
                         //here clicked update
                         self.$form.attr('action','/calls/edit/'+$clickedButton.data('id'));
                     } else {
                         isNew = true;
                         //here clicked add new call
                         self.$form.attr('action','/calls/add');
                     }

                     var emptyStr = '';
                     self.showOrHideMessageFromServer(emptyStr);
                     //show ajax sign
                     $("body").mask("Loading...");
                     self.submitForm(isNew);
                     
                 }
              });
        },
        //isNew - true it means we try to add new call   false - update existing call
        submitForm : function (isNew) {   
            var params = {};
            params.url = this.$form.attr('action');
            params.data = this.$form.serialize();
            
            var response_obj = this.ajax(params);
           //hide update button
            this.hideUpdateButton();           
             
          if(response_obj.error instanceof Object || response_obj.error !== '') {
               var errorMsg = response_obj.error;
               if (response_obj.error instanceof Object) {
                   errorMsg =  this.addErrorMessageToDom(response_obj.error);
               }  
               this.showOrHideMessageFromServer(errorMsg);
               $("body").unmask();
               //clear all inputs
               this.$form.find('input[type=text]').val('');
               return false;
           } else {
                //clear all inputs
                this.$form.find('input[type=text]').val('');
                //delete mask from all window
                $("body").unmask();
                 //add new call to the end of list
                 if ( isNew ) {
                     // new call
                     this.addNewCall(response_obj.response);                  
                 } else {
                     //update call
                     this.updateExistingCall(response_obj.response);   
                 }
                      
           }
      
        },
        hideUpdateButton : function () {
            var button = $('.'+this.alexUpdateButtonClass);
            if ( ! button.hasClass(this.displayNone) ) {
                $('.'+this.alexUpdateButtonClass).addClass(this.displayNone); 
            }
            
        },
        addNewCall : function (response_obj) {

                $('.'+this.callTableClass).append($(this.onecall_tmpl).tmpl(response_obj));  
        },
        updateExistingCall : function (response_obj){

            var $tr = $('.'+this.callTableClass).find('.tr_'+response_obj.id);
            $tr.replaceWith($(this.onecall_tmpl).tmpl(response_obj));  
           
        },
        addErrorMessageToDom : function (objError) {            
            var text = '';
            $.each(objError, function( index, valueObj ) {
                text +=  'server error field - '+index+' , message - ' ;
                $.each(valueObj, function (errName, errMessage) {
                    text +=  errMessage + ' ' ;
                });
           });
           return text;
           
        },
        showOrHideMessageFromServer : function (msg){
            $(this.for_server_error).text(msg);
        },
        insertAllCallToTable : function () {
           var self = this;
           var whereAppend = $('.'+this.callTableClass);
           $.each(callsList, function (index, value){
               whereAppend.append($(self.onecall_tmpl).tmpl(value));  
           });

        },
        deleteCall : function (event) {
            $("body").mask("Loading...");
            event.preventDefault();
            var $target = $(event.target);
       
            //create ajax for delete
            var params = {};
            params.url = $target.attr('href');
            
            var response_obj = this.ajax(params);
            if (response_obj.error.length) {
                //here i have error from server 
                this.showOrHideMessageFromServer(response_obj.error);
                $("body").unmask();
                return false;
            }
            $target.parents('tr').remove();
            $("body").unmask();
   
        },
        editCall : function (event) {
            event.preventDefault();
            var $target =$ (event.target);
            var tr = $target.parents('tr');
            //get all data fro inserting into form
            var trDataForForm = tr.data('tmplItem').data;
            var allInputs =  this.$form.find('input[type=text]');
    
            $.each(allInputs , function(index, input) {
                var $input = $(input);
                var name = $input.attr('name');
                $input.val(trDataForForm[name]);
            });
             this.$form.find('select option').filter(function () { 
                        return $(this).html() == trDataForForm.customerFirstName; 
                    }).prop('selected', true);
        
            var buttonInputs =  $('.'+this.alexUpdateButtonClass).removeClass(this.displayNone);
            buttonInputs.data('id', trDataForForm.id);
            
        }
      
    }
  
    calls.initialize();
 
}());



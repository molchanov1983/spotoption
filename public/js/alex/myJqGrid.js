jQuery("#list2").jqGrid({
   // treeGrid: true,
    treeGridModel: 'adjacency',
    ExpandColumn : 'calls',
    ExpandColClick: true,
	datatype: "local",
    data : dataGrid,
   	colNames:['call id','subject', 'content', 'customer id','firstName','lastName','phone','address','status'],
   	colModel:[
   		{name:'id',index:'id', width:55},
   		{name:'subject',index:'subject', width:90},
   		{name:'content',index:'content', width:100},
   		{name:'customerid',index:'customerid', width:80, align:"right"},
        {name:'firstName',index:'firstName', width:80, align:"right"},
        {name:'lastName',index:'lastName', width:80, align:"right"},
        {name:'phone',index:'phone', width:80, align:"right"},
        {name:'address',index:'address', width:80, align:"right"},
        {name:'status',index:'status', width:80, align:"right"},

   	],


   	rowNum:10,
   	rowList:[10,20,30],
   	pager: '#pager2',
   	sortname: 'id',
    viewrecords: true,
    sortorder: "desc",
    caption:"JSON Example"
});
jQuery("#list2").jqGrid('navGrid','#pager2',{edit:false,add:false,del:false});
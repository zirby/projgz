/**
 * @author Christian ZIRBES
 * GCD
 * Gestion Cabinet Dentaire
 */

$(document).ready(function(){
	
	var url;
	var dateoftheday= new Date();
	var aujourdhui="";
/******************  les combos ***********************/
$('#cc').calendar({  
    width:180,  
    height:180, 
    fit:true, 
    current:dateoftheday,
    onSelect:function(date){
		var y = date.getFullYear();
		var m = date.getMonth() + 1;
		var d = date.getDate();
		var datecal=y + '-' + (m < 10 ? '0' + m : m) + '-' + (d < 10 ? '0' + d : d) ;
		$('#fm').form('submit',{
			url: url+'&s_pay_le='+datecal,
			onSubmit: function(){
				return $(this).form('validate');
			},
			success: function(result){
				var result = eval('('+result+')');
				if (result.success){
					$('#dlgVirements').dialog('close');		// close the dialog
					$('#dgVirements').datagrid('reload');	// reload the user data
					console.log("Save Virements OK");
				} else {
					console.log("Save Virements error");
				}
			}
    	})
    } 
	});  
	
	$('#dd').datebox({
		formatter : function(date) {
			var y = date.getFullYear();
			var m = date.getMonth() + 1;
			var d = date.getDate();
			return (y + '-' + (m < 10 ? '0' + m : m) + '-' + (d < 10 ? '0' + d : d) );
		},
		onSelect:function searchToday(date){
			var y = date.getFullYear();
			var m = date.getMonth() + 1;
			var d = date.getDate();
			aujourdhui=y + '-' + (m < 10 ? '0' + m : m) + '-' + (d < 10 ? '0' + d : d) ;
			console.log(aujourdhui);
			$('#dgToday').datagrid('load',
			{  
	        	searchToday: aujourdhui
	    	});  
		}

	});
	 
	$('#cmbAnnees').combobox({  
	    url:'php/cmb_annees.php',  
	    valueField:'an',  
	    textField:'an' ,
		onSelect:function searchVirement(data){
			console.log(data);
			$('#dgVirements').datagrid('load',{  
        		searchAn: data.an,  
		    });
 		}
	}); 
	
	$('#cmbAnneesBil').combobox({  
	    url:'php/cmb_annees.php',  
	    valueField:'an',  
	    textField:'an' ,
		onSelect:function graphBil(data){
		    graphdata = [];	    
		   	alreadyFetched = {};
			console.log(data);
			$.ajax({
            url: 'php/graph_paran.php' ,
            data: { searchAn: data.an},
            method: 'GET',
            dataType: 'json',
            success: onDataReceived
        	});
 		}
	}); 
	
	$('#cmbAnnees').combobox('setValue',dateoftheday.getFullYear());

	$('#cmbMoisBil').combobox({  
	    url:'php/mois_fr.json',  
	    valueField:'id',  
	    textField:'text' ,
		onSelect:function graphBil_m(data){
		    graphdata_m = [];	    
		   	alreadyFetched_m = {};
			console.log(data);
			$.ajax({
            url: 'php/graph_parmois.php' ,
            data: { searchMois: data.id},
            method: 'GET',
            dataType: 'json',
            success: onDataReceived_m
        	});
 		}
	    
	});	
	//$('#cmbMoisBil').combobox('setValue',dateoftheday.getMonth()+1);

	$('#cmbMoisAnniv').combobox({  
	    url:'php/mois_fr.json',  
	    valueField:'id',  
	    textField:'text'  ,
		onSelect:function searchAnniv(data){
			console.log(data);
			$('#dgAnniv').datagrid('load',{  
        		searchAnnivMois: data.id 
		    });
 		}
	    
	});	
	$('#cmbMoisAnniv').combobox('setValue',dateoftheday.getMonth()+1);

	
	
	
/*************************** graphique année par mois */
    var options = {
        bars: { show: true },
        xaxis:{ticks:[[1,"JAN"],[2,"FEV"],[3,"MAR"],[4,"AVR"],[5,"MAI"],[6,"JUN"],[7,"JUI"],[8,"AOU"],[9,"SEP"],[10,"OCT"],[11,"NOV"],[12,"DEC"]]}
    };
    var placeholder = $("#placeholder");
    
    var graphdata = [];	    
   	var alreadyFetched = {};
	$.plot(placeholder, graphdata, options);
	
	/* graphique 1 mois par année */
    var options_m = {
        lines: { show: true },
        points: { show: true }
    };
    var placeholder_m = $("#placeholder_m");
    
    var graphdata_m = [];	    
   	var alreadyFetched_m = {};
	$.plot(placeholder_m, graphdata_m, options_m);

/******************************* graphique 1 mois par année */
    var options_g = {
        lines: { show: true },
        points: { show: true},
        grid: { hoverable: true, clickable: true }
    };
    var placeholder_g = $("#placeholder_g");
    
    var graphdata_g = [];	    
   	var alreadyFetched_g = {};
	$.plot(placeholder_g, graphdata_g, options_g);
	
	
/************************************ Gestion virements */
	$('#btnPrintVir').click(function printVirements(){
		console.log($('#cmbAnnees').combobox('getValue'));
 		var url = "php/print_virements.php?searchAn="+$('#cmbAnnees').combobox('getValue');
        var windowName = "Virements";//$(this).attr("name");
        var windowSize = "width=500,height=700,scrollbars=yes";
 
        window.open(url, windowName, windowSize);
 
   });
	$('#btnEditVirements').click(function editVirement(){
		var row = $('#dgVirements').datagrid('getSelected');
		if (row){
			$('#dlgVirements').dialog('open').dialog('setTitle','Virement Payé le');
			$('#fm').form('load',row);
			url = 'php/save_virements.php?id='+row.id;
		}
	});

	$('#btnNonPaye').click(function saveTProduits(){
		$('#fm').form('submit',{
			url: url,
			onSubmit: function(){
				return $(this).form('validate');
			},
			success: function(result){
				var result = eval('('+result+')');
				if (result.success){
					$('#dlgVirements').dialog('close');		// close the dialog
					$('#dgVirements').datagrid('reload');	// reload the user data
					console.log("Save Virements OK");
				} else {
					console.log("Save Virements error");
				}
			}
    	});
	});

    
	$('#btnPrintToday').click(function printToday(data){
		console.log(data);
 		var url = "php/print_today.php?searchToday="+aujourdhui;
        var windowName = "Recette";//$(this).attr("name");
        var windowSize = "width=500,height=700,scrollbars=yes";
 
        window.open(url, windowName, windowSize);
   });
    $('#btnGlobalReload').click(function globalReload(data){
	    graphdata_g = [];	    
	   	alreadyFetched_g = {};
		console.log(data);
		$.ajax({
        url: 'php/graph_g.php' ,
        method: 'GET',
        dataType: 'json',
        success: onDataReceived_g
    	});
    	
    	
    });
    


/************************************************ gestion graphic */
	    function onDataReceived(series) {
	        // extract the first coordinate pair so you can see that
	        // data is now an ordinary Javascript object
	        var firstcoordinate = '(' + series.data[0][0] + ', ' + series.data[0][1] + ')';
	
	        // let's add it to our current data
	        if (!alreadyFetched[series.label]) {
	            alreadyFetched[series.label] = true;
	            graphdata.push(series);
	        }
	        
	        // and plot all we got
	        $.plot(placeholder, graphdata, options);
	     }

	    function onDataReceived_m(series) {
	        // extract the first coordinate pair so you can see that
	        // data is now an ordinary Javascript object
	        var firstcoordinate = '(' + series.data[0][0] + ', ' + series.data[0][1] + ')';
	
	        // let's add it to our current data
	        if (!alreadyFetched_m[series.label]) {
	            alreadyFetched_m[series.label] = true;
	            graphdata_m.push(series);
	        }
	        
	        // and plot all we got
	        $.plot(placeholder_m, graphdata_m, options_m);
	     }
	     
	    function onDataReceived_g(series) {
	        // extract the first coordinate pair so you can see that
	        // data is now an ordinary Javascript object
	        var firstcoordinate = '(' + series.data[0][0] + ', ' + series.data[0][1] + ')';
	
	
	        // let's add it to our current data
	        if (!alreadyFetched_g[series.label]) {
	            alreadyFetched_g[series.label] = true;
	            alreadyFetched_g[series.symbol] = "diamond";
	            graphdata_g.push(series);
	        };
	        
	        // and plot all we got
	        $.plot(placeholder_g, graphdata_g, options_g);
	    };

    function showTooltip(x, y, contents) {
        $('<div id="tooltip">' + contents + '</div>').css( {
            position: 'absolute',
            display: 'none',
            top: y + 5,
            left: x + 5,
            border: '1px solid #fdd',
            padding: '2px',
            'background-color': '#fee',
            opacity: 0.80
        }).appendTo("tab_g").fadeIn(200);
    }

    var previousPoint = null;
    $("#placeholder_g").bind("plothover", function (event, pos, item) {
        $("#x").text(pos.x.toFixed(2));
        $("#y").text(pos.y.toFixed(2));

        if ($("#enableTooltip:checked").length > 0) {
            if (item) {
                if (previousPoint != item.dataIndex) {
                    previousPoint = item.dataIndex;
                    
                    $("#tooltip").remove();
                    var x = item.datapoint[0].toFixed(2),
                        y = item.datapoint[1].toFixed(2);
                    
                    showTooltip(item.pageX, item.pageY,
                                "toto");
                }
            }
            else {
                $("#tooltip").remove();
                previousPoint = null;            
            }
        }
    });


});
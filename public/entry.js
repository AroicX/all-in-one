$(document).ready(function(){
    //fetch transaction types belonging to a transaction class and populate the transaction type select fields
     $("#TTC").click(function (e) {
        $(".amt").each(function(){
            $(this).hide();
        });
        console.log(e);
        var id = $(this).val();
          $("#asset_sub_acct").attr('required', false);
        $("#opex_sub_acct").attr('required', false);
        $(".assetsubacc-box").hide();
        $(".opexsubacc-box").hide();
        $(".asset_type").hide();
         $("#asset_type").attr('required', false);
        $('[name="manual_amount"]').val("");
        $('[name="amount"]').val("");
        $('[name="gross"]').val("");
        $('[name="net"]').val("");
        $('[name="vat"]').val("");
        $("#TTN").empty();
        $.ajax({
            type: "GET",
            url: "/corpfin/get_ttn/" + id,
            
            // dataType: "html",
            success: function (data) {

                $('#TTN').empty();
                
                var sel = document.getElementById('TTN');
                var dis_op = document.createElement('option');
                dis_op.text = "Select Transaction Type";
                dis_op.id = "disop";
                sel.appendChild(dis_op);
                $('#disop').attr('selected', true);
                $('#disop').attr('disabled', true);
                for (var key in data) {
                    var name = data[key].name;
                    var opt = document.createElement('option');
                    opt.text = data[key].name;
                    opt.value = data[key].id;
                    sel.appendChild(opt);

                }


                $("#sales_hidden").css({'display': 'visible'});
            }
        });
    });

     //dynamically show the fields relative to a transaction type 
        $("#TTN").change(function (e) {
        console.log(e);
        $(".amt").each(function(){
            $(this).val("");
        });
        $("#asset_sub_acct").attr('required', false);
        $("#opex_sub_acct").attr('required', false);
        $(".assetsubacc-box").hide();
        $(".opexsubacc-box").hide();
        $(".asset_type").hide();
        $(".vat_type").hide();
         $("#asset_type").attr('required', false);
        var ttn = $('#TTN :selected').attr('value');
        //display products or services
        $(".product-box").hide();
        if(ttn == 1 || ttn == 5){
            $(".money").each(function(){
                $(this).attr('readonly', true);
            });
            $("#product").attr('required', true);
            $("#quantity_sold").attr('required', true);   
            $.ajax({
                url: "get_products",
                type: "get",
                
                success : function(data){
                    console.log(data);
                    $("#product").empty();
                    var sel = document.getElementById('product');
                    var dis_op = document.createElement('option');
                    dis_op.text = "Select Product";
                    dis_op.id = "disop";
                    sel.appendChild(dis_op);
                    $('#disop').attr('selected', true);
                    $('#disop').attr('disabled', true);
                     for (var key in data) {
                    var name = data[key].name;
                    var opt = document.createElement('option');
                    opt.text = data[key].name;
                    opt.value = data[key].id;
                    sel.appendChild(opt);
                    $(".product-box").show();


                }
                }
            });
        }
      //populate dropdown with asset sub account details
        if (ttn ==17 || ttn ==18 || ttn ==21 || ttn ==87) {
            $(".assetsubacc-box").show();
            $("#asset_sub_acct").attr('required', true); 
               App.blockUI({
            target: '#blockUI',
            boxed: true,
            textOnly: true,
            message: '<img src="img/spinner.gif" /> Just a moment...'
        });
            $.ajax({
                url: "get_asset_sub_acct",
                type: "get",
                
                success : function(data){
                    console.log(data);
                    $("#asset_sub_acct").empty();
                    var sel = document.getElementById('asset_sub_acct');
                    var dis_op = document.createElement('option');
                    dis_op.text = "Select Asset";
                    dis_op.id = "disop";
                    sel.appendChild(dis_op);
                    $('#disop').attr('selected', true);
                    $('#disop').attr('disabled', true);
                     for (var key in data) {
                    var name = data[key].name;
                    var opt = document.createElement('option');
                    opt.text = data[key].name;
                    opt.value = data[key].id;
                    sel.appendChild(opt);
                   App.unblockUI('#blockUI');

                }
                }
            });
        }

        //populate table with opex sub account details
          if (ttn ==23 || ttn ==24 || ttn ==25 || ttn ==26 || ttn ==28 || ttn ==36 || ttn ==97 || ttn == 27) {
            $(".opexsubacc-box").show();
            $("#opex_sub_acct").attr('required', true); 
               App.blockUI({
            target: '#blockUI',
            boxed: true,
            textOnly: true,
            message: '<img src="img/spinner.gif" /> Just a moment...'
        });
            $.ajax({
                url: "get_opex_sub_acct",
                type: "get",
                
                success : function(data){
                    console.log(data);
                    $("#opex_sub_acct").empty();
                    var sel = document.getElementById('opex_sub_acct');
                   
                     for (var key in data) {
                    var name = data[key].name;
                    var opt = document.createElement('option');
                    opt.text = data[key].name;
                    opt.value = data[key].id;
                    sel.appendChild(opt);
                   App.unblockUI('#blockUI');

                }
                }
            });
        }
        //show vat inclusive and exclusive fields

        if(ttn == 5 || ttn == 6 || ttn == 26  || ttn == 27 || ttn == 28 || ttn == 26 || ttn == 32 || ttn == 33 || ttn == 34 || ttn == 71 ){
            //
            $(".vat_type").show();
        }
         //populate table with asset details
          if (ttn ==22) {
            $(".asset_type").show();
            $("#asset_type").attr('required', true); 
               App.blockUI({
            target: '#blockUI',
            boxed: true,
            textOnly: true,
            message: '<img src="img/spinner.gif" /> Just a moment...'
        });
            $.ajax({
                url: "get_asset_type",
                type: "get",
                
                success : function(data){
                    console.log(data);
                    $("#asset_type").empty();
                    var sel = document.getElementById('asset_type');
                    //var dis_op = document.createElement('option');
                    // dis_op.text = "Select an Asset";
                    // dis_op.id = "disop";
                    
                    // $('#disop').attr('selected', true);
                    // $('#disop').attr('disabled', true);
                    // sel.appendChild(dis_op);
                     for (var key in data) {
                    var name = data[key].name;
                    var opt = document.createElement('option');
                    opt.text = data[key].name;
                    opt.value = data[key].id;
                    sel.appendChild(opt);
                   App.unblockUI('#blockUI');

                }
                }
            });
        }

      if(ttn ==3){
        $(".amt").each(function(){
            
            if($(this).attr('id') != 'amt-box' && $(this).attr('id') != 'markup-box'){
                 
                $(this).hide();
                $(this).val("");
            }
            else{

                $(this).show();
                $(this).attr('required', true);
            }
        });
      }
      else if (ttn == 5 || ttn ==6 || ttn ==26 || ttn == 27 || ttn == 28 || ttn == 32 || ttn == 33 || ttn == 34){
            $(".amt").each(function(){
            
            if($(this).attr('id') != 'gross-box' && $(this).attr('id') != 'amt-box' && $(this).attr('id') != 'net-box' && $(this).attr('id') != 'vat-box'){
                 
                $(this).hide();
                $(this).val("");
            }
            else{

                $(this).show();
                $(this).attr('required', true);
            }
        });
      }
      else if (ttn == 7 || ttn == 8 || ttn == 54){
            $(".amt").each(function(){
            
            if($(this).attr('id') != 'old-box' && $(this).attr('id') != 'new-box' ){
                 
                $(this).hide();
                $(this).val("");
            }
            else{

                $(this).show();
                $(this).attr('required', true);
            }
        });
      }
       else if (ttn == 35){
            $(".amt").each(function(){
            
            if($(this).attr('id') != 'amt-box' && $(this).attr('id') != 'net-box' ){
                 
                $(this).hide();
                $(this).val("");
            }
            else{

                $(this).show();
                $(this).attr('required', true);
            }
        });
      }

       else if (ttn == 35){
            $(".amt").each(function(){
            
            if($(this).attr('id') != 'amt-box' && $(this).attr('id') != 'net-box' ){
                 
                $(this).hide();
                $(this).val("");
            }
            else{

                $(this).show();
                $(this).attr('required', true);
            }
        });
      }

      else if (ttn == 36){
            $(".amt").each(function(){
            
            if($(this).attr('id') != 'used-box' && $(this).attr('id') != 'unused-box' ){
                 
                $(this).hide();
                $(this).val("");
            }
            else{

                $(this).show();
                $(this).attr('required', true);
            }
        });
      }
      else{
        $(".amt").each(function(){
            
            if($(this).attr('id') != 'amt-box' ){
                 
                $(this).hide();
                $(this).val("");
            }
            else{

                $(this).show();
                $(this).attr('required', true);
            }
        });
      }

    });



    //select a particular product and fetch it 
    $("#product").change(function(){
        var product = $(this).val();

        $.ajax({
            type : "get",
            url : "get_product/" + product,
            success : function(data){
                console.log(data);
                $("#amount").val(data[0].price);
                $("#net").val(data[0].net);
                $("#vat").val(data[0].vat);
                $("#gross").val(data[0].gross);
                localStorage.price = data[0].price;
                localStorage.net = data[0].net;
                localStorage.vat = data[0].vat;
                localStorage.gross = data[0].gross;
            }
        });
    });

    //calculate price of product based on quantity sold 
    $("#quantity_sold").keyup(function(){

        var quantity = $(this).val();
        if(isNaN(quantity)){
            alert("Please enter a valid number for quantity sold");

        }
        else{
           
            //alert(localStorage.net);
            var netval = parseFloat(localStorage.net) * parseFloat(quantity);
            var gross = parseFloat(localStorage.gross) * parseFloat(quantity);
            var vat = parseFloat(localStorage.vat) * parseFloat(quantity);
            var amount = parseFloat(localStorage.price) * parseFloat(quantity);

            $("#net").val(netval);
            $("#gross").val(gross);
            $("#vat").val(vat);
            $("#amount").val(amount);
        }
    });

    $("#amount").keyup(function(){
        if(isNaN($(this).val())){
            alert("Please Enter a valid number for amount");
        }
        else{

        var amount = parseFloat($(this).val());
        var vat = (5/105) * amount;
        var netamt = amount - vat;
        var gross = amount;
        
        $("#vat").val(parseFloat(vat).toFixed(2));
        $("#net").val(parseFloat(netamt).toFixed(2));
        $("#gross").val(parseFloat(gross).toFixed(2));
        }
    });

});
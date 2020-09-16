var CorpTax = {};

CorpTax.WHT = function () {


    return{

        /**
         * Upload transactions from an excel sheet
         *
         * @param form
         */
        uploadTransactions:function ( form) {
            var options = {
                url:'/dashboard/corp-tax/WIT/upload/transactions',
                type:'POST',
                dataType:'JSON',
                success:function (response)
                {
                    console.log(response);

                    switch(response.status)
                    {
                    case 'error':
                        toastr.error(response.statusText);
                            break;
                    case 'success':
                        toastr.success(response.statusText);
                        $('#uploadTemplate').modal('hide');
                            break;
                    }
                }
            };

             form.ajaxSubmit(options);
        },

        /**
         * get amount payable by period
         *
         * @param start
         * @param end
         */
        getAmountPayableForPeriod:function(start, end)
        {
            $.ajax(
                {
                    url:'/dashboard/corp-tax/WIT/reports/amount-payable',
                    type:'GET',
                    dataType:'JSON',
                    data:{start:start,end:end},
                    success:function(response)
                {
                        $('input#period_payable').val(response);
                    }
                }
            )
        },

        /**
         * save transaction manually
         *
         * @param form
         */
        saveTransaction:function(form)
        {
            var options = {
                url:'/dashboard/corp-tax/WIT/save/transaction',
                type:'POST',
                dataType:'JSON',
                success:function (response)
                {
                    console.log(response.status);
                    switch(response.status)
                    {
                    case 'error':
                        toastr.error('An error occured. Please try again');
                            break;
                    case 'success':
                        toastr.success('Transaction has been saved successfully');
                        CorpTax.WHT.clearInputs(form);
                            break;
                    }
                }
            };

            form.ajaxSubmit(options);
        },

        /**
         * filter transaction by time
         */
        filterTransactionsByPeriod:function(fromDate,toDate,type)
        {
            $.ajax(
                {
                    url:'/dashboard/corp-tax/WIT/view-transactions/by-period',
                    type :'GET',
                    dataType:'JSON',
                    data:{'from':fromDate,'to':toDate,'type':type},
                    success:function (response)
                {
                        CorpTax.WHT.renderView(response);
                    }
                }
            )

        },

        /**
         * save AccountMovement
         *
         * @param form
         */
        saveAccountMovement:function(form)
        {
            $.ajax(
                {
                    url:'/dashboard/corp-tax/WIT/accountMovement/save',
                    type :'POST',
                    dataType:'JSON',
                    data:form.serialize(),
                    success:function (response)
                {
                        switch (response.status)
                        {
                        case 'success':
                            toastr.success('Account movement has been save successfully');
                            CorpTax.WHT.clearInputs(form);
                            break;
                        case 'error':
                            toastr.error('Something went wrong. Please try again');
                            break;

                        }
                    }
                }
            );
        },

        clearInputs:function (form)
        {
            form.find('input').val('');

        },
        /**
         * Print account movement
         *
         * @returns {boolean}
         */
        printAccountMovement:function()
        {
            var url = '/dashboard/corp-tax/WIT/accountMovement/print';

            $('<iframe id="printFrame" name="printFrame" >').attr('src',url).appendTo('body');
            $("#printFrame").get(0).contentWindow.print();

            setTimeout(
                function(){
                    $("#printFrame").remove();
                },6000
            );

            return false;
        },
        /**
         * Print the WHT Movement schedule
         *
         * @param   fromDate
         * @param   toDate
         * @param   type
 * @returns {boolean}
         */
        printSchedule:function (fromDate,toDate,type)
        {
            fromDate =  !! fromDate ? (Date.parse(fromDate))/1000 : null;
            toDate   =  !! toDate ? (Date.parse(toDate))/1000 : null;

            var url = '/dashboard/corp-tax/WIT/print-schedule/'+type+'/f/'+fromDate+'/t/'+toDate;

            $('<iframe id="printFrame" name="printFrame" >').attr('src',url).appendTo('body');
            $("#printFrame").get(0).contentWindow.print();

            setTimeout(
                function(){
                    $("#printFrame").remove();
                },6000
            );

            return false;
        },

        /**
         * search for a transaction
         */
        search:function(value)
        {
            !value
                ? location.reload()
                : $.ajax(
                    {
                        url :'/dashboard/corp-tax/WIT/search-transactions',
                        type:'GET',
                        dataType:'JSON',
                        data:{data:value},
                        success:function (response) {
                            CorpTax.WHT.renderView(response);
                        }

                    }
                )
        },

        /**
         * Get transaction rate
         *
         * @param companyType
         * @param transactionType
         */
        getWHTRate: function (companyType,transactionType) {

            switch(true)
            {
            case(transactionType == 'Royalties'):
                if(companyType == 'company') {return 10;}
                else if(companyType == 'individual') {return 5;}
                break;
            case(transactionType == 'Dividend,interest and rent'):
                if(companyType == 'company') {return 10;}
                else if(companyType == 'individual') {return 5;}
                break;
            case(transactionType == 'Hire,Rental of equipment, Motor vehicles,Plant and Machinery'):
                if(companyType  == 'company') {return 10;}
                else if(companyType == 'individual') {return 5;}
                   break;
            case(transactionType == 'Building, Construction and related Services'):
                if(companyType  == 'company') {return 2.5;}
                else if(companyType == 'individual') {return 5;}
                   break;
            case(transactionType == 'All types of contracts and agency arrangements other than sales in ordinary course of business'):
                if(companyType  == 'company') {return 5;}
                else if(companyType == 'individual') {return 5;}
                   break;
            case(transactionType == 'Directors fees'):
                if(companyType  == 'company') {return 0;}
                else if(companyType == 'individual') {return 10;}
                   break;


            }


        },
        /*
         * Render transaction view
         *
         * @param data
         */
        renderView:function (data) {

            var tbody  = $('tbody#transactions');
            
             $('tr#transaction-row').remove();

            $.each(
                data,function(index)
                {
                    var htmlData = '<tr id="transaction-row">' +
                    ' <td>'+data[index].vendor_name +'</td>' +
                    ' <td>'+data[index].vendor_address +'</td>' +
                    ' <td>'+data[index].vendor_TIN +'</td>' +
                    ' <td>'+ data[index].nature_of_transaction +'</td>' +
                    ' <td>'+ data[index].transaction_period +'</td>' +
                    ' <td>'+ data[index].transaction_type +'</td>' +
                    ' <td>'+ data[index].invoice_amount +'</td>' +
                    ' <td>'+ data[index].WHT_rate +'</td>' +
                    ' <td>'+ data[index].WHT_amount +'</td>' +
                    '</tr>';

                    tbody.append(htmlData);
                }
            );
        },

        attachEvents:function () {

            /**
             * click event to upload transactions form
             */
            $(document).on(
                'submit','form#transactionUpload',function (event)
                {
                    event.preventDefault();
                    var form = $('form#transactionUpload');
                    CorpTax.WHT.uploadTransactions(form);
                }
            );


            /**
             * submit event to submit form for logging transactions
             */
            $(document).on(
                'submit','form#logTransactionManually',function(event)
                {
                    event.preventDefault();
                    var form = $('form#logTransactionManually');
                    CorpTax.WHT.saveTransaction(form);
                
                }
            );

            /**
             * Click event to print remittance schedule(company)
             */
            $(document).on(
                'click','a#printScheduleCompany',function(event)
                {
                    event.preventDefault();
                    var $fromDate = $("input[name=from_date]").val();
                    var $toDate   = $("input[name=to_date]").val();

                    $toDate || $fromDate
                    ? CorpTax.WHT.printSchedule($fromDate,$toDate,'company')
                     : toastr.info('please,select a date range to print remittance schedule');
                }
            );

            /**
             * Click event to print remittance schedule(individual)
             */
            $(document).on(
                'click','a#printScheduleIndividual',function(event)
                {
                    event.preventDefault();
                    var $fromDate = $("input[name=from_date]").val();
                    var $toDate   = $("input[name=to_date]").val();

                    $toDate || $fromDate
                    ? CorpTax.WHT.printSchedule($fromDate,$toDate,'individual')
                     : toastr.info('please,select a date range to print remittance schedule');
                }
            );


            $(document).on(
                'submit','form#accountMovement',function(e)
                {
                    e.preventDefault();
                    var form  = $(this);
                    CorpTax.WHT.saveAccountMovement(form);
               
                }
            );

            /**
             * click event to filter transaction by date(company)
             */
            $(document).on(
                'click','a#filterScheduleCompany',function(e)
                {
                    e.preventDefault();
                    var $fromDate = $("input[name=from_date]").val();
                    var $toDate   = $("input[name=to_date]").val();

                    $toDate || $fromDate
                    ?  CorpTax.WHT.filterTransactionsByPeriod($fromDate,$toDate,'company')

                    : toastr.info('please,select a date range to filter remittance schedule');
                }
            );

            /**
             *
             */
            $(document).on(
                'click','a#filterScheduleIndividual',function(e)
                {
                    e.preventDefault();
                    var $fromDate = $("input[name=from_date]").val();
                    var $toDate   = $("input[name=to_date]").val();

                    $toDate || $fromDate
                    ? CorpTax.WHT.filterTransactionsByPeriod($fromDate,$toDate,'individual')

                    : toastr.info('please,select a date range to filter remittance schedule');

                }
            );

            /**
             * keyup event to search for transactions
             */
            $(document).on(
                'keyup','input#transaction_search',function (event)
                {
                    event.preventDefault();
                    CorpTax.WHT.search($(this).val());

                }
            );

            /**
             * change event to ge the amount payable for the period
             */

            $('input#start_period').change(
                function (event)
                {
                    event.preventDefault();
                    var start = $(this).val();
                    var end   = $('input#end_period').val();

                    (!!start && !!end) ? CorpTax.WHT.getAmountPayableForPeriod(start,end):'';

                }
            );

            /**
             *
             */
            $('input#end_period').change(
                function (event)
                {
                    event.preventDefault();
                    var end = $(this).val();
                    var start  = $('input#start_period').val();

                    (!!start && !!end) ? CorpTax.WHT.getAmountPayableForPeriod(start,end):'';
                }
            );

            /**
             * click event to print account movement
             */
            $(document).on(
                'click','button#printMovement',function (e) {

                    e.preventDefault();
                    CorpTax.WHT.printAccountMovement();
                }
            );


            /**
             * Change event to prefill closing balance
             */
            $(document).on(
                'change paste keyup',"input[name=payment_for_period]",function (e) {
                    e.preventDefault();
                    var payableForThePeriod = $("input[name=payable_for_period]").val();
                    var balanceBF           = $("input[name=balance_bf]").val();
                    var paymentForPeriod    = $(this).val();
                    var closingBalance;


                    if(payableForThePeriod && paymentForPeriod && balanceBF) {
                         closingBalance = +balanceBF + +payableForThePeriod - paymentForPeriod;
                    }
                    if(!balanceBF && payableForThePeriod && paymentForPeriod) {
                        closingBalance = payableForThePeriod - paymentForPeriod;
                    }

                    $("input[name=closing_balance]").val(closingBalance);


                }
            );

            /**
             * Change event for company type
             */
            $(document).on(
                'change','select#company_type,select#transaction_type',function(e)
                {
                     e.preventDefault();
                         var companyType = $('select#company_type').val();
                         var transactionType = $('select#transaction_type').val();

                    if(companyType && transactionType) {
                         var rate = CorpTax.WHT.getWHTRate(companyType, transactionType);
                        $('input#WHT_rate').val(rate);
                    }
                }
            );

            /**
             * change event to calculate the WHT
             */
            $(document).on(
                'change paste keyup','input#invoice_amount,input#WHT_rate',function (e) {
                    e.preventDefault();
                    var amount =  $('input#invoice_amount').val(),
                    rate = $('input#WHT_rate').val();

                    if(amount && rate) {
                        var WHTAmount = (rate/100) * amount;
                        $('input#WHT_amount').val(WHTAmount);
                    }
                    if(amount == '' || isNaN(amount)) {
                        $('input#WHT_amount').val('');

                    }
                }
            );


        }
    }

}();
'use strict';
const api = window.localStorage.getItem('cpurl').replace(/\s/g, '');
let disallowedLegers = [];
let disallowedSelectedLegers = [];
let totalDisallowed = 0;
let disallowedItems = '';
let citData = null
let disallowedItemsField =  document.getElementById('disallowed-items')
let disallowedTotalField =  document.getElementById('disallowed-total')
let disallowedItemsArray = [];

let corpfinDataCheckbox = document.getElementById('customCheck1')
let from_date = document.getElementById('fromDate')
let to_date = document.getElementById('toDate')

let dcLabel = document.getElementById('dc-label')
let dcValue = document.getElementById('dc-value')
let revenueLabel = document.getElementById('revenue-label')
let revenueValue = document.getElementById('revenue-value')

let gpValue = document.getElementById('gp-value')
let opexLabel = document.getElementById('opex-label')
let opexValue = document.getElementById('opex-value')
let deprLabel = document.getElementById('depr-label')
let deprValue = document.getElementById('depr-value')
let fcLabel = document.getElementById('fc-label')
let fcValue = document.getElementById('fc-value')
let pbtValue = document.getElementById('pbt-value')
let accessableProfitValue = document.getElementById('accessable-profit')
let capitalAllowanceValue = document.getElementById('capital-allowance')
let capitalAllowanceCF = document.getElementById('capital-allowance-cf')
let capitalAllowanceBF = document.getElementById('capital-allowance-bf')
let taxableProfit = document.getElementById('taxable-profit')
let capitalAllowanceUtitlized = document.getElementById('capital-allowance-utilized')
let minimumTax = document.getElementById('minimum-tax')
let cit = document.getElementById('cit')
let eduTaxCheckbox = document.getElementById('apply-edutax');
let eduTaxBox = document.getElementById('edutax-box');
let eduTax = document.getElementById('edu-tax');
let ctl = document.getElementById('ctl');
eduTax.value = 0;
capitalAllowanceBF.value = 0;
/**
 * @method useCorpFinData
 * use corpfin data or entered data
 * @return true | false
 */
const useCorpFinData = () => {
    if(corpfinDataCheckbox.checked)
    {
        if(!from_date.value)
        {
            new PNotify.alert({
                title: 'Validation Error!!',
                text: 'Please select a From: valid date',
                type: 'error'
            });
        }
        if(!to_date.value)
        {
            new PNotify.alert({
                title: 'Validation Error!!',
                text: 'Please select a valid To: date',
                type: 'error'
            });
            return
        }
        
        $.ajax({
            type: "GET",
            url: `${api}/corpfin/cit/compute-cit?type=corpfin_data&from_date=${from_date.value}&to_date=${to_date.value}`,
            // dataType: "html",
            success: function (data) {
                console.log(data)
                console.log('work na')
                if(data.status == 'ok'){
                    citData = data;
                    opexLabel.innerHTML = data.opex_array.sub_account_name
                    opexValue.disabled = true;
                    opexValue.value = data.opex_array.total

                    dcValue.value = data.direct_cost_array.total;
                    dcValue.disabled = true;
                    revenueLabel.innerHTML = data.revenue_array.sub_account_name
                    revenueValue.value = data.revenue_array.total
                    revenueValue.disabled = true;
                    gpValue.value = data.gross_profit
                    gpValue.disabled = true;

                    fcLabel.innerHTML = data.finance_cost_array.sub_account_name
                    fcValue.value = data.finance_cost_array.total
                    fcValue.disabled = true;

                    deprLabel.innerHTML = data.depreciation_array.sub_account_name
                    deprValue.value = data.depreciation_array.total
                    deprValue.disabled = true;
                    pbtValue.value = data.profit_before_tax;
                    accessableProfitValue.value = data.accessable_profit;
                    capitalAllowanceValue.value = data.capital_allowance;
                    minimumTax.value = data.minimum_tax;
                    pbtValue.disabled = true;
                    computeTaxableProfit(capitalAllowanceValue.value, accessableProfitValue.value)
                    applyEdutax()
                }else{
                    console.log(data)
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                 alert("some error");
              }
        });
        return;
    }else{
        new PNotify.alert({
                title: 'Validation Error!!',
                text: 'please check the use corpfin data or enter your data to compute CIT',
                type: 'error'
            });
        return;
    }

}


/**
 *
 *
 *
 */
 const loadDisallowedModal = () => {
    let disallowedId = document.getElementById('disallowed-field').value;
    disallowedLegers = [];
    var new_tbody = document.createElement('disallowed-mtbody');
    $('#disallowed-mtbody').empty();
    $.ajax({
        type: "GET",
        url: `${api}/corpfin/cit/account-ledger/${disallowedId}`,
        // dataType: "html",
        success: function (data) {
            if(data.status == 'success')
            {
                disallowedLegers = data.data;
                var disallowedTbody = document.getElementById("disallowed-mtbody");
                let disallowedTableCount = 0;
                for (var i = 0; i < disallowedLegers.length; i++) {
                    var row = disallowedTbody.insertRow(-1);
                    var cell1 = row.insertCell(0);
                    var cell2 = row.insertCell(1);
                    var cell3 = row.insertCell(2);
                    var cell4 = row.insertCell(3);
                    var cell5 = row.insertCell(4);
                    // var cell6 = row.insertCell(5);
                    
                    disallowedTableCount = disallowedTableCount + 1;
                      cell1.innerHTML = disallowedTableCount;
                      cell2.innerHTML = "<input type='checkbox' type='button' id='"+disallowedLegers[i].id+"' onchange='calcDisallowedItems(this,"+disallowedLegers[i].id+")' />";
                      cell3.innerHTML = disallowedLegers[i].acc_name + ' <br>('+disallowedLegers[i].description +')';
                      cell4.innerHTML = disallowedLegers[i].Cr;
                      cell5.innerHTML = disallowedLegers[i].Dr;
                      
                     
                     // productTableArray.push(productItem)
                }
                //disallowedTbody.style.display = "block";
                
            }

        }
    });
    $('#disallowed-modal').modal('show')
}

/*
 * @method calcDisallowedItems
 * calculate and categories dis allowed items
 *
 */
 const calcDisallowedItems = (row, id) => {
    let checkbox = document.getElementById(id);
    if(checkbox.checked)
    {
        for(var i = 0; i < disallowedLegers.length; i++) {
            if(disallowedLegers[i].id == id )
            {
                let cr = parseFloat(disallowedLegers[i].Cr != null ? disallowedLegers[i].Cr : 0 );
                let dr = parseFloat(disallowedLegers[i].Dr != null ? disallowedLegers[i].Dr : 0);
                let sum = (cr + dr)
                totalDisallowed += sum;
                disallowedItems = disallowedItems+', '+disallowedLegers[i].description; 
                accessableProfitValue.value = (parseFloat(accessableProfitValue.value) + parseFloat(sum))
                disallowedItemsArray.push(disallowedLegers[i])
            }

            // return;
        }
        disallowedItemsField.value = disallowedItems
        disallowedItemsField.disabled = true
        disallowedTotalField.value = totalDisallowed
        disallowedTotalField.disabled = true
        
    }else{
        for(var i = 0; i < disallowedLegers.length; i++) {
            if(disallowedLegers[i].id == id )
            {
                let cr = parseFloat(disallowedLegers[i].Cr != null ? disallowedLegers[i].Cr : 0 );
                let dr = parseFloat(disallowedLegers[i].Dr != null ? disallowedLegers[i].Dr : 0);
                let sum = (cr + dr)
                totalDisallowed -= sum;
                disallowedItems = disallowedItems.replace(', '+disallowedLegers[i].description, ''); 
                disallowedItemsField.value = disallowedItems
                accessableProfitValue.value = (parseFloat(accessableProfitValue.value) - parseFloat(sum))
                for(var i = 0; i < disallowedItemsArray.length; i++) {
                    console.log(disallowedItemsArray[i].id);
                    if(disallowedItemsArray[i].id == id )
                    {
                        disallowedItemsArray.splice(i, 1);
                    }
                }
            }

            // return;
        }
        disallowedItemsField.disabled = true
        disallowedTotalField.value = totalDisallowed
        disallowedTotalField.disabled = true
        
    }
    computeTaxableProfit(capitalAllowanceValue.value, accessableProfitValue.value)
 }

 /**
  * @method applyEdutax
  * calculate taxable profits
  * @param capitalAllowance, accessableProfit
  */
  const applyEdutax = () => {
    if(eduTaxCheckbox.checked)
    {
        eduTaxBox.style.display = 'contents';
        eduTax.value = (0.02 * accessableProfitValue.value).toFixed(2);
    }else{
        eduTax.value = 0;
        eduTaxBox.style.display = 'none';
    }
    calcCTL()
 }
 /**
  * @method calcCTL
  * calculate coporate tax liability
  * @param 
  */
  const calcCTL = () => {
    //console.log()
    ctl.value = parseFloat(eduTax.value) + parseFloat(cit.value);
  }
 /**
  * @method computeTaxableProfit
  * calculate taxable profits
  * @param capitalAllowance, accessableProfit
  */

  const computeTaxableProfit = (capital_allowance, accessible_profit) => {
    let accessibleProfitPercentage = (accessible_profit - ((66/100) * accessible_profit));
    //let taxableProfit = 0;
    if(capital_allowance == accessibleProfitPercentage)
    {
        taxableProfit.value = accessible_profit - accessibleProfitPercentage;
        capitalAllowanceCF.value = 0;
        capitalAllowanceUtitlized.value = accessibleProfitPercentage;
    }
    if(capital_allowance > accessibleProfitPercentage)
    {
        taxableProfit.value = accessible_profit - accessibleProfitPercentage;
        capitalAllowanceCF.value = capital_allowance - accessibleProfitPercentage
        capitalAllowanceUtitlized.value = accessibleProfitPercentage;
    }
    if(capital_allowance < accessibleProfitPercentage)
    {
        taxableProfit.value = accessible_profit - capital_allowance
        capitalAllowanceCF.value = 0;
        capitalAllowanceUtitlized.value = capital_allowance;

    }
    let taxableProfit_30_percent = (0.3 * taxableProfit.value);
    cit.value = Math.max.apply(Math,[taxableProfit_30_percent, citData.minimum_tax ]).toFixed(2);
    applyEdutax();
    calcCTL();
  }


/**
 * @method saveCIT
 * save entire cit_report
 *
 */
const saveCIT = () => {
    console.log(disallowedItemsArray)
     //console.log(accessibleProfitPercentage)
    let data = {
                'to_date': to_date.value,
                'from_date': from_date.value,
                'gross_profit': gpValue.value,
                'revenue': revenueValue.value,
                'direct_cost': dcValue.value,
                'operating_cost': opexValue.value,
                'finance_cost': fcValue.value,
                'depreciation': deprValue.value,
                'profit_before_tax': pbtValue.value,
                'capital_allowance': capitalAllowanceValue.value,
                'coporate_income_tax': cit.value,
                'coporate_tax_liability': ctl.value,
                'minimum_tax': minimumTax.value,
                'edu_tax': eduTax.value,
                'taxable_profit': taxableProfit.value,
                'capital_allowance_cf': capitalAllowanceCF.value,
                'capital_allowance_utitlized': capitalAllowanceUtitlized.value,
                'capital_allowance_bf': capitalAllowanceBF.value,
                'accessable_profit': accessableProfitValue.value,
                'disallowed_items': disallowedItemsField.value,
                'disallowed_value': disallowedTotalField.value 
            }
            console.log(data)
    swal({
            title: "Are you sure you want to save this CIT Report?",
            text: "Once saved, data cannot be edited!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((action) => {
            if (action) {
                $.ajax({
                    type: "POST",
                    url: `${api}/corpfin/cit/save-computed-cit`,
                    dataType: 'json',
                    data:data,
                    success: function (data) {
                        if (data.status == 'ok') {
                            swal(data.msg, {
                                icon: "success",
                            });
                        }
                        if (data.result == 'error') {
                            swal('Server Error Please Try again Later', {
                            icon: "error",
                        });
                        }
                        if (data.result == 'login') {
                            window.location.href = u + '/login';
                            
                        }
                    }
                })
            } else {
                swal("Cancelled!", {
                    icon: "error",
                });
            }
        });
}





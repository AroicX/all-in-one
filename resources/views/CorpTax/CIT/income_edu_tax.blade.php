@extends('CorpTax.index')

@section('content')
    <section class="content">
        <div class="row">

            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                	<div class="box-header">
                		<h4>INCOME AND EDUCATION TAX COMPUTATION</h4>
                	</div>
                	<div class="box-body">
                		<div class="row">
                			<div class="col-sm-12">
                			<table class="table" width="100%">
                				<thead>
                					<tr>
                						<th width="50%"></th>
                						<th width="25%">NGN</th>
                						<th width="25%">NGN</th>
                					</tr>
                				</thead>
                				<tbody>
                					<tr>
                						<td>Profit Before Tax</td>
                						<td></td>
                						<td><input type="text" id="pbt"></td>
                					</tr>
                					<tr>
                						<td colspan="3">Add/Deduct:</td>
                						
                					</tr>
                					<tr>
                						<td>Depreciation</td>
                						<td></td>
                						<td><input type="number" id="dep"></td>
                					</tr>
                					<tr>
                						<td>Disallowed expenses</td>
                						<td></td>
                						<td><input type="number" id="d_exp"></td>
                					</tr>
                					<tr>
                						<td>Share Issue expenses</td>
                						<td></td>
                						<td><input type="number" id="sie"></td>
                					</tr>
                					<tr>
                						<td>Loss on disposal of asset</td>
                						<td></td>
                						<td><input type="number" id="lda"></td>
                					</tr>
                					<tr>
                						<td>Loss on Exchange differences</td>
                						<td></td>
                						<td><input type="number" id="led"></td>
                					</tr>
                					<tr>
                						<td></td>
                						<td>Adjusted Profit</td>
                						<td><input type="text" id="ap" disabled="disabled"></td>
                					</tr>
                					<tr>
                						<td>Gain on Disposal of asset</td>
                						<td></td>
                						<td><input type="number" id="gda"></td>
                					</tr>
                					<tr>
                						<td>Gain on Exchange differences</td>
                						<td></td>
                						<td><input type="number" id="ged"></td>
                					</tr>
                					<tr>
                						<td></td>
                						<td>Assessable Profit/Loss</td>
                						<td><input type="number" id="apl" disabled="disabled"></td>
                					</tr>
                					<tr>
                						<td>Balancing Charge</td>
                						<td></td>
                						<td><input type="number" id="bc" ></td>
                					</tr>
                					<tr>
                						<td>Balancing Allowance</td>
                						<td></td>
                						<td><input type="number" id="ba" ></td>
                					</tr>

                					<tr>
                						<td>Loss Relief:</td>
                						<td></td>
                						<td></td>
                					</tr>
                					<tr>
                						<td>Loss brought forward</td>
                						<td><input type="number" id="lbf"></td>
                						<td></td>
                					</tr>
                					<tr>
                						<td>Losses utilized (for the year)</td>
                						<td><input type="number" id="lu"></td>
                						<td></td>
                					</tr>
                					<tr>
                						<td>Losses Carried Forward</td>
                						<td><input type="number" id="lcf" disabled="disabled"></td>
                						<td></td>
                					</tr>

                					<tr>
                						<td>Loss Capital Allowance:</td>
                						<td></td>
                						<td></td>
                					</tr>
                					<tr>
                						<td>Capital Allowance brought forward</td>
                						<td><input type="number" id="caf"></td>
                						<td></td>
                					</tr>
                					<tr>
                						<td>Capital allowances for the period</td>
                						<td><input type="number" id="cap"></td>
                						<td></td>
                					</tr>
                					<tr>
                						<td></td>
                						<td><input type="number" id="lca" disabled="disabled"></td>
                						<td></td>
                					</tr>

                					<tr>
                						<td>absorbed</td>
                						<td><input type="number" id="a"></td>
                						<td></td>
                					</tr>
                					<tr>
                						<td>Capital allowance carried forward</td>
                						<td><input type="number" id="cacf" disabled="disabled"></td>
                						<td></td>
                					</tr>
                					<tr>
                						<td>Taxable Profit</td>
                						<td></td>
                						<td><input type="number" id="tp" disabled="disabled"></td>
                					</tr>
                				</tbody>
                			</table>
                			</div>
                		</div>
                        <div class="text-center"><button id="submit" class="btn btn-success">Submit</button></div>
                	</div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('script')
<script type="text/javascript">
$(document).ready(function(){
//code for adjusted profit summation
	$('#pbt').change(function(){
		apTotal();
	});
	$('#dep').change(function(){
		apTotal();
	});
	$('#d_exp').change(function(){
		apTotal();
	});
	$('#sie').change(function(){
		apTotal();
	});
	$('#lda').change(function(){
		apTotal();
	});
	$('#led').change(function(){
		apTotal();
	});

	function apTotal(){
		var pbt = $('#pbt').val()==''?0:$('#pbt').val();
		var dep = $('#dep').val()==''?0:$('#dep').val();
		var d_exp = $('#d_exp').val()==''?0:$('#d_exp').val();
		var sie = $('#sie').val()==''?0:$('#sie').val();
		var lda = $('#lda').val()==''?0:$('#lda').val();
		var led = $('#led').val()==''?0:$('#led').val();

		var ap = parseInt(pbt) + parseInt(dep) + parseInt(d_exp) + parseInt(sie) + parseInt(lda) + parseInt(led);
		$('#ap').val(ap);
	}

//code for assessable profit/loss calculation
function aplTotal(){
		var ap = $('#ap').val()==''?0:$('#ap').val();
		var gda = $('#gda').val()==''?0:$('#gda').val();
		var ged = $('#ged').val()==''?0:$('#ged').val();
		
		var apl = parseInt(ap) - parseInt(gda) - parseInt(ged);
		$('#apl').val(apl);
	}

	$('#gda').change(function(){
		aplTotal();
	});
	$('#ged').change(function(){
		aplTotal();
	});

//code for assessable profit/loss calculation
function lcfTotal(){
		var lbf = $('#lbf').val()==''?0:$('#lbf').val();
		var lu = $('#lu').val()==''?0:$('#lu').val();
		
		var lcf = parseInt(lu) - parseInt(lbf);
		$('#lcf').val(lcf);
	}

	$('#lbf').change(function(){
		lcfTotal();
	});
	$('#lu').change(function(){
		lcfTotal();
	});

//code for loss capital allowance calculation
function lcaTotal(){
		var caf = $('#caf').val()==''?0:$('#caf').val();
		var cap = $('#cap').val()==''?0:$('#cap').val();
		
		var lca = parseInt(caf) + parseInt(cap);
		$('#lca').val(lca);
		var apl = parseInt($('#apl').val());
		var a = (200/3) * apl;
		console.log(a);
		var cacf = (lca - a).toFixed(2);
		$('#cacf').val(cacf);
	}

	$('#caf').change(function(){
		lcaTotal();
	});
	$('#cap').change(function(){
		lcaTotal();
		tpTotal();
	});


	function tpTotal(){
		var bc = $('#bc').val();
		var ba = $('#ba').val();
		var lcf = $('#lcf').val();
		var cacf = $('#cacf').val();
		var apl = $('#apl').val();

		var tp = parseInt(apl) + parseInt(bc) - parseInt(ba) - parseInt(lcf) - parseFloat(cacf);
		var total = tp.toFixed(2);
		console.log(total);
		$('#tp').val(total);
	}
$('#submit').click(function(){
    var formData = [];
    formData[0] = $('#pbt').val();
    formData[1] = $('#ap').val();
    formData[2] = $('#apt').val();
    formData[3] = $('#lbf').val();
    formData[4] = $('#lu').val();
    formData[5] = $('#lcf').val();
    formData[6] = $('#caf').val();
    formData[7] = $('#cap').val();
    formData[8] = $('#tp').val();

    $.ajax({
                type: 'POST',
                url: "/dashboard/corp-tax/CIT/add_asset",
                data: {formData: formData},
                dataType: 'text',
                success: function(response){
                    $('.alert').css('display','block');
                },
                error: function(response){
                    alert("An error occured when trying to submit this data");
                }
            }); 
});
});
</script>
@stop
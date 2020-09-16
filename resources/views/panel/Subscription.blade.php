@extends('layouts.setup')
@section('content')
<style>
	.cart,
	.user-info,
	.bago-backck1 {
		display: none;
	}
</style>

<style>
	/*============================================================
			BACKGROUND COLORS
			============================================================*/

	.db-bk-color-one {
		background-color: #f55039;
	}

	.db-bk-color-two {
		background-color: #fff;
		color: #404040 !important;
	}

	.db-bk-color-three {
		background-color: #47887E;
	}

	.db-bk-color-six {
		background-color: #F59B24;
	}

	/*============================================================
			PRICING STYLES
			==========================================================*/

	.db-padding-btm {
		padding-bottom: 50px;
	}

	.pricing-footer {
		background: #4680ff;
		color: white !important;
	}

	.db-button-color-square {
		color: #fff;
		background-color: rgba(0, 0, 0, 0.50);
		border: none;
		border-radius: 0px;
		-webkit-border-radius: 0px;
		-moz-border-radius: 0px;
	}

	.db-button-color-square:hover {
		color: #fff;
		background-color: rgba(0, 0, 0, 0.50);
		border: none;
	}


	.db-pricing-eleven {
		margin-bottom: 30px;
		margin-top: 50px;
		text-align: center;
		border: 1px dotted #4680ff;
		/* box-shadow: 0 0 5px rgba(0, 0, 0, .5); */
		color: #fff;
		line-height: 30px;
	}

	.db-pricing-eleven ul {
		list-style: none;
		margin: 0;
		text-align: center;
		padding-left: 0px;
	}

	.db-pricing-eleven ul li {
		padding-top: 20px;
		padding-bottom: 20px;
		cursor: pointer;
	}

	.db-pricing-eleven ul li i {
		margin-right: 5px;
	}


	.db-pricing-eleven .price {
		background-color: #fff;
		padding: 40px 20px 20px 20px;
		font-size: 60px;
		font-weight: 900;
		color: #4680ff;
	}

	.db-pricing-eleven .price small {
		color: #B8B8B8;
		display: block;
		font-size: 12px;
		margin-top: 22px;
	}

	.db-pricing-eleven .type {
		background-color: #4680ff;
		padding: 50px 20px;
		font-weight: 900;
		text-transform: uppercase;
		font-size: 30px;
		color: #fff;
	}

	.db-pricing-eleven .pricing-footer {
		padding: 20px;
	}

	.db-attached>.col-lg-4,
	.db-attached>.col-lg-3,
	.db-attached>.col-md-4,
	.db-attached>.col-md-3,
	.db-attached>.col-sm-4,
	.db-attached>.col-sm-3 {
		padding-left: 0;
		padding-right: 0;
	}

	.db-pricing-eleven.popular {
		margin-top: 10px;
	}

	.db-pricing-eleven.popular .price {
		padding-top: 80px;
	}

	.cart-item {
		color: #FFFFFF;
		padding: 3px 7px;
		border-radius: 10px;
		background: #f55039;
	}

	.IsDisabled {
		color: currentColor;
		cursor: not-allowed;
		opacity: 0.5;
		text-decoration: none;
	}

	.required {
		color: red;
	}
</style>


<div class="container">

	<div class="card package">
		<div class="card-body">
			<h5 class="card-title">Select Packages</h5>

			<div class="row mx-auto">
				<input type="hidden" type="text" id="package">
				<div class="col-md-2"></div>
				<div class="col-md-4">

					<div class="db-wrapper">
						<div class="db-pricing-eleven db-bk-color-two popular">
							<div class="price">
								<sup>$</sup>0.00
								<small>Monthly</small>
							</div>
							<div class="type">
								Basic
							</div>
							<ul style="text-align:center;">


								<li style="width:100% !important; border-bottom:1px solid #ffffff;">

									<strong>free</strong>
								</li>

							</ul>
							<div class="pricing-footer">
								<form id="form-basic">
									<input type="hidden" name="basic" id="basic" value="1.00">

									<button type="submit"
										class="btn add_to_cart_btn btn-primary-color btn-lg text-white">Select</button>
								</form>
							</div>
						</div>
					</div>



				</div>
				<div class="col-md-4">

					<div class="db-wrapper">
						<div class="db-pricing-eleven db-bk-color-two popular">
							<div class="price">
								<sup>$</sup>24.99
								<small>Monthly</small>
							</div>
							<div class="type">
								Standard
							</div>
							<ul style="text-align:center;">


								<li style="width:100% !important; border-bottom:1px solid #ffffff;">

									<strong>free</strong>
								</li>

							</ul>
							<div class="pricing-footer">
								<form id="form-standard">
									<input type="hidden" name="standard" id="standard" value="24.99">

									<button type="submit"
										class="btn add_to_cart_btn btn-primary-color btn-lg text-white">Select</button>

								</form>
							</div>
						</div>
					</div>


				</div>

			</div>






		</div>
	</div>

	<div class="card cart">
		<div class="card-header">
			<button class="btn btn-primary" id="back">Back</button>
			<button class="btn btn-primary go-back">Back</button>
			<button class="btn btn-primary pull-right" id="next">Next</button>
		</div>
		<div class="card-body">

			<h5 class="card-title" id="title"></h5>


			<div class="row calc">
				<div class="col-md-4">
					<div class="form-group">
						<label for="price">Price</label>
						<input id="price" class="form-control" type="text" name="price" readonly>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="month">Month</label>
						<select name="month" id="month" class="form-control">
							<option value="1">1 month</option>
							<option value="2">2 months</option>
							<option value="3">3 months</option>
							<option value="4">4 months</option>
							<option value="5">5 months</option>
							<option value="6">6 months</option>
							<option value="7">7 months</option>
							<option value="8">8 months</option>
							<option value="9">9 months</option>
							<option value="10">10 months</option>
							<option value="11">11 months</option>
							<option value="12">12 months</option>
						</select>
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						<label for="total">Total</label>
						<input id="total" class="form-control" type="text" name="total" readonly>
					</div>
				</div>


			</div>


			<div class="user-info">

				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="Name">Name</label>
							<input id="name" class="form-control" type="text" name="fullname" required>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="email">Email</label>
							<input id="email" class="form-control" type="email" name="email" required>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="phone">Phone Number</label>
							<input id="num" class="form-control" type="number" name="number" required>
						</div>
					</div>
				</div>
				<div class="row">


					<div class="col-md-8">
						<div class="form-group">
							<label for="to">Total <small class="text-danger">Please note that total is in $(USD)</small>
							</label>
							<input id="total2" class="form-control" type="text" readonly>
						</div>
					</div>
					<div class="col-md-4 py-4">
						<form>
							<script src="https://js.paystack.co/v1/inline.js"></script>
							<button class="btn btn-primary" type="button" onclick="payWithPaystack()"> Pay Now </button>
						</form>
					</div>




				</div>
			</div>





		</div>
	</div>

</div>


@endsection




@section('js')
<script>
	$(document).ready(function (e) {
		$('.go-back').hide();


		$('#form-basic').submit(function (event) {
			event.preventDefault();
			$('#package').val('Basic');


			const price = $('#basic').val();
			$('.package').fadeOut('400')
			$('.cart').fadeIn('400')
			$('#title').html('Basic')
			$('#price').val(`$ ${price}`)
			$('#total').val(`$ ${price}`)
			$('#total2').val(price)


			// total(price);
		});

		$('#form-standard').submit(function (event) {
			event.preventDefault();
			$('#package').val('Standard');


			const price = $('#standard').val();
			$('.package').fadeOut('400')
			$('.cart').fadeIn('400')
			$('#title').html('Standard')
			$('#price').val(`$ ${price}`)
			$('#total').val(`$ ${price}`)
			$('#total2').val(price)


			total(price);




		});

		$('#back').click(() => {
			$('.package').fadeIn('400')
			$('.cart').fadeOut('400');
			$('.go-back').hide();


		})
		$('.go-back').click(() => {
			$('.calc').fadeIn('400')
			$('.user-info').fadeOut('400')
			$(this).hide();
			$('#back').show();
		})
		$('#next').click(() => {
			$('.user-info').fadeIn('400')
			$('.calc').fadeOut('400')
			$('#back').hide();
			$('.go-back').show();
			$(this).hide();
		})



		function total(price) {
			$('#month').on('change', function () {
				let selected = this.value //or alert($(this).val());
				let total = selected * price
				$('#total').val(`$ ${total}`)
				$('#total2').val(total)

			});


		}


	})





	function payWithPaystack() {
		const email = $('#email').val();
		let amount = Math.floor($('#total2').val()) * 361;
		let package = $('#package').val();

		console.log(package)
		let duration = $('#month').val() * 31;
		const name = $('#name').val();
		const num = $('#num').val();



		var handler = PaystackPop.setup({
			key: 'pk_test_5d5fb23f7643ea0c027b0754c6b8e5861b71c5f4',
			email: email,
			amount: amount * 100,
			currency: "NGN",
			ref: '' + Math.floor((Math.random() * 1000000000) +
				1
			), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
			metadata: {
				custom_fields: [{
					display_name: name,
					variable_name: name,
					value: num
				}]
			},
			callback: function (response) {
				console.log(response)

				if (response.message == 'Approved') {

					let data = {
						package: package,
						refx_code: response.trxref,
						duration: duration
					};

					subscription(data);

				}


			},
			onClose: function () {
				// alert('window closed');
			}
		});
		handler.openIframe();
	}

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('[name="_token"]').val()
		}
	});

	function subscription(data) {



		$.ajax({
			url: "{{route('subscription.complete')}}",
			headers: {
				'X-CSRF-TOKEN': "{{csrf_token()}}"
			},
			type: "POST",
			data: data,

			success: function (data) {
				window.location.href = "/dashboard";
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error Retrieving Data!');
			}
		});


	}
</script>
@endsection
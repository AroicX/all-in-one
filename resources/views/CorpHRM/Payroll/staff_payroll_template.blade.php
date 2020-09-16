<!DOCTYPE html>
<html>

<head>
  <title>Payroll</title>

  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}" media="all" />

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css"
    media="all" />
  <!-- Ionicons -->

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css"
    media="all" />
</head>

<body>
  <div class="" style="margin-top: 20px;">
    <div style="float: right; margin-right: 20px !important;">
      <img class="img-thumbnail" src="{{ asset('/uploads/avatar') }}/{{ $user_details->pic }}" media="all">
    </div>
    <div class="col-md-12">
      <table class="table table-hover">
        <thead>
          <td class="text-left" style="font-weight: 600;">Employee Code:</td>
          <center>
            <td class="" style="font-weight: 600;">Employee Name: {{ $user_details->name }}</td>
          </center>
          <td class="text-right"></td>
          <td></td>
        </thead>
        <tbody>
          <tr style="width: 100%;">
            <td class="text-left" style="font-weight: 600;">Department: {{ $department->name }}</td>
            <center>
              <td class="" style="font-weight: 600;">Designation: {{ $designation->name }}<p
                  style="float:right; margin: 0px !important; padding: 0px !important;"> Branch: {{ $branch->name }}</p>
              </td>
            </center>
            <td></td>
            <td></td>
          </tr>
          <tr style="width: 100%;">
            <td class="text-left" style="font-weight: 600;">Date of Birth: {{ $employee->date_of_birth }}</td>
            <center>
              <td class="" style="font-weight: 600;">Date of Joining: {{ $profile->join_date }}<p
                  style="float:right; margin: 0px !important; padding: 0px !important;"> Bank Name:
                  {{ $salary->bank_name }}</p>
              </td>
            </center>
            <td></td>
            <td></td>
          </tr>
          <tr style="width: 100%;">
            <td class="text-left" style="font-weight: 600;">Bank A/c No: {{ $salary->bank_acc_no }}</td>
            <center>
              <td class="" style="font-weight: 600;">
                <p style="float:right; margin: 0px !important; padding: 0px !important;"></p>
              </td>
            </center>
            <td></td>
            <td></td>
          </tr>
          <tr style="width: 100%; font-weight: 600;">
            <td style="">
              <p style="float:left; ">Present Day: {{ $present_days }}</p>
              <p style="float:right; ">Paid Leave:</p>
            </td>
            <td>
              <p style="float:left; ">Out Day:</p>
              <p style="float:right; ">Holiday: {{ $holiday }}</p>
            </td>
            <td>
              <p style="float:left; "> Absent: {{ $absent_day }}</p>
              <p style="float:right; ">Total Sal Day: {{ $salary_day }}</p>
            </td>
            <td>
              <center>
                <p style="float:left; ">Weekoff: {{ $week_off }}</p>
              </center>
            </td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
        </tbody>
      </table>

      <div class="col-md-6" style="margin:0px !important; padding:0px !important;">
        <table class="table table-bordered" style="border: 2px solid black !important;">
          <tr>
            <th style="border: 2px solid black !important;">Particulars</th>
            <th style="border: 2px solid black !important;">Rate</th>
            <th style="border: 2px solid black !important;">Earnings</th>
          </tr>
          <tr>
            <td style="border:0px; border-left:2px solid black !important;">Basic Salary</td>
            <td style="border:0px; border-left:2px solid black !important;">{{ number_format($grade->basic_salary) }}
            </td>
            <td style="border:0px; border-left:2px solid black !important;">{{ number_format($grade->basic_salary) }}
            </td>

          </tr>


          <?php $total = 0; foreach($value_custom_additions as $key => $value_custom_addition){ ?>
          <tr>
            <td style="border:0px; border-left:2px solid black !important;">{{ $value_custom_addition->name }}</td>
            <td style="border:0px; border-left:2px solid black !important;">
              {{ number_format($value_custom_addition->value) }}</td>
            <td style="border:0px; border-left:2px solid black !important;">
              {{ number_format($value_custom_addition->value) }}</td>
          </tr>
          <?php $total = $total + $value_custom_addition->value; } ?>
          <tr>
            <td style="font-weight: 600; border: 2px solid black !important;">Total Earnings</td>
            <td style="border: 2px solid black !important;">{{ number_format($grade->basic_salary + $total) }}</td>
            <td style="border: 2px solid black !important;">{{  number_format($grade->basic_salary + $total) }}</td>
          </tr>
          <?php $a = $grade->basic_salary + $total; ?>
        </table>
      </div>
      <div class="col-md-6" style="margin:0px !important; padding:0px !important;">
        <table class="table table-bordered" style="border: 2px solid black !important; ">
          <tr>
            <th style="border: 2px solid black !important;">Particulars</th>
            <th style="border: 2px solid black !important;">Rate</th>
            <th style="border: 2px solid black !important;">Deduction</th>
          </tr>
          <?php $totalll = 0; foreach($value_custom_subtractions as $key => $value_custom_subtraction){ ?>
          <tr>
            <td style="border:0px; border-left:2px solid black !important;">{{ $value_custom_subtraction['name'] }}</td>
            <td style="border:0px; border-left:2px solid black !important;">
              {{ number_format($value_custom_subtraction['value']) }}</td>
            <td style="border:0px; border-left:2px solid black !important;">
              {{ number_format($value_custom_subtraction['value']) }}</td>
          </tr>
          <?php $totalll = $totalll + $value_custom_subtraction->$key; } ?>
          <tr>
            <td style="border:0px; border-left:2px solid black !important;">PAYE</td>
            <td style="border:0px; border-left:2px solid black !important;">{{ number_format($PAYE / 12) }}</td>
            <td style="border:0px; border-left:2px solid black !important;">{{ number_format($PAYE / 12) }}</td>
          </tr>
          @if($NHF !== "0")
          <tr>
            <td style="border:0px; border-left:2px solid black !important;">NHF</td>
            <td style="border:0px; border-left:2px solid black !important;">{{ number_format($NHF) }}</td>
            <td style="border:0px; border-left:2px solid black !important;">{{ number_format($NHF) }}</td>
          </tr>
          @endif
          @if($pension !== "0")
          <tr>
            <td style="border:0px; border-left:2px solid black !important;">Pension</td>
            <td style="border:0px; border-left:2px solid black !important;">{{ number_format($pension) }}</td>
            <td style="border:0px; border-left:2px solid black !important;">{{ number_format($pension) }}</td>
          </tr>
          @endif

          @if($loan_amount_left !== "0")
          <tr>
            <td style="border:0px; border-left:2px solid black !important;">Loan</td>
            <td style="border:0px; border-left:2px solid black !important;">{{ number_format($loan_amount_left) }}</td>
            <td style="border:0px; border-left:2px solid black !important;">{{ number_format($loan_amount_left) }}</td>
          </tr>
          @endif
          <tr>
            <td style="font-weight: 600; border: 2px solid black !important;">Total</td>
            <td style="border: 2px solid black !important;">
              {{ number_format($loan_amount_left + $totalll + ($PAYE / 12) + $NHF + $pension + $loan_amount_left) }}
            </td>
            <td style="border: 2px solid black !important;">
              {{ $b = number_format($loan_amount_left + $totalll + ($PAYE / 12) + $NHF + $pension + $loan_amount_left) }}
            </td>
          </tr>
          <?php $b = $loan_amount_left + $totalll + ($PAYE / 12) + $NHF + $pension + $loan_amount_left; ?>
        </table>
      </div>
    </div>
    <?php

function numberTowords($num)
{ 
$ones = array( 
1 => "one", 
2 => "two", 
3 => "three", 
4 => "four", 
5 => "five", 
6 => "six", 
7 => "seven", 
8 => "eight", 
9 => "nine", 
10 => "ten", 
11 => "eleven", 
12 => "twelve", 
13 => "thirteen", 
14 => "fourteen", 
15 => "fifteen", 
16 => "sixteen", 
17 => "seventeen", 
18 => "eighteen", 
19 => "nineteen" 
); 
$tens = array( 
1 => "ten",
2 => "twenty", 
3 => "thirty", 
4 => "forty", 
5 => "fifty", 
6 => "sixty", 
7 => "seventy", 
8 => "eighty", 
9 => "ninety" 
); 
$hundreds = array( 
"hundred", 
"thousand", 
"million", 
"billion", 
"trillion", 
"quadrillion" 
); //limit t quadrillion 
$num = number_format($num,2,".",","); 
$num_arr = explode(".",$num); 
$wholenum = $num_arr[0]; 
$decnum = $num_arr[1]; 
$whole_arr = array_reverse(explode(",",$wholenum)); 
krsort($whole_arr); 
$rettxt = ""; 
foreach($whole_arr as $key => $i){ 
if($i < 20){ 
$rettxt .= $ones[$i]; 
}elseif($i < 100){ 
$rettxt .= $tens[substr($i,0,1)]; 
$rettxt .= " ".$ones[substr($i,1,1)]; 
}else{ 
$rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
$rettxt .= " ".$tens[substr($i,1,1)]; 
$rettxt .= " ".$ones[substr($i,2,1)]; 
} 
if($key > 0){ 
$rettxt .= " ".$hundreds[$key]." "; 
} 
} 
if($decnum > 0){ 
$rettxt .= " and "; 
if($decnum < 20){ 
$rettxt .= $ones[$decnum]; 
}elseif($decnum < 100){ 
$rettxt .= $tens[substr($decnum,0,1)]; 
$rettxt .= " ".$ones[substr($decnum,1,1)]; 
} 
} 
return $rettxt; 
} 

?>
    <div class="col-md-12"
      style="border:0px; font-weight: 600; text-align: center; border-top: 2px solid black !important; border-bottom: 2px solid black !important;">
      <hr style="color: #000000 !important; font-weight: 600;">
      <h2 style="font-weight: 600; font-size: 20px;"> Employee Net Pay : {{ number_format( $a - $b ) }}
        <br>
        <?php // echo numberTowords($a - $b); ?>
      </h2>
      <hr style="color: #000000 !important; font-weight: 600;">
    </div>


  </div>


</body>
<script src="{{asset('calendar/js/jquery.min.js')}}"></script>


<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('calendar/js/jquery-ui.min.js') }}"></script>
<script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>

</html>
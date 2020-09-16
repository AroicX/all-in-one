<!DOCTYPE html>
<html>

<head>
  <style>
    @page {
      header: page-header;
      footer: page-footer;
    }

    table {
      font-family: arial, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    td,
    th {
      border: 1px solid #dddddd;
      text-align: left;
      padding: 8px;
    }

    tr:nth-child(even) {
      background-color: #dddddd;
    }
  </style>
</head>

<body>
  <htmlpageheader name="page-header">
    <br>
    <?php
$monthNum  = $month;
$dateObj   = DateTime::createFromFormat('!m', $monthNum);
$monthName = $dateObj->format('F'); // March
?>
    <p style="text-align:center;"> Staff Payroll for {{ $monthName  }} {{ $year }}</p>
  </htmlpageheader>
  <br><br>
  <table>
    <tr>
      <th>Name</th>
      <th>Basic Salary</th>
      <th>Additions</th>
      <th>Gross</th>
      <th>Subtractions</th>
      <th>Net pay</th>
    </tr>
    @foreach($users as $user)
    <tr>
      <td>{{ $user['name'] }}</td>
      <td>{{ number_format($user['salary']) }}</td>
      <td>
        <?php $a = 0; ?>
        @foreach($user['value_custom_additions'] as $additions)
        <?php $a = $a + $additions->value; ?>
        {{ $additions->name }}: {{ number_format($additions->value) }}
        <br>
        <b>Total: {{ number_format($a) }}</b>
        @endforeach
      </td>
      <td>{{ number_format($user['salary'] + $a) }}</td>
      <td>
        <?php $b = 0; ?>
        @foreach($user['value_custom_subtractions'] as $subtractions)
        <?php $b = $b + $subtractions->value; ?>
        {{ $subtractions->name }}: {{ number_format($subtractions->value) }}
        <br>
        <b>Total: {{ number_format($b) }}</b>
        @endforeach

        @if($user['loan_amount_left'] !== "0")
        Loan:{{ number_format($user['loan_amount_left']) }}
        @endif
        @if($user['PAYE'] !== "0")
        <br>
        Paye: {{ number_format($user['PAYE'] / 12) }}
        @endif
        @if($user['NHF'] !== "0")
        <br>
        NHF: {{ number_format($user['NHF']) }}
        @endif
        @if($user['pension'] !== "0")
        <br>
        Pension: {{ number_format($user['pension']) }}
        @endif
      </td>
      <td>
        {{ number_format( ($user['salary'] + $a) - ($b + $user['loan_amount_left'] +($user['PAYE'] / 12) + $user['NHF'] + $user['pension'] )) }}
      </td>
    </tr>
    @endforeach
  </table>

</body>

</html>
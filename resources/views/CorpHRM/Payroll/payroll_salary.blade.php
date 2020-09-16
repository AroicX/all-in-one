@extends('CorpHRM.layout.master') @section('content')
<section class="content">
    <div class="row">

        <div class="col-md-12">
     

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Salary </h5>
                    <p id="error-month" class="text-danger"></p>
                    {{-- <p class="card-text">Content</p> --}}
                    @if(isset($success))
                    <div class="alert alert-success">* Successfully Added</div>
                    @endif @if(session('error'))
                    <div class="alert alert-error">
                        {{ session('error') }}.
                    </div>
                    @elseif(session('success'))
                    <div class="alert alert-success">
                        <p>{{ session('success') }}</p>.
                    </div>
                    @endif


                    <form action="{{ route('payroll.salary') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select id="my-month" class="form-control" name="month" required>
                                        <option value="">Choose Month</option>
                                        <option value="1">January</option>
                                        <option value="2">Febuary</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{-- <p id="error-year" class="text-danger"></p> --}}

                                    <select id="my-year" class="form-control" name="year" required>
                                        <option value="">Choose Year</option>

                                        <?php for($i = 2000; $i <= date('Y'); $i++){ ?>
                                        <option><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="form-group my-1">
                                    <button type="submit" class="btn btn-primary has-ripplw">Search</button>
                                </div>

                            </div>

                        </div>




                    </form>


                </div>
            </div>


        </div>


        @if($salaries != null)
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Salary Table</h5>
                    <button class="btn btn-primary has-ripple" id="pay_salary">Pay Salary</button>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" class="form-control" name="checkAll" id="checkAll">
                                    </th>
                                    
                                    <th>Employee Name</th>
                                    <th>Bank Name</th>
                                    <th>Bank Account</th>
                                    
                                    <th>Gross Pay</th>
                                    <th>Net Pay</th>
                                </tr>
                            </thead>
                         
                            <tbody>

                                @foreach($salaries as $key => $staff)
                              
                                <tr>
                                <td><input type="checkbox" class="form-control" name="staff_id[]" value="{{$staff}}"></td>
                                <td>
                                    <?php 
                                        $getName = \App\Models\CorpHRM\EmployeeProfile::where('user_id',$staff->employee_id)->first();
                                        // echo $getName[0]->title .' '.$getName[0]->firstname.' '.$getName[0]->surname;
                                        echo $getName['title'] .' '.$getName['firstname'].' '.$getName['surname'];
                                    ?>
                                </td>
                                <td>{{ $staff->bank_name }}</td>
                                <td>{{ $staff->bank_acc }}</td>
                              
                                <td>{{ $staff->gross_pay }}</td>
                                <td>{{ $staff->net_pay }}</td>
                                </tr>
                                 <input type="hidden" id="data-obj" name="data-obj-{{$staff->staff_id}}" value="{{$staff}}">
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif



    </div>
</section>

<script src="{{asset('calendar/js/jquery.min.js')}}"></script>
{{-- <script type="text/javascript">
    $(document).ready(function (e) {
        $('#search').click(function (e) {
            e.preventDefault();
           
            const data = {
                month: $('#my-month').val(),
                year: $('#my-year').val()
            }

            if(data.month == '' || data.year == ''){
                $('#error-month').html('* Please fill in all fields');
                return false;
            }

            $('#error-month').fadeOut(400);


            $.ajax({
                    url: '{{ route('payroll.salary') }}',
headers: {
'X-CSRF-TOKEN': "{{csrf_token()}}"
},
type: 'POST',
data: data,
})
.done(function (response) {
console.log(response);
$(this).fadeOut(400);

})
.fail(function () {
console.log("error");
})
.always(function () {
console.log("complete");
});





console.log(data);
});
});
</script> --}}


<script>


    $(document).ready(function (e) {
        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });




        $('#pay_salary').click(function () {

            var checkboxes = document.getElementsByName('staff_id[]');
            var count = $("input:checkbox:checked").length;
            
           
            var vals = new Array();
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                if (checkboxes[i].checked) {
                    str = checkboxes[i].value
                    str.slice(1,-1)
                    // console.log(checkboxes[i].value);
            
                    vals.push(JSON.parse(str));
                }
            }


          

            $.ajax({
                url: "{{ route('salary.save') }}",
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                },
                type: "POST",
                data:  {data: vals},
                
                success: function (data) {
                    console.log('server',data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error Retrieving Data!');
                }
            });


        });

    });

    




</script>
@stop
<table style="max-width:670px;margin:50px auto 10px;background-color:#f9f9f9;padding:50px;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;-webkit-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);-moz-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);">
    <thead>
      <tr>
        <th style="text-align:left;font-weight:400;">
          {{ $company->name }}
        </th>
        <th style="text-align:right;font-weight:400;">{{ $invoice->created_at->diffForHumans() }}</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="height:35px;"></td>
      </tr>
      <tr>
        <td colspan="2" style="border: solid 1px #ddd; padding:10px 20px;">
          <p style="font-size:14px;margin:0 0 6px 0;"><span style="font-weight:bold;display:inline-block;min-width:150px">Order status</span><b style="color:green;font-weight:normal;margin:0">{{ $invoice->status }}</b></p>
          <p style="font-size:14px;margin:0 0 6px 0;"><span style="font-weight:bold;display:inline-block;min-width:146px">Invoice ID</span> {{ $invoice->invoice_no }}</p>
          <p style="font-size:14px;margin:0 0 0 0;"><span style="font-weight:bold;display:inline-block;min-width:146px">Order amount</span> &#8358; {{ $invoice->total }}</p>
        </td>
      </tr>
      <tr>
        <td style="height:35px;"></td>
      </tr>
      <tr>
        <td style="width:50%;padding:20px;vertical-align:top">
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px">Name</span> {{ $client->name }}</p>
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Email</span> {{ $client->email }}</p>
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Phone</span> {{ $client->tel }}</p>
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Phone</span> {{ $client->address }}</p>
          <!-- <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">ID No.</span> 2556-1259-9842</p> -->
        </td>
        <td style="width:50%;padding:20px;vertical-align:top">
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Company</span> {{ $company->name }}</p>
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Email</span> {{ $company->email }}</p>
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Address</span> {{ $company->address }}</p>
        </td>
      </tr>
      <tr>
        <td colspan="2" style="font-size:20px;padding:30px 15px 0 15px;">Items</td>
      </tr>
      <tr style="width: 100%">
        <td style="width: 100%">
        <table class="table table-striped" style="width: 100%; display: table;
    border-collapse: separate;
    border-spacing: 2px;
    border-color: grey;">
                <thead>
                  <tr>
                  <th>Product Name</th>
                  <th>Quantity</th>
                  <th>Discount</th>
                  <th>Vat</th>
                  <th>Sub-Total()</th>
                  <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($invoice_items as $inv_item)
                  {{ $inv_item->name }}
                  <tr>

                    <td>
                      {{ $inv_item->name }} {{ $inv_item->price }}
                    </td>
                    <td>
                     {{$inv_item->quantity}}
                    </td>
                    <td>{{ $inv_item->discount_percent }}</td>
                    <td>{{number_format($inv_item->vat, 2)}}</td>
                    <td>{{number_format($inv_item->sub_total, 2)}}</td>
                    <td>{{number_format($inv_item->total, 2)}}</td>
                  </tr>
                  @endforeach
                  @foreach($invoice_vat_items as $inv_vat_item)
                  <tr>
                    <td></td>
                    <td>
                    </td>
                    <td></td>
                    <td></td>
                    <td>{{ $inv_vat_item->description }}</td>
                    <td>{{ $inv_vat_item->total }}</td>
                  </tr>
                  @endforeach
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Total</td>
                     <td>{{number_format($invoice->total, 2)}}</td>
                  </tr>
                </tbody>
                <tfooter>
                <tr>
                  @if($invoice->status == 'draft')
                  <td colspan="3" style="font-size:14px;padding:50px 15px 0 15px;">
                    <a style="color: #fff;
    background-color: #4680ff;
    border-color: #4680ff; display: inline-block;
    font-weight: 400;
    text-align: center;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    padding: 0.625rem 1.1875rem;
    font-size: 0.875rem;
    line-height: 1.5;
    border-radius: 2px;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
" target="_blank" href="{{ url('') }}/client/quote/accept/{{ \Crypt::encrypt($invoice->id)}}"> Accept Invoice </a>
                  </td>
                  <td colspan="3" style="font-size:14px;padding:50px 15px 0 15px;">
<a style="color: #fff;
    background-color: #4680ff;
    border-color: #4680ff; display: inline-block;
    font-weight: 400;
    text-align: center;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    padding: 0.625rem 1.1875rem;
    font-size: 0.875rem;
    line-height: 1.5;
    border-radius: 2px;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
"> Revised Invoice</a>
                  </td>
                @elseif($invoice->status == "accepted")
                <td colspan="3" style="font-size:14px;padding:50px 15px 0 15px;">
                    <a style="color: #fff;
    background-color: #4680ff;
    border-color: #4680ff; display: inline-block;
    font-weight: 400;
    text-align: center;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    padding: 0.625rem 1.1875rem;
    font-size: 0.875rem;
    line-height: 1.5;
    border-radius: 2px;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
" target="_blank" href="{{ url('') }}/client/invoice/quote/view/{{ \Crypt::encrypt($invoice->id)}}"> Make Payment </a>
                  </td>
                @endif
              </tr>

              </tfooter>
              </table>
              <div style="width: 50%;">
                
              </div>
            </td>
      </tr>
    </tbody>
  </table>
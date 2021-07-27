<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="{{url('public/logo', $general_setting->site_logo)}}" />
    <title>{{$general_setting->site_title}}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">

    <style type="text/css">
        * {
            font-size: 14px;
            line-height: 24px;
            font-family: 'Ubuntu', sans-serif;
            text-transform: capitalize;
        }
        .btn {
            padding: 7px 10px;
            text-decoration: none;
            border: none;
            display: block;
            text-align: center;
            margin: 7px;
            cursor:pointer;
        }

        .btn-info {
            background-color: #999;
            color: #FFF;
        }

        .btn-primary {
            background-color: #6449e7;
            color: #FFF;
            width: 100%;
        }
        td,
        th,
        tr,
        table {
            border-collapse: collapse;
        }
        tr {border-bottom: 1px dotted #ddd;}
        td,th {padding: 0px 0;}

        table {width: 100%;}
        tfoot tr th:first-child {text-align: left;}

        .centered {
            text-align: center;
            align-content: center;
        }
        small{font-size:11px;}

        @media print {
            * {
                font-size:12px;
                line-height: 20px;
            }
            td,th {padding: 5px 0;}
            .hidden-print {
                display: none !important;
            }
            @page { margin: 0; } body { margin: 0.5cm; margin-bottom:1.6cm; } 
        }
    </style>
  </head>
<body>

<div style="max-width:400px;margin:0 auto">
    @if(preg_match('~[0-9]~', url()->previous()))
        @php $url = '../../pos'; @endphp
    @else
        @php $url = url()->previous(); @endphp
    @endif
    <div class="hidden-print">
        <table>
            <tr>
                <td><a href="{{$url}}" class="btn btn-info"><i class="fa fa-arrow-left"></i> {{trans('file.Back')}}</a> </td>
                <td><button onclick="window.print();" class="btn btn-primary"><i class="dripicons-print"></i> {{trans('file.Print')}}</button></td>
            </tr>
        </table>
        <br>
    </div>
        
    <div id="receipt-data">
        <div class="centered">
		  <h1>{{$general_setting->site_title}}</h1>
        		  
				 <br>{{$lims_warehouse_data->address}}
			     <br>Tel : {{$lims_warehouse_data->phone}}</p>
        </div>      
        <table>
            <tbody>
				  <tr>
                      <td><strong>{{trans('file.Date')}}:</strong></td>
					  <td>{{$lims_sale_data->created_at}}</td>
					  <td align="right"> <strong>:التاريخ</strong></td>
				  </tr>
				  <tr>
                      <td><strong>Invoice No:</strong></td>
					  <td>{{$lims_sale_data->id}}</td>
					  <td align="right"> <strong>:رقم</strong></td>
				  </tr>
				  <tr>
                      <td><strong>{{trans('file.customer')}}:</strong></td>
					  <td>{{$lims_customer_data->name}}</td>
					  <td align="right"> <strong>:عميل</strong></td>
				  </tr>
			</tbody>
		</table>
		<table>
				<tr style="text-align: left">
					<th style="width: 5%">#</td>
					<th style="width: 40%"><span>العنصر </span><br/>Item</th>
					<th style="width: 10%"><span>الكمية </span><br>Qty</th>
					<th style="width: 15%" align="center"><span>السعر </span><br>Rate</th>
					<th style="width: 15%" align="center"><span>خصم </span><br>Disc</th>
					<th style="width: 15%" align="center"><span>ضريبة </span><br>VAT</th>
					<th style="width: 20%" align="right"><span>اجمالي</span><br>Total</th>
				
		  </tr>
		<?php $total_product_tax = 0;?>
                @foreach($lims_product_sale_data as $k=>$product_sale_data)
          		<?php 
                    $lims_product_data = \App\Product::find($product_sale_data->product_id);
                    if($product_sale_data->variant_id) {
                        $variant_data = \App\Variant::find($product_sale_data->variant_id);
                        $product_name = $lims_product_data->name.' ['.$variant_data->name.']';
                    }
                    else
                        $product_name = $lims_product_data->name;
					if($lims_product_data->type == 'digital'){
						 $lims_product_data = \App\Product::find($product_sale_data->product_id);
					}
                ?>
	            @if($lims_product_data->type == 'digital')
	 
				<tr style="text-align: left">
					<td style="width: 5%">{{$k+1}}</td>
					<td style="width: 40%">{{$product_name}}<br/>{{$lims_product_data->namear}}</td>
					<td style="width: 5%">{{$product_sale_data->qty}}</td>
					<td style="width: 15%" align="center">{{number_format((float)$product_sale_data->net_unit_price, 3, '.', '')}}</td>
					<td style="width: 15%" align="center">{{number_format((float)$product_sale_data->discount, 3, '.', '')}}</td>
					<td style="width: 15%" align="center">{{number_format((float)$product_sale_data->tax, 3, '.', '')}}</td>
					<td style="width: 20%" align="right"><span>{{number_format((float)($product_sale_data->total), 3, '.', '')}}</td>
				
				</tr>
				@else
				<tr style="text-align: left">
					<td style="width: 5%">{{$k+1}}</td>
					<td style="width: 40%">{{$product_name}}<br/>{{$lims_product_data->namear}}</td>
					<td style="width: 5%">{{$product_sale_data->qty}}</td>
					<td style="width: 15%" align="center">{{number_format((float)$product_sale_data->net_unit_price, 3, '.', '')}}</td>
					<td style="width: 15%" align="center">{{number_format((float)$product_sale_data->discount, 3, '.', '')}}</td>
					<td style="width: 15%" align="center">{{number_format((float)$product_sale_data->tax, 3, '.', '')}}</td>
					<td style="width: 20%" align="right"><span>{{number_format((float)($product_sale_data->total), 3, '.', '')}}</td>
				
				</tr>
				@endif
		 @endforeach
	  </table>
                <?php $total_product_tax = 0;?>
                @foreach($lims_product_sale_data as $product_sale_data)
                <?php 
                    $lims_product_data = \App\Product::find($product_sale_data->product_id);
                    if($product_sale_data->variant_id) {
                        $variant_data = \App\Variant::find($product_sale_data->variant_id);
                        $product_name = $lims_product_data->name.' ['.$variant_data->name.']';
                    }
                    else
                        $product_name = $lims_product_data->name;
                ?>
                <tr><!--
                    <td colspan="3">
                        {{$product_name}}
                        <br>{{$product_sale_data->qty}} x {{number_format((float)($product_sale_data->total / $product_sale_data->qty), 2, '.', '')}}

                        @if($product_sale_data->tax_rate)
                            <?php $total_product_tax += $product_sale_data->tax ?>
                            [{{trans('file.Tax')}} ({{$product_sale_data->tax_rate}}%): {{$product_sale_data->tax}}]
                        @endif
                    </td>
                    <td style="text-align:right;vertical-align:bottom">{{number_format((float)$product_sale_data->total, 2, '.', '')}}</td>
                --></tr>
                @endforeach
	</tbody></table>
		<table>
			 <tbody>
				 <tr>
                      <th align="left">{{trans('file.Total')}}:</th>
					  <th>{{number_format((float)$lims_sale_data->total_price, 3, '.', '')}}</th>
					  <th align="right"> :اجمالي </th>
				  </tr>
				  @if($lims_sale_data->order_discount)
				  <tr>
                      <th align="left">Total Discount:</th>
					  <th>{{number_format((float)$lims_sale_data->order_discount, 3, '.', '')}}</th>
					  <th align="right">  :خصم</th>
				  </tr>
				 @endif
				 @if($lims_sale_data->total_discount)
				  <tr>
                      <th align="left">Total Discount:</th>
					  <th>{{number_format((float)$lims_sale_data->total_discount, 3, '.', '')}}</th>
					  <th align="right">  :خصم</th>
				  </tr>
				  @endif
				  @if($lims_sale_data->total_tax)
				  <tr>
				    <th align="left">Total VAT</th>
				    <th>{{number_format((float)$lims_sale_data->total_tax, 3, '.', '')}}</th>
				    <th align="right">ضريبة</th>
		          </tr>
				 @endif
				  @if($lims_sale_data->order_tax)
				  <tr>
				    <th align="left">Total VAT</th>
				    <th>{{number_format((float)$lims_sale_data->order_tax, 3, '.', '')}}</th>
				    <th align="right">ضريبة</th>
		          </tr>
				 @endif
				  <tr>
                      <th align="left">Grand Total:</th>
					  <th>{{number_format((float)$lims_sale_data->grand_total, 3, '.', '')}}</th>
					  <th align="right"> :اجمالي المبلغ</th>
				  </tr>
				 @foreach($lims_payment_data as $payment_data)
				  <tr>
                      <th align="left">Cash Recived:</th>
					  <th>{{number_format((float)$payment_data->amount+$payment_data->change, 3, '.', '')}}</th>
					  <th align="right"> : المبلغ المستلم </th>
				  </tr>
				  <tr> 
                      <th align="left"> Change:</th>
					  <th>{{number_format((float)$payment_data->change, 3, '.', '')}}</th>
					  <th align="right">  :المتبقي</th>					 
				  </tr>
				  @endforeach
			</tbody>
	</table>
        </table>
		<table>
            <tbody>
				<tr><td class="centered" colspan="3">شكر لحسن زيارتكم لنا</br>Thank you for shopping with us</td></tr>
				<tr><td class="centered" colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
		</tbody>
		</table>
<!--
        <table>
            <tbody>
                <tr><td class="centered" colspan="3">{{trans('file.Thank you for shopping with us. Please come again')}}</td></tr>
                <tr>
                    <td class="centered">
                    <?php// echo '<img style="margin-top:10px;" src="data:image/png;base64,' . DNS1D::getBarcodePNG($lims_sale_data->reference_no, 'C128') . '" width="300" alt="barcode"   />';?>
                  <!--  <br>
                    <?php // echo '<img style="margin-top:10px;" src="data:image/png;base64,' . DNS2D::getBarcodePNG($lims_sale_data->reference_no, 'QRCODE') . '" alt="barcode"   />';?>   
                    </td>
                </tr>
            </tbody>
        </table>-->
        <!-- <div class="centered" style="margin:30px 0 50px">
            <small>{{trans('file.Invoice Generated By')}} {{$general_setting->site_title}}.
            {{trans('file.Developed By')}} LionCoders</strong></small>
        </div> -->
    </div>
</div>

<script type="text/javascript">
    function auto_print() {     
        window.print()
    }
    setTimeout(auto_print, 1000);
</script>

</body>
</html>

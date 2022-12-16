<style type="text/css">
    .page-break {page-break-after: always;}
    .tftable {font-size:16px;color:#333333;width:100%;border-width: 1px;border-color: #fff;border-collapse: collapse;}
    .tftable th {font-size:16px;background-color:#ffc107;border-width: 1px;padding: 8px;border-style: solid;border-color: #fff;text-align:left;}
    .tftable tr {background-color:#ffffff;}
    .tftable td {font-size:16px;border-width: 1px;padding: 8px;border-style: solid;border-color: #fff;}
</style>
<table class="tftable page-break" border="1">
    <tbody>
        <thead>
            <tr>
                <td colspan="6" style="text-align: center;">
                    <img
                        class="img-fluid" src="{{ asset('assets/images/jimbo.png') }}"
                        style="height: 50px; width: 150px; "
                    >
                    <br>
                    <span style="font-size: 25px;"><b> Recibo de {{$type}} {{ str_pad($sale->id,6,"0",STR_PAD_LEFT)}}</b> </span>
                    <br>
                </td>
           </tr>
            <tr>
                <th colspan="6" style="text-align: center; text-transform:uppercase"></th>
           </tr>
        </thead>
    <tbody>
        @if ($operation=='shopping')
            <tr>
                <td colspan="3"> <b> Comprador: </b></td>
                <td colspan="3" align="right">{{$buyer}}</td>
            </tr>
            <tr>
                <td colspan="3"> <b>Codigo de la promocion de boletos: </b></td>
                <td colspan="3" align="right">{{$sale->Ticket->serial}}</td>
            </tr>
            <tr>
                <td colspan="3"> <b>Cantidad de boletos: </b></td>
                <td colspan="3" align="right">{{$sale->quantity}}</td>
            </tr>
            <tr>
                <td colspan="3"> <b>Numero de operacion: </b></td>
                <td colspan="3" align="right">{{$sale->number}}</td>
            </tr>
            <tr>
                <td colspan="3"> <b>Tipo operacion: </b></td>
                <td colspan="3" align="right">{{$sale->method == 'card' ? 'Tarjeta': 'Jib'}}</td>
            </tr>
            <tr>
                <td colspan="3"> <b>Fecha: </b></td>
                <td colspan="3" align="right">{{\Carbon\Carbon::parse($sale->created_at)->format('d/m/Y H:i:s')}}</td>
            </tr>
            <tr>
                <td colspan="3"> <b>Monto en USD: </b></td>
                <td colspan="3" align="right">{{Helper::amount($sale->Ticket->promotion->price)}}</td>
            </tr>
            @if ($sale->method == 'jib')
                <tr>
                    <td colspan="3"> <b>Cantidad en Jib: </b></td>
                    <td colspan="3" align="right">{{Helper::jib($amout_jib)}}</td>
                </tr>
            @endif
            <tr>
                <th colspan="6">
                    Boletos Adquiridos: <br>
                    @foreach ($sale->TicketsUsers as $value)
                        <b>{{$value->serial}}</b>
                    @endforeach
                </th>
            </tr>

        @elseif ($operation =='sale')
            <tr>
                <td colspan="3"> <b> Comprador: </b></td>
                <td colspan="3" align="right">{{$buyer}}</td>
            </tr>
            <tr>
                <td colspan="3"> <b> Vendedor: </b></td>
                <td colspan="3" align="right">{{$seller}}</td>
            </tr>
            <tr>
                <td colspan="3"> <b>Codigo de la promocion de boletos: </b></td>
                <td colspan="3" align="right">{{$sale->Ticket->serial}}</td>
            </tr>
            <tr>
                <td colspan="3"> <b>Cantidad de boletos: </b></td>
                <td colspan="3" align="right">{{$sale->quantity}}</td>
            </tr>
            <tr>
                <td colspan="3"> <b>Numero de operacion: </b></td>
                <td colspan="3" align="right">{{$sale->number}}</td>
            </tr>
            <tr>
                <td colspan="3"> <b>Tipo operacion: </b></td>
                <td colspan="3" align="right">{{$sale->method == 'card' ? 'Tarjeta': 'Jib'}}</td>
            </tr>
            <tr>
                <td colspan="3"> <b>Fecha: </b></td>
                <td colspan="3" align="right">{{\Carbon\Carbon::parse($sale->created_at)->format('d/m/Y H:i:s')}}</td>
            </tr>
            <tr>
                <td colspan="3"> <b>Monto en USD: </b></td>
                <td colspan="3" align="right">{{Helper::amount($sale->Ticket->promotion->price)}}</td>
            </tr>
            @if ($sale->method == 'jib')
                <tr>
                    <td colspan="3"> <b>Cantidad en Jib: </b></td>
                    <td colspan="3" align="right">{{Helper::jib($amout_jib)}}</td>
                </tr>
            @endif
            <tr>
                <th colspan="6">
                    Boletos Adquiridos: <br>
                    @foreach ($sale->TicketsUsers as $value)
                        <b>{{$value->serial}}</b>
                    @endforeach
                </th>
            </tr>
        @endif
    </tbody>
</table>

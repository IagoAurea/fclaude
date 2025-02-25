@extends('user::layouts.invoice')

@section('content')
    <div class="content">
        <table aria-describedby="invoice-header" class="invoice-header">
            <th>
                <tr>
                    <td style="width:60%;"></td>
                </tr>
            </th>
            <tr>
                <td class="center">
                    <div style="color: #00e9c5; font-size: 24px; font-weight: bold; font-family: Arial, Verdana, Tahoma, sans-serif;">
                        @lang('user::messages.invoice') N.° {{$invoice->invoice_number}}
                    </div>
                </td>
                <td>
                    <div style="color: #00e9c5; font-size: 18px; font-weight: bold; font-family: Arial, Verdana, Tahoma, sans-serif;">
                        {{Str::upper($business->name)}}
                    </div>
                </td>
            </tr>
            <tr>
                <td class="center">
                    <div class="color-blue bold">
                        {{$invoice->created_at->format('d \d\e F \d\e Y')}}
                    </div>
                </td>
                <td>
                    <strong class="color-blue">CIF: </strong>{{$business->cif}}
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <strong class="color-blue">@lang('user::messages.country'): </strong>{{$business->country->name}}
                    <strong class="color-blue">@lang('user::messages.city'):</strong>{{$business->city}}
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <strong class="color-blue">@lang('user::messages.address'): </strong>{{$business->address}}
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <strong class="color-blue">@lang('user::messages.zip_code'): </strong>{{$business->code_postal}}
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <strong class="color-blue">@lang('user::messages.phone'): </strong>{{$business->phone}}
                </td>
            </tr>
        </table>
        <div style="margin-top:20px"></div>
        <table aria-describedby="invoice-client" style="margin-left:50px">
            <th>
                <tr>
                    <td style="width:30%"></td>
                    <td></td>
                </tr>
            </th>
            <tr>
                <td>
                    <div style="color: #00e9c5; font-size: 18px; font-weight: bold; font-family: Arial, Verdana, Tahoma, sans-serif;">
                        @lang('user::messages.bill_to'):
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="font-size: 18px;" class="color-blue bold">
                        {{ Str::upper($invoice->user->full_name) }}
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <strong class="color-blue">@lang('user::messages.dni') :</strong> {{ $invoice->user->dni}}
                </td>
            </tr>
            <tr>
                <td>
                    <strong style="font-family: Arial, Verdana, Tahoma, sans-serif;" class="color-blue">@lang('user::messages.country'):</strong> {{$invoice->user->country->name}},
                    <strong style="font-family: Arial, Verdana, Tahoma, sans-serif;" class="color-blue">@lang('user::messages.city'):</strong> {{$invoice->user->city}}
                </td>
            </tr>
            <tr>
                <td>
                    <strong style="font-family: Arial, Verdana, Tahoma, sans-serif;" class="color-blue">@lang('user::messages.address'):</strong> {{$invoice->user->address}}
                </td>
            </tr>
            <tr>
                <td>
                    <strong style="font-family: Arial, Verdana, Tahoma, sans-serif;" class="color-blue">@lang('user::messages.zip_code'):</strong> {{$invoice->user->zipcode}}
                </td>
            </tr>
        </table>
        <table aria-describedby="invoice-detail" style="margin-top:20px">
            <tr class="invoice-detail-header">
                <th style="width:40%; font-family: Arial, Verdana, Tahoma, sans-serif;">@lang('user::messages.description')</th>
                <th style="width:20%; font-family: Arial, Verdana, Tahoma, sans-serif;">@lang('user::messages.quantity')</th>
                <th style="width:20%; font-family: Arial, Verdana, Tahoma, sans-serif;">@lang('user::messages.price')</th>
                <th style="width:20%; font-family: Arial, Verdana, Tahoma, sans-serif;">@lang('user::messages.total')</th>
            </tr>
            <tr>
                <td style="margin-left: 30px; padding: 15px; font-family: Arial, Verdana, Tahoma, sans-serif;" class="center">
                    {{$invoice->description}}
                </td>
                <td class="center" style="font-family: Arial, Verdana, Tahoma, sans-serif;">
                    {{$invoice->subscription->quantity}}
                </td>
                <td class="center" style="font-family: Arial, Verdana, Tahoma, sans-serif;">
                    {{$invoice->subtotal / $invoice->subscription->quantity}} &{{Config::get('api.currency')}};
                </td>
                <td class="right" style="padding-right: 20px; font-family: Arial, Verdana, Tahoma, sans-serif;">
                    {{$invoice->subtotal}} &{{Config::get('api.currency')}};
                </td>
            </tr>
        </table>
        <hr style="background: #050C44;">
        <table aria-describedby="invoice-total">
            <th>
                <tr>
                    <td style="width:60%; font-family: Arial, Verdana, Tahoma, sans-serif;"></td>
                    <td style="width:30%; font-family: Arial, Verdana, Tahoma, sans-serif;"></td>
                </tr>
            </th>
            <tr style="padding: 10px;">
                <td></td>
                <td class="bold" style="font-family: Arial, Verdana, Tahoma, sans-serif;">
                    @lang('user::messages.subtotal')
                </td>
                <td class="right" style="padding-right: 20px; font-family: Arial, Verdana, Tahoma, sans-serif;">
                    {{$invoice->subtotal}} &{{Config::get('api.currency')}};
                </td>
            </tr>
            <tr style="padding: 10px;">
                <td></td>
                <td class="bold" style="font-family: Arial, Verdana, Tahoma, sans-serif;">
                    @lang('user::messages.tax') ({{$invoice->user->tax->name}} {{$invoice->user->tax->value}} %)
                </td>
                <td class="right" style="padding-right: 20px; font-family: Arial, Verdana, Tahoma, sans-serif;">
                    {{$invoice->tax}} &{{Config::get('api.currency')}};
                </td>
            </tr>
            <tr style="padding: 10px;">
                <td></td>
                <td class="bold" style="font-family: Arial, Verdana, Tahoma, sans-serif;">
                    @lang('user::messages.total')
                </td>
                <td class="right" style="padding-right: 20px; font-family: Arial, Verdana, Tahoma, sans-serif;">
                    {{$invoice->total}} &{{Config::get('api.currency')}};
                </td>
            </tr>
        </table>
        <div style="margin-top: 25%; margin-left: 30px; font-family: Arial, Verdana, Tahoma, sans-serif;">
            @if($invoice->user->tax->value == 0)
            <div class="color-red exempt-tax" style="font-family: Arial, Verdana, Tahoma, sans-serif;">
                @if(!$invoice->user->country->belongs_ue && !$invoice->user->is_company)
                    @lang('user::messages.article_three')
                @else
                    @lang('user::messages.article_one')
                @endif
            </div>
            @endif
        </div>
    </div>
@endsection
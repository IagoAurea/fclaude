<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Invoice</title>
        <link rel="stylesheet" href="{{ ltrim(mix('css/app.css'), '/') }}">
        <style>
            @font-face {
                font-family: 'cachet-bold';
                src: url({{ storage_path('fonts/cachet-std-bold.ttf') }}) format("truetype");
                font-weight: 400;
                font-style: normal;
            }

            @font-face {
                font-family: 'cooper-hewitt-thin';
                src: url({{ storage_path('fonts/cooper-hewitt-thin.ttf') }}) format("truetype");
                font-weight: 400;
                font-style: normal;
            }

            @font-face {
                font-family: 'cooper-hewitt-bold';
                src: url({{ storage_path('fonts/cooper-hewitt-semibold.ttf') }}) format("truetype");
                font-weight: 400;
                font-style: normal;
            }

            body {
                background: url({{ public_path() . '/images/pdf-banner.png' }}) center top fixed no-repeat;
                border: inset 0.5px transparent;
                margin-top: 5px;
                background-repeat: no-repeat;
                background-size: 97% 8%;
            }

            .pdf-date {
                position: absolute;
                width: 100%;
                bottom: -1px;
                font-family: 'cooper-hewitt-bold';
                color: #00e9c5;
                font-size: 15px;
                padding-top: 15px;

                background-image: url({{ public_path() . '/images/pdf-bottom-banner.png' }});
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-position: right;
                background-size: 40% 100%;
            }

            /****/
        </style>

       {{-- Laravel Mix - CSS File --}}

    </head>
    <body>
      <div class="pdf-content">
         <section>
            <div class="pdf-title">
               FACTURA N.°{{ str_pad($lastPayment->id, 3, '0', STR_PAD_LEFT); }}
            </div>
            <div class="pdf-title-secondary">
               {{ strtoupper(strftime( "%A %d de %B del %Y" )) }}
            </div>
            <div class="section-1-left-invoice">
               <div class="pdf-title">
                  FACTURAR A
               </div>
               <div class="pdf-title-secondary">
                  {{ strtoupper($user->full_name) }}
               </div>
               <ul class="pdf-attributes-invoice">
                  <li>
                     <span class="pdf-text-bold"> DNI/CIF:</span> <span class="pdf-text-thin">{{ $user->dni }}</span>
                  </li>
                  <li>
                     <span class="pdf-text-bold"> Dirección:</span> <span class="pdf-text-thin">{{ $user->address }}</span>
                  </li>
                  <li>
                     <span class="pdf-text-bold"> País:</span> <span class="pdf-text-thin">{{ $user->country->name }}</span>
                     <span class="pdf-text-bold"> Ciudad:</span> <span class="pdf-text-thin">{{ $user->city }}</span>
                  </li>
                  <li>
                     <span class="pdf-text-bold"> Código Postal:</span> <span class="pdf-text-thin">{{ $user->zipcode }}</span>
                  </li>
               </ul>
            </div>
            <div class="section-1-right-invoice">
               <div class="pdf-title">
                  FISICALCOACH, S.L
               </div>
               <ul class="pdf-attributes-invoice">
                  <li>
                     <span class="pdf-text-bold"> CIF:</span> <span class="pdf-text-thin">B01836626.</span>
                  </li>
                  <li>
                     <span class="pdf-text-bold"> Dirección:</span> <span class="pdf-text-thin">Calle Ruiz de Padrón, 48. San Sebast ián de la Gomera, S/Cruz de Tenerife.</span>
                  </li>
                  <li>
                     <span class="pdf-text-bold"> País:</span> <span class="pdf-text-thin">ESPAÑA.</span>
                     <span class="pdf-text-bold"> Ciudad:</span> <span class="pdf-text-thin">Tenerife</span>
                  </li>
                  <li>
                     <span class="pdf-text-bold"> CP:</span> <span class="pdf-text-thin">38800</span>
                  </li>
                  <li>
                     <span class="pdf-text-bold"> Teléfono:</span> <span class="pdf-text-thin">+34 616 64 85 18</span>
                  </li>
               </ul>
            </div>
         </section>
         <div>
            <table class="table-bar" aria-describedby="Tabla sobre los detalles de la factura.">
               <thead>
                  <tr>
                     <th>DESCRIPCIÓN</th>
                     <th>CANT.</th>
                     <th>PRECIO</th>
                     <th>TOTAL</th>
                  </tr>
               </thead>
               <tbody>
                  <tr>
                     <td>{{ $lastPayment->description }}</td>
                     <td>1</td>
                     <td>{{ $lastPayment->subtotal }}&euro;</td>
                     <td>{{ $lastPayment->subtotal }}&euro;</td>
                  </tr>
               </tbody>
            </table>
            <hr style="height:5px;border-width:0;background-color:#050C44">
            <div class="invoice-details">
               <div class="pdf-title-secondary">
                  SUBTOTAL: <span class="tab"></span> <span style="font-family: Arial, Helvetica, sans-serif; float: right;">{{ $lastPayment->subtotal }}&euro;</span>
               </div>
               @if($lastPayment->tax)         
               <div class="pdf-title-secondary">
                  IMPUESTOS ({{ $lastPayment->tax }}%): <span class="tab"></span> <span style="font-family: Arial, Helvetica, sans-serif; float: right;">{{ $lastPayment->total - $lastPayment->subtotal }}&euro;</span>
               </div>
               @else
               <div class="pdf-title-secondary">
                  IMPUESTOS (0%): <span class="tab"></span> <span style="font-family: Arial, Helvetica, sans-serif; float: right;">0&euro;</span>
               </div>
               @endif
               <div class="pdf-title-secondary">
                  TOTAL: <span class="tab"></span> <span style="font-family: Arial, Helvetica, sans-serif; float: right;">{{ $lastPayment->total }}&euro;</span>
               </div>
            </div>
         </div>
         <div class="pdf-date">
            <span style="padding-left: 15px;color: #03002D;letter-spacing: 5px;">FACTURA GENERADA EL DÍA: </span> {{ \Carbon\Carbon::now()->format('d/m/Y') }}
         </div>
      </div>
   </body>    
</html>





import { Component, OnInit, DoCheck, Input, ViewChild } from '@angular/core';
import { Router } from '@angular/router';
import { AlertsApiService } from 'src/app/generals-services/alerts-api.service';
import { StripeScriptTag, StripeCard } from 'stripe-angular';
import { ServicesService } from '../../services/services.service';

declare var $: any;

@Component({
  selector: 'app-stripe',
  templateUrl: './stripe.component.html',
  styleUrls: ['./stripe.component.scss'],
})
export class StripeComponent implements OnInit, DoCheck {
  @ViewChild(StripeCard) stripeCard: StripeCard;
  token: any;
  invalidError: any;
  cardCaptureReady: any;
  extraData: any;
  cardDetailsFilledOut = false;
  enviado: any;
  options: any = {};
  planType: { code: string };
  loading: boolean = false;
  @Input() numero: any;
  clientSecret: string = '';

  constructor(
    public msj: AlertsApiService,
    public http: ServicesService,
    public router: Router,
    private stripeScriptTag: StripeScriptTag // Inyección del servicio
  ) { }

  ngOnInit(): void {
    console.log('ID de usuario en localStorage:', localStorage.getItem('uvr'));
    this.loadClientSecret();
    const planSelected =
      JSON.parse(localStorage.getItem('item') as string)?.code || 'sport';
    this.planType = planSelected;

    this.options = {
      hidePostalCode: true,
      style: {
        base: {
          color: '#21219b',
          fontFamily: 'Montserrat, Open Sans, Segoe UI, sans-serif',
          fontSize: '15px',
          fontSmoothing: 'antialiased',
          ':focus': { color: '#424770' },
          '::placeholder': { color: '#9BACC8' },
          ':focus::placeholder': { color: '#2c3954' },
        },
        invalid: {
          color: '#f54242',
          ':focus': { color: '#FA755A' },
          '::placeholder': { color: '#FFCCA5' },
        },
      },
      iconStyle: 'solid',
    };

  }

  ngDoCheck() { }

  // onStripeInvalid(error: any) {
  //   console.log('Validation Error', error);
  // }

  onStripeError(error: any) {
    console.error('Stripe error', error);
  }

  // setPaymentMethod(token: stripe.paymentMethod.PaymentMethod) {
  //   this.loading = true;
  //   this.msj.succes('Procesando pago');
  //   localStorage.setItem('paytoken', token.id);
  //   this.enviado = token.id;
  //   if (token.id) {
  //     this.send();
  //   } else {
  //     this.loading = false;
  //   }
  // }

  setStripeToken(token: stripe.Token) {
    console.log('Stripe Token', token);
  }

  setStripeSource(source: stripe.Source) {
    console.log('Stripe Source', source);
  }

  loadClientSecret() {
    const userId = localStorage.getItem('uvr');
    console.log('ID de usuario obtenido:', userId); // Log para verificar el ID

    if (userId) {
      this.http.getClientSecret(userId).subscribe(
        (response: any) => {
          console.log('Respuesta del backend:', response); // Log para ver la respuesta completa
          if (response.success) {
            this.clientSecret = response.data.client_secret;
            console.log('Client Secret obtenido:', this.clientSecret); // Log para verificar el client secret
          } else {
            console.error('Error:', response.message);
          }
        },
        (error) => console.error('Error en la solicitud getClientSecret:', error)
      );
    } else {
      console.error('No se encontró un ID de usuario en localStorage.');
    }
  }

  async handlePayment() {
    if (!this.clientSecret) {
      this.msj.error('No se encontró un client secret válido.');
      return;
    }

    const stripe = this.stripeScriptTag.StripeInstance;

    try {
      // Cambiar paymentIntent a setupIntent
      const { error, setupIntent } = await stripe.confirmCardSetup(this.clientSecret, {
        payment_method: {
          card: this.stripeCard.elements,
          billing_details: {
            name: 'Nombre del Cliente', // Reemplazar con datos del cliente
          },
        },
      });
      console.log('SetupIntent:', setupIntent);

      if (error) {

        console.error('Error en confirmación del setup:', error);
        this.msj.error(error.message || 'Error en la confirmación del setup.');
      } else if (setupIntent) {
        console.log('SetupIntent:', setupIntent);
        this.msj.succes('Método de pago guardado exitosamente.');
        this.enviado = setupIntent.payment_method; // Usar el ID del SetupIntent
        this.send();
      }
    } catch (err) {
      console.error('Error al procesar el setup:', err);
      this.msj.error('Error inesperado al procesar el setup.');
    }
  }

  send() {
    const env = {
      package_price_id: localStorage.getItem('idsus'),
      interval: localStorage.getItem('typ'),
      quantity: this.numero,
      payment_method_token: this.enviado,
      user_id: localStorage.getItem('uvr'),
      type: this.planType,
    };

    this.http.sendSubscripcion(env).subscribe(
      (data: any) => {
        if (data.success === true) {
          $('#exampleModalStripe').modal('hide');
          this.msj.succes(data.message);
          this.router.navigateByUrl('login');
          localStorage.clear();
        }
        this.loading = false;
      },
      ({ error }) => {
        this.msj.error(error);
        this.loading = false;
      }
    );
  }
}

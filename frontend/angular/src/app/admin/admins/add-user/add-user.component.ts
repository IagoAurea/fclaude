import { Component, EventEmitter, Input, OnChanges, OnInit, Output, SimpleChanges } from '@angular/core';
import { Validators, UntypedFormGroup, UntypedFormBuilder } from '@angular/forms';
import { ProfieService } from 'src/app/modules/profile/profile-services/profie.service';
import { AppStateService } from 'src/app/stateManagement/appState.service';
import FormUtils from 'src/app/utils/formUtils';
import { TranslateService } from '@ngx-translate/core';
import { AlertsApiService } from 'src/app/generals-services/alerts-api.service';
import { MustMatch } from 'src/app/core/helpers/must-match.validator';
import { Router } from '@angular/router';
import { PublicDataService } from '../../services/public-data.service';

interface ProvincesResponse {
  data: any[]; // Asume que 'data' es un array. Cambia 'any[]' por el tipo real de tus provincias.
}

@Component({
  selector: 'app-add-user',
  templateUrl: './add-user.component.html',
  styleUrls: ['./add-user.component.scss'],
})
export class AddUserComponent implements OnInit, OnChanges {
  authToken: string;

    loading: boolean = false;
  registerForm: UntypedFormGroup;
  datas: any;
  loadingSubmit: boolean = false;

  data: any;
  @Input() perfilDialog: boolean = false;
  gender: any = [];
  genderIdentity: any = [];
  country: any = [];
  provinces: any = [];

  @Output() close = new EventEmitter<boolean>();
  @Output() refreshProvinceList = new EventEmitter<any>();
  @Output() formSubmitted = new EventEmitter<void>();
  @Output() openNewModal = new EventEmitter<any>();
  @Output() openSecondModal = new EventEmitter<void>();

  formUtils = new FormUtils();

  regxAlphabeticCustom: RegExp = /[A-Za-záéíóú.ñ ]/g;
  regxAlphabeticNumCustom: RegExp = /[A-Za-z0-9_#\- ]/g;

  constructor(
    public router: Router,
    private formBuilder: UntypedFormBuilder,
    private translate: TranslateService,
    public http: ProfieService,
    public alerts: AlertsApiService,
    private publicDataService: PublicDataService,

    public appStateService: AppStateService
  ) {
    // Register user sample
    this.loadForm();
  }
  ngOnChanges(changes: SimpleChanges): void {
    throw new Error('Method not implemented.');
  }

  get f() {
    return this.registerForm.controls;
  }

  closeDialog() {
    this.perfilDialog = false;
    this.close.emit(false);
  }



  ngOnInit(): void {



    this.cargar();
    this.publicDataService.getCountries().subscribe((data: any) => {
      console.log('Countries:', data.data);
      this.country = data.data;
    });

    this.publicDataService.getGender().subscribe((data: any) => {
      console.log('Gender:', data.data);
      this.gender = data.data;
    });

    this.publicDataService.getGenderIdentity().subscribe((data: any) => {
      console.log('Gender Identity:', data);
      if (data && data.data) {
        this.genderIdentity = data.data;
      } else {
        console.error('Error: Response does not contain data property');
      }
      this.callProvinces(this.data.country_id);
    });
  }



  cargar() {
    if (this.data) {
      this.registerForm = this.formBuilder.group({
        full_name: [this.data.full_name, [Validators.required]],
        email: [
          { value: this.data.email, disabled: true },
          [Validators.required],
        ],
        id: [this.data.id],
        gender: [this.data.gender],
        gender_identity_id: [this.data.gender_identity_id],
        username: [this.data.username, [Validators.required]],
        country_id: [this.data.country_id, ],
        address: [this.data.address, [Validators.required]],
        dni: [this.data.dni, [Validators.required]],
        zipcode: [this.data.zipcode],
        province_id: [this.data.province_id],
        city: [this.data.city || null, ],
        phone: [this.vericatePhone(this.data.phone)],
        is_company: [!!this.data.is_company],
        company_name: [this.data.company_name || null],
        company_idnumber: [this.data.company_idnumber || null],
        company_vat: [this.data.company_vat || null],
        company_address: [this.data.company_address || null],
        company_city: [this.data.company_city || null],
        company_zipcode: [this.data.company_zipcode || null],
        company_phone: [this.data.company_phone || null],
      });
      if (this.registerForm?.get('country_id')) {
        this.registerForm.get('country_id')?.valueChanges.subscribe(countryId => {
          this.callProvinces(countryId);
        });
      }


    }
    this.perfilDialog = true;
  }


  callProvinces(id: any = null) {
    const country = this.country.find((c: { id: number }) => c.id === Number(id));
    if (country) {
      this.http.getProvincias(country.iso2).subscribe((data: any) => {
        this.provinces = data.data;
      });
    }
  }

  vericatePhone(num: any) {
    if (num) {
      return num[0];
    } else {
      return '';
    }
  }

  /**
   * refresh list after country select changes
   */
  refreshProvinces(): void {
    const countryId = this.registerForm.value.country_id;
    const country = this.country.find((c: { id: number }) => c.id === Number(countryId));
    if (country) {
      this.http.getProvincias(country.iso2).subscribe(
        (response: any) => {
          this.provinces = response.data;
          console.log(this.provinces);
        },
        (error) => {
          console.error('Error fetching provinces:', error);
        }
      );
    }
  }
  send() {
    this.loadingSubmit = true;

    if (this.registerForm.valid) {
      const env = this.formUtils.removeNullValues(this.registerForm.value);



      env.phone = [env.phone];
      // Emitimos los datos del formulario al componente padre
      this.openNewModal.emit(env);
      // Emitimos un evento para abrir el segundo modal
      this.openSecondModal.emit();

      this.loadingSubmit = false;
    } else {
      this.loadingSubmit = false;
      this.alerts.error(this.translate.instant('profile.fieldsrequired'));
    }
  }
  load() {
    window.location.reload();
  }

  validateMobile(event: any) {
    let rgxNumber = event.target.value;
    rgxNumber = rgxNumber.match(/\+?\d+/g);
    if (rgxNumber?.length > 0) {
      rgxNumber.join('');
    }
    event.target.value = event.target.value === '+' ? `+` : rgxNumber;
  }

  private loadForm() {
    this.registerForm = this.formBuilder.group(
      {
        email: [null, [Validators.required, Validators.email]],
        password: [null],
        id: [null],
        gender: [null],
        gender_identity_id: [null],
        username: [null, Validators.required],
        country_id: [null],
        full_name: [null, Validators.required],
        city: [''],
        confirmPassword: [null],
        address: [null, [Validators.required]],
        dni: [null, Validators.required],
        zipcode: [null],
        province_id: [null],
        phone: [null],
        is_company: [false],
        company_name: [null],
        company_idnumber: [null],
        company_vat: [null],
        company_address: [null],
        company_city: [null],
        company_zipcode: [null],
        company_phone: [null],
      },
      {
        validator: MustMatch('password', 'confirmPassword'),
      }
    );
  }

  private handleError(error: any) {
    let err: any = null;
    try {
      err = JSON.parse(error);
    } catch (err) {
      return this.translate.instant('profile.updateerror');
    }
    let msg = '';
    if (err.errors) {
      const keys = Object.keys(err.errors);
      keys.map((x) => {
        msg = msg + err.errors[x][0] + '\n';
      });
      return msg;
    } else {
      return this.translate.instant('profile.updateerror');
    }
  }
}

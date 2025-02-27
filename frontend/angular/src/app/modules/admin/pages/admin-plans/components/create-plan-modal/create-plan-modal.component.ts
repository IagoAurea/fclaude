import { ChangeDetectorRef, Component, Inject, OnInit, ViewEncapsulation } from '@angular/core';
import { MAT_DIALOG_DATA, MatDialog, MatDialogRef } from '@angular/material/dialog';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { DomSanitizer } from '@angular/platform-browser';
import { SafeUrl } from '@angular/platform-browser';
import { environment } from 'src/environments/environment';
import { fileToBase64 } from 'src/app/utils/base64Converter';
import { PlanService } from '../../../../services/plan-service/plan.service';
import { ProfieService } from 'src/app/modules/profile/profile-services/profie.service'; // Importar ProfieService
import { co } from '@fullcalendar/core/internal-common';
import { AbstractControl } from '@angular/forms';
import { Router } from '@angular/router';
import Swal from 'sweetalert2';
import { TranslateService } from '@ngx-translate/core';
import { PackageStateService } from 'src/app/modules/admin/services/plan-service/packageState.service';


@Component({
  selector: 'app-create-plan-modal',
  templateUrl:'./create-plan-modal.component.html',
  styleUrls: ['./create-plan-modal.component.scss']
})
export class CreatePlanModalComponent implements OnInit {
  newForm: FormGroup;
  getLabelProfileType = 'Profile Type';
  getLabelPlanType = 'Plan Type';
  getLabelName = 'Name';
  getLabelDescription = 'Description';
  getLabelStatus = 'Status';
  getLabelMonthlyPrice = 'Monthly Price';
  getLabelAnnualPrice = 'Annual Price';
  getLabelSave = 'Save';
  getLabelCancel = 'Cancel';
  visible = true;
  step = 1;
  showUpdateImagen: boolean = false;
  urlBase = environment.images;
  openCropperDialog: boolean = false;
  team_image_name = '';
  competition_image_name = '';
  teamImgPrev: SafeUrl;
  name = [''];
  description = [''];
  status = [''];
  monthlyPrice = [''];
  annualPrice = [''];
  profileType = [''];
  planType = [''];
  educationalCenter = [''];
  educationalCenterEnabled = [''];
  classesEnabled = [''];
  classes = [''];
  detailSubcription: boolean = false;
  tempQuantity: any = {};
  editFlags: any = {}; 
  packages: any[] = []; // Para almacenar los paquetes obtenidos
  fixedPlanType: [''];
  loading = false;

  selectedCompetition = { image: { full_url: '' } };

  constructor(
    @Inject(MAT_DIALOG_DATA) public data: any,
    private formBuilder: FormBuilder,
    private translateService: TranslateService,
    public dialogRef: MatDialogRef<CreatePlanModalComponent>,
    private dialog: MatDialog,
    private sanitizer: DomSanitizer,
    private cdr: ChangeDetectorRef,
    private planService: PlanService,
    private profieService: ProfieService,
    private router: Router,
    private packageStateService: PackageStateService

  ) { }

  ngOnInit(): void {
    // this.profieService.getSubpackagesAttributes().subscribe((res: any) => {
    // this.packages = res.data;
    //  console.log(this.packages);

    
    console.log('Datos del primer modal:', this.data.firstModalData);
    this.profieService.getPackeges().subscribe((res: any) => {
      this.packages = res.data;
      console.log(this.packages);

      // Inicializa selectedPackage con el primer subpaquete del primer paquete por defecto
      this.data.selectedPackage = this.packages[0].subpackages[0];

      // Obtiene el control de formulario 'profileType'
      const profileTypeControl = this.newForm.get('profileType');

      // Comprueba si el control de formulario 'profileType' existe antes de suscribirse a los cambios de valor
      if (profileTypeControl) {
        profileTypeControl.valueChanges.subscribe(value => {
          // Mapea el valor del formulario a los códigos de paquete correspondientes
          const valueToPackageCodeMap = {
            'Profesor': 'teacher',
            'Sport': 'sport'
          };

          // Busca el paquete que coincide con el valor seleccionado
          let selectedPackage = this.packages.find(pkg => pkg.code.toLowerCase() === valueToPackageCodeMap[value as 'Profesor' | 'Sport']);

          // Si se encuentra un paquete, selecciona el subpaquete basado en el valor seleccionado
          if (selectedPackage) {
            if (value === 'Profesor') {
              // Selecciona el subpaquete 'P.E. Profesor Oro'
              this.data.selectedPackage = selectedPackage.subpackages.find((subpkg: { name: string }) => subpkg.name === 'P.E. Profesor Oro');
            } else {
              // Selecciona el primer subpaquete
              this.data.selectedPackage = selectedPackage.subpackages[0];
            }
          } else {
            console.log('Paquete no encontrado');
          }

          // Actualiza tempQuantity y editFlags basado en el nuevo subpaquete seleccionado
          for (let dato of this.data.selectedPackage.attributes) {
            if (dato.pivot.quantity) {
              this.tempQuantity[dato.id] = dato.pivot.quantity;
            } else {
              this.tempQuantity[dato.id] = dato.pivot.available;
            }
            this.editFlags[dato.id] = false;
          }

          // Forzar la detección de cambios
          this.cdr.detectChanges();
        });
      }
    });


    this.newForm = this.formBuilder.group({
      status: [false, Validators.required],
      monthlyPrice: ['', [
        Validators.required,
        Validators.min(0),
        Validators.pattern("^[0-9]*$") // Solo permite números
      ]],
      annualPrice: ['', [
        Validators.required,
        Validators.min(0),
        Validators.pattern("^[0-9]*$") // Solo permite números
      ]],
      profileType: ['', Validators.required],
      planType: ['', Validators.required],
      fixedPlanType: [{ value: '', disabled: true }],
      image: [''],
      name_es: ['', [Validators.required, Validators.maxLength(30), Validators.pattern("^[a-zA-ZÀ-ÿ]*$")]], // Solo texto
      description_es: ['', [Validators.required, Validators.maxLength(200)]],
      name_en: ['', [Validators.required,Validators.maxLength(30), Validators.pattern("^[a-zA-ZÀ-ÿ]*$")]], // Solo texto
      description_en: ['', [Validators.required,Validators.maxLength(200)]],
    });



    // Suscríbete a los cambios de valor de 'planType'
    const planTypeControl = this.newForm.get('planType');
    const fixedPlanTypeControl = this.newForm.get('fixedPlanType');

    if (planTypeControl && fixedPlanTypeControl) {
      planTypeControl.valueChanges.subscribe(value => {
        if (value === 'Fijo') {
          fixedPlanTypeControl.enable();
        } else {
          fixedPlanTypeControl.disable();
        }
      });
    }

  }

  createFormControlGroup() {
    return this.formBuilder.group({
      enabled: [false],
      value: ['']
    });
  }
  getDialogSize(): { width: string, height: string } {
    return window.innerWidth < 768 ? { width: '90vw', height: '90vh' } : { width: '50vw', height: '100vh' };
  }


  onNumberInputChange(event: Event, fieldGroup: string) {
    const target = event.target as HTMLInputElement;
    const fieldGroupControl = this.newForm.get('additionalFields')?.get(fieldGroup);
    if (target) {
      // Actualiza el valor guardado siempre que el campo de entrada numérico cambie
      fieldGroupControl?.get('value')?.setValue(target.value);
    }
  }
  goBack() {
    if (this.step == 1) {
      this.closeDialog();
    } else if (this.step == 2) {
      this.step = 1;

      // Comprobar el tipo de perfil antes de resetear los datos
      if (this.newForm.get('profileType')?.value == 'Profesor' || this.newForm.get('profileType')?.value == 'Sport') {
        // Resetear los datos
        this.editFlags = {};
        this.tempQuantity = {};
      }
    }
  }
  closeDialog() {
    this.dialogRef.close();
  }

  openImageCropperDialog(): void {
    this.openCropperDialog = true;
  }

  readURL(file: File, type: string): void {
    if (file) {
      const validFormats = ['image/png', 'image/jpeg', 'image/jpg'];

      if (!validFormats.includes(file.type)) {
        this.newForm.get('image')?.setErrors({ 'invalidFormat': true });
        return;
      }

      const reader = new FileReader();
      reader.onload = (e) => {
        const base64Image = reader.result as string;

        this.newForm.get('image')?.setValue(base64Image);
        this.competition_image_name = file?.name;

        this.teamImgPrev = this.sanitizer.bypassSecurityTrustUrl(base64Image);
      };
      reader.readAsDataURL(file);
      this.openCropperDialog = false;
    }
  }
  getImage(file: File): void {
    this.readURL(file, this.step === 1 ? 'competition' : 'team');
  }

  onImageCropped(croppedImage: string): void {
    // Aquí puedes manejar la imagen recortada
    console.log(croppedImage);
    this.openCropperDialog = false;
  }
  shouldSendForm() {
    const planType = this.newForm.get('planType')?.value;
    const fixedPlanType = this.newForm.get('fixedPlanType')?.value;
    return planType === 'Fijo';
  }

  nextStep() {
    if (this.newForm.valid) {
      this.step++;
    } else {
      console.log(this.newForm.controls);

      console.log('Por favor, rellene todos los campos correctamente antes de continuar.');
      Object.keys(this.newForm.controls).forEach(control => {
        const errors = this.newForm.get(control)?.errors;
        if (errors) {
          console.log(`Errores en el control ${control}:`, errors);
        }
      });

    }
  }

  onSubmit() {
    if (this.newForm.valid) {
      // Recorre cada atributo en data.selectedPackage.attributes
      for (let attribute of this.data.selectedPackage.attributes) {
        // Si el atributo tiene un pivot
        if (attribute.pivot) {
          // Si el atributo está siendo editado
          if (this.editFlags[attribute.id]) {
            // Actualiza quantity y available en el pivot del atributo
            attribute.pivot = {
              ...attribute.pivot,
              quantity: this.tempQuantity[attribute.id],
              available: this.editFlags[attribute.id]
            };
          } else {
            // Si el atributo no está siendo editado, establece available en false
            attribute.pivot.available = false;
          }
        }
      }

      // Añade los datos modificados al formulario
      this.newForm.addControl('modifiedData', new FormControl(this.data.selectedPackage));

      console.log('Plan Type:', this.newForm.get('planType')?.value);
      console.log('Fixed Plan Type:', this.newForm.get('fixedPlanType')?.value);
      console.log('Should send form:', this.shouldSendForm());
      // Verifica si debe enviarse el formulario directamente o pasar al paso 2
      if (this.shouldSendForm()) {
        console.log("Formulario válido y se debe enviar directamente.");
        this.sendForm(); // Enviar formulario si es fijo
      } else {
        console.log("Pasando al paso 2 para planes personalizados.");
        this.step = 2;
        this.loading = true;

        // Convertir la imagen a Base64 antes de enviarla al servidor
        const teamImageFile = this.newForm.get('team_image')?.value as File;
        if (teamImageFile) {
          fileToBase64(teamImageFile).then((base64String) => {
            this.newForm.get('team_image')?.setValue(base64String);
            this.loading = false;

            this.sendForm();

            this.cdr.detectChanges();  // Forzar la detección de cambios
          });
        } else {
          this.sendForm();

          this.loading = false;
          this.cdr.detectChanges();  // Forzar la detección de cambios
        }
      }
    }
  }

  getScreenWidth(): number {
    return window.innerWidth;
  }

  sendForm() {
    // Crear una copia del valor del formulario
    let formValue = { ...this.newForm.value };

    const transformedData = {
      info: {
        es: {
          name: formValue.name_es,
          description: formValue.description_es,
        },
        en: {
          name: formValue.name_en,
          description: formValue.description_en,
        },
        code: formValue.profileType.toLowerCase(),
        package_id: this.data.selectedPackage.package_id,
        custom: formValue.planType === 'Personalizado' ? 1 : 0,
        status: formValue.status ? 1 : 0,
      },
      attributes: formValue.modifiedData.attributes.map((attr: any) => ({
        attribute_id: attr.pivot.attribute_id,
        monthlyquantity: attr.pivot.monthlyquantity || 1,
        annualquantity: attr.pivot.annualquantity || 1,
        available: attr.pivot.available,
        quantity: attr.pivot.quantity || 0,
      })),
      image: formValue.image, // Asegúrate de que sea una cadena Base64
      second_step: {
        educational_center: formValue.educational_center || { enabled: false, value: 0 },
        classes: formValue.classes || { enabled: false, value: 0 },
        students: formValue.students || { enabled: false, value: 0 },
        exercise_design: formValue.exercise_design || { enabled: false, value: 0 },
        training_sessions: formValue.training_sessions || { enabled: false, value: 0 },
        available_scenarios: formValue.available_scenarios || { enabled: false, value: 0 },
        tests: formValue.tests || { enabled: false, value: 0 },
        rubrics: formValue.rubrics || { enabled: false, value: 0 },
        evaluations: formValue.evaluations || { enabled: false, value: 0 },
        tutoring: formValue.tutoring || { enabled: false, value: 0 },
        grades: formValue.grades || { enabled: false, value: 0 },
      },
    };

    if (this.step === 1 && this.shouldSendForm()) {
      this.planService.createPlan(transformedData).subscribe(
        (response) => {
          this.showSuccessNotification('PLAN_FIXED_CREATED');
          this.closeDialog();
          this.redirectToPlanType(formValue.profileType);
          // Notificar al servicio que los paquetes deben refrescarse
          this.packageStateService.refreshPackages(); 
        },
        (error) => {
          this.showErrorNotification('ERROR_CREATING_FIXED_PLAN');
        }
      );
    } else {
      this.planService.createPlan(transformedData).subscribe(
        (response) => {
          this.showSuccessNotification('PLAN_CUSTOMIZED_CREATED');
          this.closeDialog();
          this.redirectToPlanType(formValue.profileType);
          // Notificar al servicio que los paquetes deben refrescarse
          this.packageStateService.refreshPackages(); 
        },
        (error) => {
          this.showErrorNotification('ERROR_CREATING_CUSTOMIZED_PLAN');
        }
      );
    }
  }

  redirectToPlanType(profileType: string) {
    // Redirigir según el tipo de plan
    console.log("Code", profileType)
    if (profileType === 'Sport' || profileType === 'Deportes') {
      this.router.navigate(['/admin/dashboard/plans/sport']);
    } else if (profileType === 'Teacher' || profileType === 'Profesor') {
      this.router.navigate(['/admin/dashboard/plans/teacher']);
    }
  }


  showSuccessNotification(messageKey: string): void {
    const message = this.translateService.instant(`adminPlans.${messageKey}`);
    Swal.fire({
      title: this.translateService.instant('adminPlans.SUCCESS'),
      text: message,
      icon: 'success',
      timer: 3000,
      toast: true,
      position: 'top-end',
      showConfirmButton: false
    });
  }

  showErrorNotification(messageKey: string): void {
    const message = this.translateService.instant(`adminUsers.${messageKey}`);
    Swal.fire({
      title: this.translateService.instant('adminPlans.ERROR'),
      text: message,
      icon: 'error',
      timer: 3000,
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
    });
  }
}
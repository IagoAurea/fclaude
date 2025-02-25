import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';
import { DomSanitizer } from '@angular/platform-browser';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import { PlanService } from '../../services/plan-service/plan.service';
import { TranslateService } from '@ngx-translate/core';
import Swal from 'sweetalert2';
import { Router } from '@angular/router';
import { PackageStateService } from '../../services/plan-service/packageState.service';

@Component({
  selector: 'app-edit-plan-modal',
  templateUrl: './edit-plan-modal.component.html',
  styleUrls: ['./edit-plan-modal.component.scss']
})
export class EditPlanModalComponent implements OnInit {
  @Input() visible: boolean = false;
  @Output() visibleChange = new EventEmitter<boolean>();
  @Input() subpackageData: any = {};
  
  detailSubcription: boolean = false;
  tempQuantity: any = {};
  editFlags: any = {}; // Nueva propiedad
  imageBase64: string = ''; // Para cargar la imagen en base64
  openCropperDialog: boolean = false; // Para controlar el diálogo del recortador
  teamImgPrev: any; // Para mostrar la vista previa de la imagen


  constructor(
    // @Inject(MAT_DIALOG_DATA) public data: any,
    // public dialogRef: MatDialogRef<EditPlanModalComponent>,
    private planService: PlanService, // Inyectar el servicio
    private translateService: TranslateService,
    private router: Router,
    private packageStateService: PackageStateService,
    private sanitizer: DomSanitizer // Inyección del sanitizer
  ) {}


  ngOnInit(): void {

    // Inicializar campos obligatorios con valores predeterminados si están vacíos
    this.subpackageData.nameEs = this.subpackageData.name || 'Nombre por defecto';
    this.subpackageData.descriptionEs = this.subpackageData.description || 'Descripción por defecto';
    this.subpackageData.nameEn = this.subpackageData.name || 'Default name';
    this.subpackageData.descriptionEn = this.subpackageData.description || 'Default description';
    this.subpackageData.code = this.subpackageData.code || 'default-code';
    //this.subpackageData.package_id = this.subpackageData.package_id || 1; // ID por defecto
    this.subpackageData.status = this.subpackageData.status || 1; // Activo por defecto
    
    console.log("Subpackage name en ng oninit ", this.subpackageData.name)
    // Inicializar los valores de los atributos de los subpaquetes
    for (let data of this.subpackageData.attributes) {
      if (data.pivot.quantity === null || data.pivot.quantity === undefined) {
        this.tempQuantity[data.id] = 0; // Inicializar con 0 si no tiene valor
      } else {
        this.tempQuantity[data.id] = data.pivot.quantity; // Asignar la cantidad del pivot
      }
      this.editFlags[data.id] = false; // Inicializar las banderas de edición
    }


    // Asegurarse de que los campos obligatorios estén inicializados
    this.subpackageData.code = this.subpackageData.code || 'default-code';
    this.subpackageData.status = this.subpackageData.status || 1; // Ejemplo: 1 como estado activo
    this.subpackageData.package_id = this.subpackageData.package_id || 1; // Asignar un package_id por defecto

    this.ensureSecondStep();
    console.log("Subpackage data en edit component:", this.subpackageData)
    // Inicializar la vista previa de la imagen si existe
    if (this.subpackageData.image) {
      this.teamImgPrev = this.sanitizer.bypassSecurityTrustUrl(this.subpackageData.image);
      this.imageBase64 = this.subpackageData.image; // Almacenar la imagen en Base64
    } else {
      this.teamImgPrev = ''; // No hay imagen previa
    }
  }

  openImageCropperDialog(): void {
    this.openCropperDialog = true;
  }
  readURL(event: Event): void {
    const input = event.target as HTMLInputElement; // Asegúrate de que es un HTMLInputElement
    if (input.files && input.files.length > 0) { // Verifica si hay archivos
      const file = input.files[0]; // Obtiene el primer archivo

      const validFormats = ['image/png', 'image/jpeg', 'image/jpg'];
      if (!validFormats.includes(file.type)) {
        // Manejar error de formato no válido
        return;
      }

      const reader = new FileReader();
      reader.onload = (e) => {
        const base64Image = reader.result as string;
        this.imageBase64 = base64Image; // Almacena la imagen en Base64
        this.teamImgPrev = this.sanitizer.bypassSecurityTrustUrl(base64Image); // Vista previa
      };
      reader.readAsDataURL(file);
    }
  }

  onImageCropped(croppedImage: string): void {
    this.imageBase64 = croppedImage; // Almacenar la imagen recortada en Base64
    this.teamImgPrev = this.sanitizer.bypassSecurityTrustUrl(croppedImage); // Actualizar vista previa
    this.openCropperDialog = false; // Cerrar diálogo
  }

    ensureSecondStep() {
      if (!this.subpackageData.second_step) {
        this.subpackageData.second_step = {
          educational_center: { enabled: false, value: 0 },
          classes: { enabled: false, value: 0 },
          students: { enabled: false, value: 0 },
          exercise_design: { enabled: false, value: 0 },
          training_sessions: { enabled: false, value: 0 },
          available_scenarios: { enabled: false, value: 0 },
          tests: { enabled: false, value: 0 },
          rubrics: { enabled: false, value: 0 },
          evaluations: { enabled: false, value: 0 },
          tutoring: { enabled: false, value: 0 },
          grades: { enabled: false, value: 0 }
        };
      }
    }
  
  
  
  
      saveData(): void {
        this.ensureSecondStep();
        const requestBody = {
          info: {
            es: {
              name: this.subpackageData.nameEs?.trim() || 'Nombre por defecto',
              description: this.subpackageData.descriptionEs?.trim() || 'Descripción por defecto',
            },
            en: {
              name: this.subpackageData.nameEn?.trim() || 'Default name',
              description: this.subpackageData.descriptionEn?.trim() || 'Default description',
            },
            code: this.subpackageData.code, // Campo obligatorio
            package_id: this.subpackageData.package_id, // Campo obligatorio
            custom: this.subpackageData.custom || 0, // Valor por defecto
            status: this.subpackageData.status, // Campo obligatorio

            // Otros campos
          },
          attributes: this.subpackageData.attributes.map((attribute: any) => ({
            attribute_id: attribute.id,
            monthlyquantity: this.tempQuantity[attribute.id]?.monthly ?? attribute.pivot?.monthlyquantity ?? 1,
            annualquantity: this.tempQuantity[attribute.id]?.annual ?? attribute.pivot?.annualquantity ?? 1,
            available: attribute.pivot?.available ?? false,
            quantity: Number(this.tempQuantity[attribute.id]) || 0, // Convertir a número
          })),


        image: this.imageBase64 || '', // Usar la imagen en formato Base64
      second_step: {
        educational_center: {
          enabled: this.subpackageData.second_step.educational_center.enabled || false,
          value: this.subpackageData.second_step.educational_center.value || 0
        },
        classes: {
          enabled: this.subpackageData.second_step.classes.enabled || false,
          value: this.subpackageData.second_step.classes.value || 0
        },
        students: {
          enabled: this.subpackageData.second_step.students.enabled || false,
          value: this.subpackageData.second_step.students.value || 0
        },
        exercise_design: {
          enabled: this.subpackageData.second_step.exercise_design.enabled || false,
          value: this.subpackageData.second_step.exercise_design.value || 0
        },
        training_sessions: {
          enabled: this.subpackageData.second_step.training_sessions.enabled || false,
          value: this.subpackageData.second_step.training_sessions.value || 0
        },
        available_scenarios: {
          enabled: this.subpackageData.second_step.available_scenarios.enabled || false,
          value: this.subpackageData.second_step.available_scenarios.value || 0
        },
        tests: {
          enabled: this.subpackageData.second_step.tests.enabled || false,
          value: this.subpackageData.second_step.tests.value || 0
        },
        rubrics: {
          enabled: this.subpackageData.second_step.rubrics.enabled || false,
          value: this.subpackageData.second_step.rubrics.value || 0
        },
        evaluations: {
          enabled: this.subpackageData.second_step.evaluations.enabled || false,
          value: this.subpackageData.second_step.evaluations.value || 0
        },
        tutoring: {
          enabled: this.subpackageData.second_step.tutoring.enabled || false,
          value: this.subpackageData.second_step.tutoring.value || 0
        },
        grades: {
          enabled: this.subpackageData.second_step.grades.enabled || false,
          value: this.subpackageData.second_step.grades.value || 0
        }
      }
    };
    console.log("request Body Update: ", requestBody)
    // Llamar al servicio para actualizar
    this.planService
      .updateSubpackage(this.subpackageData.id, requestBody)
      .subscribe(
        response => {
          this.showSuccessNotification('SUCCESS_UPDATE_SUBPACKAGE');
          console.log('Subpaquete actualizado con éxito:', response);
          this.close(); // Cerrar el modal
          this.redirectToPlanType(this.subpackageData.code);
          // Notificar al servicio que los paquetes deben refrescarse
          this.packageStateService.refreshPackages(); 
        },
        error => {
          this.showErrorNotification('ERROR_UPDATE_SUBPACKAGE');
          console.error('Error al actualizar el subpaquete:', error);
        }
      );
  }
  
  
  
  
  close() { 
    this.visible = false;
    this.visibleChange.emit(this.visible);
  }

  redirectToPlanType(code: string) {
    // Redirigir según el tipo de plan
    console.log("Code", code)
    if (code === 'Sport' || code === 'Deportes') {
      this.router.navigate(['/admin/dashboard/plans/teacher']);
    } else if (code === 'Teacher' || code === 'Profesor') {
      this.router.navigate(['/admin/dashboard/plans/sport']);
    }
  }

  hasEmptyFields(): boolean {
    return Object.keys(this.tempQuantity).some(key => {
      const value = this.tempQuantity[key];
      return value === null || value === '' || value === undefined;
    });
  }

  validateEmptyField(id: any): void {
    if (this.tempQuantity[id] === '' || this.tempQuantity[id] === null || this.tempQuantity[id] === undefined || this.tempQuantity[id] < 0 ) {
      this.tempQuantity[id] = 0; // Reemplazar por 0 si está vacío o es menor que 0
    }
  }

  
  onToggleAvailable(data: any): void {
    if (typeof this.tempQuantity[data.id] !== 'object') {
      // Inicializa como objeto si no es ya un objeto
      this.tempQuantity[data.id] = { quantity: 0, monthly: 1, annual: 1 };
    }

    if (!data.pivot.available) {
      this.tempQuantity[data.id].quantity = 0; // Resetear cantidad si está deshabilitado
    }

    console.log(`Estado actualizado para ${data.name}:`, data.pivot.available);
    console.log(`Cantidad actualizada:`, this.tempQuantity[data.id].quantity);
  }



  showSuccessNotification(messageKey: string) {
    const title = this.translateService.instant('adminPlans.SUCCESS');
    const message = this.translateService.instant(`adminPlans.${messageKey}`);
    const confirmText = this.translateService.instant('adminPlans.ButtonOK');

    Swal.fire({
      title: title,
      text: message,
      icon: 'success',
      timer: 3000,
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
    });
  }

  showErrorNotification(messageKey: string) {
    const title = this.translateService.instant('adminPlans.ERROR');
    const message = this.translateService.instant(`adminPlans.${messageKey}`);
    const confirmText = this.translateService.instant('adminPlans.ButtonOK');

    Swal.fire({
      title: title,
      text: message,
      icon: 'error',
      timer: 3000,
      toast: true,
      position: 'top-end',
      showConfirmButton: false
    });
  }
  
  

  
}

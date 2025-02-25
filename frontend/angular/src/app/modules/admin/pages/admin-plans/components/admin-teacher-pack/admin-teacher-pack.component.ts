import { Component, OnDestroy, OnInit } from '@angular/core';
import { Subscription } from 'rxjs';
import { MatDialog } from '@angular/material/dialog';
import { Package } from 'src/app/_models/package';
import { ProfieService } from 'src/app/modules/profile/profile-services/profie.service';
import { ConfirmationService, MessageService } from 'primeng/api';
import { PlanService } from 'src/app/modules/admin/services/plan-service/plan.service';
import Swal from 'sweetalert2';
import { TranslateService } from '@ngx-translate/core';
import { PackageStateService } from 'src/app/modules/admin/services/plan-service/packageState.service';

@Component({
  selector: 'app-admin-teacher-pack',
  templateUrl: './admin-teacher-pack.component.html',
  styleUrls: ['./admin-teacher-pack.component.scss']
})
export class AdminTeacherPackComponent implements OnInit, OnDestroy{
  
  public packages: Package[] = [];
  public subscription$: Subscription;
  p: number = 1;
  itemsPerPage = 10; // Valor inicial
  defaultSubpackage: string;
  icons: any = {
    teacher_bronze: '/assets/img/icons/teacher_bronze.svg',
    teacher_silver: '/assets/img/icons/teacher_silver.svg',
    teacher_gold: '/assets/img/icons/teacher_gold.svg',
  };
  isLoading: boolean = false;
  
  dialogVisible: boolean = false;
  subpackageData: any = {};
  currentLanguage: 'es' | 'en' = 'es'; // Idioma actual
  constructor(private http: ProfieService, private dialog: MatDialog, private confirmationService: ConfirmationService,
    private messageService: MessageService, private packageStateService:PackageStateService, private planService: PlanService, private translateService: TranslateService) {}


  ngOnInit(): void {
    this.packageStateService.currentPackages.subscribe(packages => {
      this.packages = packages;
      // Aquí puedes agregar lógica adicional si es necesario, como volver a cargar los subpaquetes
      this.getSubscriptionPackages(); // O simplemente actualizar la lista si es necesario
    });

    this.getSubscriptionPackages();
    this.defaultSubpackage = 'codigo-de-subpaquete-por-defecto';

  }


  showDialog(subpackage: any) {
    
    this.dialogVisible = true;
    this.subpackageData = subpackage
    console.log('Datos del subpakete ', this.subpackageData);

    
  }

  
  deleteSubpackage(id: number | undefined): void {
    if (id === undefined) {
      console.error('El id del subpaquete no está definido.');
      return;
    }
    
    const confirmButtonText = this.translateService.instant('adminPlans.CONFIRM');
    const cancelButtonText = this.translateService.instant('adminPlans.CANCEL');
    const successTitle = this.translateService.instant('adminPlans.SUCCESS');
    const successMessage = this.translateService.instant('adminPlans.DELETE_SUCCESS');
    const errorTitle = this.translateService.instant('adminPlans.ERROR');
    const errorMessage = this.translateService.instant('adminPlans.DELETE_ERROR');
    // Traducciones dinámicas
    const confirmMessage = this.translateService.instant('adminPlans.CONFIRM_DELETE_SUBPACKAGE');

    Swal.fire({
      title: this.translateService.instant('adminPlans.CONFIRM_DELETE_SUBPACKAGE'),
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: confirmButtonText,
      confirmButtonColor: '#0246a0',
      cancelButtonText: cancelButtonText,
      cancelButtonColor: '#d33',
      customClass: {
        actions: 'swal2-buttons-row', // Clase personalizada para alinear los botones
      },
    }).then((result) => {
      if (result.isConfirmed) {
        this.planService.deleteSubpackage(id).subscribe(
          () => {
            Swal.fire({
              title: successTitle,
              text: successMessage,
              icon: 'success',
              timer: 3000,
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
            });
            this.getSubscriptionPackages();
          },
          (error) => {
            console.error('Error al eliminar el subpaquete:', error);
            Swal.fire({
              icon: 'error',
              title: errorTitle,
              text: errorMessage,
              timer: 3000,
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
            });
          }
        );
      }
    });
  }


  hideDialog(event: any) {
    this.dialogVisible = false;
    // Si se ha editado un subpaquete, recargar los subpaquetes
    if (event) {
      this.getSubscriptionPackages(); // Recargar los subpaquetes automáticamente
    }
  }

  private getSubscriptionPackages(): void {
    this.isLoading = true; // Activar estado de carga
    this.subscription$ = this.http.getPackeges().subscribe(
      (res: any) => {
        this.packages = res.data;
        console.log(this.packages); // Aquí obtengo todos los paquetes y los paso al modal
        this.isLoading = false; // Desactivar estado de carga
      },
      (error) => {

        
        console.error('Error al obtener los paquetes:', error);
        this.isLoading = false; // Desactivar estado de carga incluso en caso de error
      }
    );
  }

  ngOnDestroy(): void {
    if (this.subscription$) {
      this.subscription$.unsubscribe();
    }
  }

  getIcon(name: string | undefined): string {
    if (!name) {
      return this.icons.sport_bronze; // Icono predeterminado si name es undefined
    }

    switch (name) {
      case 'P.E. Profesor Bronce':
        return this.icons.teacher_bronze;
      case 'P.E. Profesor Plata':
        return this.icons.teacher_silver;
      case 'P.E. Profesor Oro':
        return this.icons.teacher_gold;
      default:
        return this.icons.teacher_bronze; // Icono predeterminado para nombres desconocidos
    }
  }

}

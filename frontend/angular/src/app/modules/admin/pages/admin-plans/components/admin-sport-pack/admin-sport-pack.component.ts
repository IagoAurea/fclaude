import { Component, OnDestroy, OnInit } from '@angular/core';
import { Subscription } from 'rxjs';
import { MatDialog } from '@angular/material/dialog';
import { Package } from 'src/app/_models/package';
import { ProfieService } from 'src/app/modules/profile/profile-services/profie.service';
import { EditPlanModalComponent } from '../../../../components/edit-plan-modal/edit-plan-modal.component';
import { ConfirmationService, MessageService } from 'primeng/api';
import { PlanService } from 'src/app/modules/admin/services/plan-service/plan.service';
// import { EditPlanModalComponent } from '../edit-plan-modal/edit-plan-modal.component';
import Swal from 'sweetalert2';
import { TranslateService } from '@ngx-translate/core';
import { PackageStateService } from 'src/app/modules/admin/services/plan-service/packageState.service';

@Component({
  selector: 'app-admin-sport-pack',
  templateUrl: './admin-sport-pack.component.html',
  styleUrls: ['./admin-sport-pack.component.scss']
})
export class AdminSportPackComponent implements OnInit, OnDestroy {
  p: number = 1;
  itemsPerPage = 10; // Valor inicial
  public packages: Package[] = [];
  public subscription$: Subscription;
  defaultSubpackage: string;
  icons: any = {
    sport_bronze: '/assets/img/icons/sport_bronze.svg',
    sport_silver: '/assets/img/icons/sport_silver.svg',
    sport_gold: '/assets/img/icons/sport_gold.svg',
  };
  dialogVisible: boolean = false;
  subpackageData: any = {};
  isLoading: boolean = false;

  constructor(private http: ProfieService, private dialog: MatDialog, private planService: PlanService,
    private confirmationService: ConfirmationService,
    private messageService: MessageService, private packageStateService: PackageStateService, private translateService: TranslateService) {}

  ngOnInit(): void {
    this.packageStateService.currentPackages.subscribe(packages => {
      this.packages = packages;
    
      this.getSubscriptionPackages(); 
    });


    this.getSubscriptionPackages();
    this.defaultSubpackage = 'codigo-de-subpaquete-por-defecto';

  }

  showDialog(subpackage: any) {
    // console.log('subpackage >>>>>', subpackage);
    
    this.dialogVisible = true;
    this.subpackageData = subpackage
    console.log("Subpaketes Data: ",this.subpackageData)
    console.log('dialogVisible >>>>>', this.dialogVisible);
  }


  deleteSubpackage(id: number | undefined): void {
    if (id === undefined) {
      console.error('El id del subpaquete no está definido.');
      return;
    }

    // Traducciones dinámicas
    const confirmMessage = this.translateService.instant('adminPlans.CONFIRM_DELETE_SUBPACKAGE');
    const confirmButtonText = this.translateService.instant('adminPlans.CONFIRM');
    const cancelButtonText = this.translateService.instant('adminPlans.CANCEL');
    const successTitle = this.translateService.instant('adminPlans.SUCCESS');
    const successMessage = this.translateService.instant('adminPlans.DELETE_SUCCESS');
    const errorTitle = this.translateService.instant('adminPlans.ERROR');
    const errorMessage = this.translateService.instant('adminPlans.DELETE_ERROR');

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
    /* if (event) {
      this.cargarJugadores();
    } */
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
      case 'Deporte Bronce':
        return this.icons.sport_bronze;
      case 'Deporte Plata':
        return this.icons.sport_silver;
      case 'Deporte Oro':
        return this.icons.sport_gold;
      default:
        return this.icons.sport_bronze; // Icono predeterminado para nombres desconocidos
    }
  }


}

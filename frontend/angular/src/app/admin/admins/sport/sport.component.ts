import { Component, OnDestroy, OnInit } from '@angular/core';
import { Subscription } from 'rxjs';
import { MatDialog } from '@angular/material/dialog';
import { Package } from 'src/app/_models/package';
import { ProfieService } from 'src/app/modules/profile/profile-services/profie.service';
import { EditPlanModalComponent } from '../edit-plan-modal/edit-plan-modal.component';
 // Asegúrate de importar tu componente modal

@Component({
  selector: 'app-sport',
  templateUrl: './sport.component.html',
  styleUrls: ['./sport.component.scss']
})
export class SportComponent implements OnInit, OnDestroy {
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
  constructor(private http: ProfieService, private dialog: MatDialog) {}

  ngOnInit(): void {

    this.getSubscriptionPackages();
    this.defaultSubpackage = 'codigo-de-subpaquete-por-defecto';

  }

  openEditModal(subpackage: any) {
    const dialogRef = this.dialog.open(EditPlanModalComponent, {
      width: '250px',
      panelClass: 'mi-modal',
      data: { selectedPackage: subpackage }
    });

    dialogRef.afterClosed().subscribe(result => {
      console.log('El modal de edición de plan se cerró');
      // Aquí puedes manejar lo que sucede después de que el modal se cierra
    });
  }

  private getSubscriptionPackages(): void {
    this.subscription$ = this.http.getPackeges().subscribe((res: any) => {
      this.packages = res.data;
      console.log(this.packages);//aqui obtengo todos los paquetes y arriba los paso al modal
    });
  }

  ngOnDestroy(): void {
    if (this.subscription$) {
      this.subscription$.unsubscribe();
    }
  }
}

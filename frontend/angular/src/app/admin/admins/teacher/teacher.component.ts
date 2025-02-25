import { Component, OnDestroy, OnInit } from '@angular/core';
import { MatDialog } from '@angular/material/dialog'; // Importa MatDialog
import { Subscription } from 'rxjs';
import { Package } from 'src/app/_models/package';
import { ProfieService } from 'src/app/modules/profile/profile-services/profie.service';
import { EditPlanModalComponent } from '../edit-plan-modal/edit-plan-modal.component'; // Importa tu componente modal

@Component({
  selector: 'app-teacher',
  templateUrl: './teacher.component.html',
  styleUrls: ['./teacher.component.scss']
})
export class TeacherComponent implements OnInit, OnDestroy {
  p: number = 1;
  itemsPerPage = 10; // Valor inicial
  public packages: Package[] = [];
  public subscription$: Subscription;
  defaultSubpackage: string;
  icons: any = {
    teacher_bronze: '/assets/img/icons/teacher_bronze.svg',
    teacher_silver: '/assets/img/icons/teacher_silver.svg',
    teacher_gold: '/assets/img/icons/teacher_gold.svg',
  };

  constructor(private http: ProfieService, private dialog: MatDialog) {} // Inyecta MatDialog en el constructor

  ngOnInit(): void {
    this.getSubscriptionPackages();
    this.defaultSubpackage = 'codigo-de-subpaquete-por-defecto';
  }

  // Método para abrir el modal
  openEditModal(subpackage: any) {
    const dialogRef = this.dialog.open(EditPlanModalComponent, {
      width: '250px',
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
    });
  }

  ngOnDestroy(): void {
    if (this.subscription$) {
      this.subscription$.unsubscribe();
    }
  }
}

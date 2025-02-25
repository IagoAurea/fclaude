import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { OnDestroy, OnInit } from '@angular/core';
import { MatDialog } from '@angular/material/dialog'; // Importa MatDialog

import { EditnewPlanModalComponent } from '../editnew-plan-modal/editnew-plan-modal.component';


@Component({
  selector: 'app-admins-plans',
  templateUrl: './admins-plans.component.html',
  styleUrls: ['./admins-plans.component.scss']
})
export class AdminsPlansComponent {
  items = [
    {
      label: 'Sport',
      routerLink: ['sport'], // actualiza esto con la ruta correcta
      icon: 'assets/img/icons/sport.svg', // añade la ruta a tu icono aquí
      iconSelect: 'assets/img/icons/sportselect.svg', // añade la ruta a tu icono seleccionado aquí
    },
    {
      label: 'Teacher',
      routerLink: ['teacher'], // actualiza esto con la ruta correcta
      icon: 'assets/img/icons/sport.svg', // añade la ruta a tu icono aquí
      iconSelect: 'assets/img/icons/sportselect.svg', // añade la ruta a tu icono seleccionado aquí
    },
  ];
  activeItem: any = null;

  constructor(private router: Router,private dialog: MatDialog) {
    // Establece 'Sport' como el elemento activo por defecto

  }
  otherComponentVisible = false;

  showOtherComponent() {
    // ...
    this.otherComponentVisible = true;
  }
  opennewEditModal() {
    const dialogRef = this.dialog.open(EditnewPlanModalComponent, {


      panelClass: 'mi-modal',
      data: { }
    });

    dialogRef.afterClosed().subscribe(result => {
      console.log('El modal de edición de plan se cerró');
      // Aquí puedes manejar lo que sucede después de que el modal se cierra
    });
  }


  handleTab(tab: any) {
    // implementa la lógica para manejar el cambio de pestaña aquí...
    // por ejemplo, podrías querer actualizar activeItem aquí...
    this.activeItem = tab;
    return tab;
  }

  getIcon(item: any) {
    if (this.activeItem === item) {
      return item.iconSelect;
    } else {
      return item.icon;
    }
  }

}

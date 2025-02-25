import { Component, Inject, OnInit } from '@angular/core';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import { PlanService } from '../../services/plan.service';

@Component({
  selector: 'app-edit-plan-modal',
  templateUrl: './edit-plan-modal.component.html',
  styleUrls: ['./edit-plan-modal.component.scss']
})
export class EditPlanModalComponent  implements OnInit {

  detailSubcription: boolean = false;
  tempQuantity: any = {};
  editFlags: any = {}; // Nueva propiedad

  constructor(
    @Inject(MAT_DIALOG_DATA) public data: any,
    public dialogRef: MatDialogRef<EditPlanModalComponent>,
    private planService: PlanService // Inyectar el servicio
  ) {}

  ngOnInit(): void {
    console.log(this.data.selectedPackage); // Aquí puedes ver los datos pasados
    this.data.view = true;
    for (let dato of this.data.selectedPackage.attributes) {
      if (dato.pivot.quantity) {
        this.tempQuantity[dato.id] = dato.pivot.quantity;
      } else {
        this.tempQuantity[dato.id] = dato.pivot.available; // Almacenar los estados de los checkboxes como booleanos
      }
      this.editFlags[dato.id] = false; // Inicializar el estado del checkbox
    }
  }

  close() {
    this.dialogRef.close();
  }

  onHide() {
    this.dialogRef.close();
  }
  guardar() {
    // Validar los datos
    for (let dato of this.data.selectedPackage.attributes) {
      if (dato.pivot.quantity) {
        dato.pivot.quantity = this.tempQuantity[dato.id];
      } else {
        dato.pivot.available = this.tempQuantity[dato.id]; // Los valores ya son booleanos
      }
    }

    // Enviar los datos para su actualización
    console.log('Enviar los datos para su actualización:', this.data.selectedPackage.attributes);

    // Llamar al servicio para guardar los datos
    this.planService.updatePlan(this.data.selectedPackage.attributes).subscribe(response => {
      console.log('Respuesta del servidor:', response);
    }, error => {
      console.log('Error:', error);
    });
  }
}

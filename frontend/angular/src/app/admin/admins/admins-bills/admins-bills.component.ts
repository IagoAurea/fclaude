import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { MatDialog } from '@angular/material/dialog';
import { AddInvoiceComponent } from '../add-invoice/add-invoice.component';

@Component({
  selector: 'app-admins-bills',
  templateUrl: './admins-bills.component.html',
  styleUrls: ['./admins-bills.component.scss'],
})
export class AdminsBillsComponent implements OnInit {
  p: number = 1;
  invoices: any[] = []; // Define la propiedad invoices aquí
  itemsPerPage: number = 10;
  searchTerm: string = ''; // Añade esta propiedad para la búsqueda

  isAddInvoiceModalOpen = false; // Añade esta propiedad

  constructor(private http: HttpClient, public dialog: MatDialog) { }

  ngOnInit() {
    this.http.get<any[]>('url_a_tu_backend').subscribe(data => {
      this.invoices = data; // Asigna los datos obtenidos a invoices en lugar de user
    });
  }

  generarPdf(numero_pedido: number) {
    // Implementa la lógica para generar el PDF
  }

  deletePedido(numero_pedido: number) {
    // Implementa la lógica para eliminar el pedido
  }

  openAddInvoiceModal() {
    this.isAddInvoiceModalOpen = true; // Abre el modal
    const dialogRef = this.dialog.open(AddInvoiceComponent, {
      width: '800px',
      panelClass: 'custom-modal', // Agrega la clase personalizada aquí
      data: {}, // Puedes proporcionar algún dato si es necesario
    });

    dialogRef.afterClosed().subscribe(result => {
      console.log('Modal cerrado con resultado:', result);
      this.isAddInvoiceModalOpen = false; // Cierra el modal
    });
  }

  closeAddInvoiceModal() {
    this.isAddInvoiceModalOpen = false; // Cierra el modal
  }

  close() {
    console.log('Cerrando sesión...');
  }

  // Añade este método para la búsqueda de facturas
  searchInvoices() {
    if (this.searchTerm) {
      this.invoices = this.invoices.filter(invoice =>
        invoice.numero_factura.includes(this.searchTerm) ||
        invoice.a_nombre_de.includes(this.searchTerm) ||
        invoice.monto_total.includes(this.searchTerm) ||
        invoice.fecha_creacion.includes(this.searchTerm)
      );
    } else {
      // Si el campo de búsqueda está vacío, vuelve a cargar todas las facturas
      this.ngOnInit();
    }
  }
}

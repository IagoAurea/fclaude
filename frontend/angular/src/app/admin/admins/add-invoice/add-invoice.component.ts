import { Component } from '@angular/core';
import { MatDialogRef } from '@angular/material/dialog';

interface Item {
  item: string;
  precioItem: string;
}

@Component({
  selector: 'app-add-invoice',
  templateUrl: './add-invoice.component.html',
  styleUrls: ['./add-invoice.component.scss']
})
export class AddInvoiceComponent {
  items: Item[] = [{ item: '', precioItem: '' }, { item: '', precioItem: '' }];

  newUser = {
    nombreFactura: '',
    item: '',
    precioItem: '',
    direccion: '',
    pais: ''
  };

  constructor(public dialogRef: MatDialogRef<AddInvoiceComponent>) {}

  close() {
    this.dialogRef.close();
  }

  saveUser() {

    this.items.push({ item: this.newUser.item, precioItem: this.newUser.precioItem });

    this.newUser = {
      nombreFactura: '',
      item: '',
      precioItem: '',
      direccion: '',
      pais: ''
    };
  }

  agregarFila() {

    this.items.push({ item: '', precioItem: '' });
  }
}

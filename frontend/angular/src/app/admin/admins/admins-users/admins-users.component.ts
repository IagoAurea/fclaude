import { HttpClient } from '@angular/common/http';
import { Component, OnInit } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { AddUserComponent } from '../add-user/add-user.component';
import { SelectPlansComponent } from '../select-plans/select-plans.component';
import { PublicDataService } from 'src/app/admin/services/public-data.service';
import { EditnewPlanModalComponent } from '../editnew-plan-modal/editnew-plan-modal.component';

@Component({
  selector: 'app-admins-users',
  templateUrl: './admins-users.component.html',
  styleUrls: ['./admins-users.component.scss']
})
export class AdminsUsersComponent implements OnInit {
  itemsPerPage: number = 10;
  p: number = 1;
  user: any[] = [];
  isAddUserModalOpen = false;
  hideProfileButton = false;
  private firstModalData: any; // Variable para almacenar los datos del primer modal

  constructor(private http: HttpClient, public dialog: MatDialog, private publicDataService: PublicDataService) {}

  ngOnInit() {
    this.http.get<any[]>('url_a_tu_backend').subscribe(data => {
      this.user = data; //conseguire los datos de todos los usuarios mas alante
    });

    // Obtiene los datos de country, gender, y genderIdentity
  }

  openEditProfileDialog() {
    console.log('openEditProfileDialog');

    const dialogRef = this.dialog.open(AddUserComponent, {

      panelClass: 'custom-modal',
      data: {},
    });

    dialogRef.componentInstance.openNewModal.subscribe((data) => {
      this.firstModalData = data; // Guarda los datos del primer modal
    });

    dialogRef.componentInstance.openSecondModal.subscribe(() => {
      dialogRef.close(); // Cierra el primer modal
      this.openSelectPlansDialog(); // Abre el segundo modal
    });

    dialogRef.afterClosed().subscribe(result => {
      console.log('Modal cerrado con resultado:', result);
    });
  }

  openSelectPlansDialog() {
    const dialogRef = this.dialog.open(EditnewPlanModalComponent, {

      panelClass: 'custom-modal',
      data: {
        openedByAdminsUsersComponent: true,
        firstModalData: this.firstModalData // Pasamos los datos del primer modal
      },
    });


  }
}

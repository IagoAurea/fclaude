import { Component, OnInit } from '@angular/core';
import { PermissionsResponse, UserService } from '../../services/user-service/user.service';  // Importamos el servicio
import { User } from '../../../../_models/user';
import { UserSelectionService } from '../../services/user-service/user-selection.service';
import Swal from 'sweetalert2';
import { TranslateService } from '@ngx-translate/core';

@Component({
  selector: 'app-admin-users',
  templateUrl: './admin-users.component.html',
  styleUrls: ['./admin-users.component.scss']
})
export class AdminUsersComponent implements OnInit {
  searchText: string = '';
  filteredUsers: any[] = [];
  selectedUsers: any[] = [];  // Usuarios seleccionados para asignar permisos
  feedbackMessage: { text: string; type: 'success' | 'error' | 'warning' | 'info' | '' } = { text: '', type: '' };
  isLoading: boolean = false;


  permissions: PermissionsResponse = { success: false, message: '', data: [] };
  // Estado de si "Todos los permisos" está seleccionado
  allPermissionsSelected: boolean = false;


  // Mapeo de types a claves de traducción
  categoryTranslationKeys: { [key: string]: string } = {
    club: 'adminUsers.CLUB',
    team: 'adminUsers.TEAM',
    competition: 'adminUsers.COMPETITION',
    competition_match: 'adminUsers.COMPETITION_MATCH',
    scouting: 'adminUsers.SCOUTING',
    player: 'adminUsers.PLAYER',
    exercise: 'adminUsers.EXERCISE',
    session_exercise: 'adminUsers.SESSION_EXERCISE',
    test: 'adminUsers.TEST',
    injury_prevention: 'adminUsers.INJURY_PREVENTION',
    injury_rfd: 'adminUsers.INJURY_RFD',
    fisiotherapy: 'adminUsers.FISIOTHERAPY',
    effort_recovery: 'adminUsers.EFFORT_RECOVERY',
    nutrition: 'adminUsers.NUTRITION',
    psychology: 'adminUsers.PSYCHOLOGY',
  };

  // Mapeo de sufijos a claves de traducción
  permissionSuffixTranslationKeys: { [key: string]: string } = {
    list: 'adminUsers.LIST',
    store: 'adminUsers.CREATE',
    read: 'adminUsers.READ',
    update: 'adminUsers.UPDATE',
    delete: 'adminUsers.DELETE',
  };


  // Objeto que almacena el estado de apertura de cada fila
  isOpen: { [key: string]: boolean } = {
    'competition': false,
    'partidos': false,
    'scouting': false,
    'diseño': false,
    'jugadores': false,
    'test': false,
    'fichas': false,
    'riesgo': false,
    'rdf': false,
  };

  ngOnInit(): void {
    this.fetchPermissions();
    // Agregar el estado 'expanded' para cada tipo
    this.permissions.data.forEach((category: any) => {
      category.expanded = false;
    });
    console.log("expanded", this.permissions)
  }

  constructor(private userService: UserService, private translateService: TranslateService, private userSelectionService: UserSelectionService) {
    // Suscribirse a los usuarios seleccionados desde el servicio
    this.userSelectionService.selectedUsers$.subscribe(users => {
      this.selectedUsers = users;
    });
  }
  showAlert(icon: 'success' | 'error' | 'warning' | 'info', titleKey: string, textKey: string): void {
    const title = this.translateService.instant(`adminUsers.${titleKey}`, { defaultValue: titleKey });
    const text = this.translateService.instant(`adminUsers.${textKey}`, { defaultValue: textKey });
    const buttonText = this.translateService.instant('adminUsers.ButtonOK');  // Traducción del botón

    Swal.fire({
      title: title,  // Título de la alerta
      text: text,    // Texto de la alerta
      icon: icon,
      timer: 3000,
      toast: true,
      position: 'top-end',
      showConfirmButton: false, // Usa el botón traducido
    });
  }



  getPermissionTranslationKey(permissionName: string): string {
    const suffix = permissionName.split('_').pop(); // Extrae el sufijo después del último '_'

    // Verifica que suffix no sea undefined y que esté en permissionSuffixTranslationKeys
    if (suffix && this.permissionSuffixTranslationKeys[suffix]) {
      return this.permissionSuffixTranslationKeys[suffix];
    }

    return 'adminUsers.UNKNOWN'; // Valor por defecto si no se encuentra el sufijo
  }


  
  fetchPermissions(): void {
    
    this.userService.getPermissions().subscribe({
      next: (response) => {
        if (response.success) {
          this.permissions = response;
          console.log("Permisos: ",this.permissions)
        } else {
          console.log('Error al obtener los permisos');
          
        }
      },
      error: (error) => {
        console.log('Error al obtener los permisos');
      }
    });
  }
  
  toggleCategoryExpansion(category: any): void {
    category.expanded = !category.expanded; // Alternar estado de expansión
  }

  // Método para alternar el estado de visibilidad de las filas
  toggleRow(row: string): void {
    this.isOpen[row] = !this.isOpen[row];  // Cambia el estado de la fila
  }

  // Método para evitar la propagación del evento en los checkboxes
  preventClickPropagation(event: Event): void {
    event.stopPropagation();
  }

  toggleAllPermissions(): void {
    // Aquí puedes manejar el cambio de todos los permisos
    this.permissions.data.forEach(category => {
      category.permissions.forEach(permission => {
      permission.selected = !this.allPermissionsSelected; // Marcar todos los permisos
      });
    });
  }

  resetPermissionsSelection(): void {
    this.permissions.data.forEach(category => {
      category.permissions.forEach(permission => {
        permission.selected = false; // Desactiva el checkbox
      });
    });

    this.allPermissionsSelected = false; // Desactiva el checkbox de "Seleccionar todos", si lo tienes
  }

  
  grantPermissions(): void {
    if (this.selectedUsers.length > 0) {
      this.isLoading = true; // Activar el estado de carga
      
      const userIds: number[] = this.selectedUsers.map(user => Number(user.id)); // Convertimos los IDs a números
      // Construimos el array de permisos agrupados por tipo
      const permissions = this.permissions.data.map(category => ({
        type: category.type, // Reemplaza 'type' con el nombre correcto de la propiedad de tipo
        permissions: category.permissions
          .filter(permission => permission.selected) // Filtramos los permisos seleccionados
          .map(permission => permission.name) // Reemplaza 'name' con la propiedad correcta del permiso
      })).filter(permissionGroup => permissionGroup.permissions.length > 0); // Eliminamos grupos sin permisos seleccionados

      // Validamos que haya permisos seleccionados
      if (permissions.length === 0) {
        this.showAlert('warning', 'LBL_NO_PERMISSIONS_SELECTED_TITLE', 'LBL_NO_PERMISSIONS_SELECTED_TEXT');
        this.isLoading = false; // Desactivar el estado de carga
        return;
        
      }

      console.log("Usuarios seleccionados:", userIds);
      console.log("Permisos seleccionados:", permissions);

      this.userService.grantPermissions(userIds, permissions).subscribe(
        (response) => {
          this.showAlert('success', 'PermissionsGranted_TITLE', 'PermissionsGranted_TEXT');
          this.resetPermissionsSelection();
          console.log("respuesta >", response)
          this.isLoading = false; // Desactivar el estado de carga

        },
        () => {
          this.isLoading = false; // Desactivar el estado de carga
          this.showAlert('error', 'LBL_ERROR_ASSIGNING_PERMISSIONS_TITLE', 'LBL_ERROR_ASSIGNING_PERMISSIONS_TEXT');
        }
        
      );
    } else {
  this.showAlert('warning', 'NO_SELECTED_USERS_TITLE', 'NO_SELECTED_USERS_TEXT');
    }
  }
}

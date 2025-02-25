import { Component } from '@angular/core';
import { UserService } from '../../../../services/user-service/user.service';
import { debounceTime, switchMap, distinctUntilChanged } from 'rxjs/operators';
import { Subject } from 'rxjs';
import { UserSelectionService } from 'src/app/modules/admin/services/user-service/user-selection.service';

@Component({
  selector: 'app-user-search',
  templateUrl: './user-search.component.html',
  styleUrls: ['./user-search.component.scss']
})
export class UserSearchComponent {

  searchText: string = '';
  filteredUsers: any[] = [];
  selectedUsers: any[] = [];
  private searchSubject = new Subject<string>();
  isLoading: boolean = false;

  // Variables de paginación
  currentPage: number = 1;
  totalPages: number = 1;
  nextPageUrl: string | null = null;
  maxVisibleUsers: number = 50;

  constructor(private userService: UserService, private userSelectionService: UserSelectionService) {
    // Suscribirse a los usuarios seleccionados
    this.userSelectionService.selectedUsers$.subscribe(users => {
      this.selectedUsers = users;
    });
  }

  ngOnInit(): void {
    this.searchSubject.pipe(
      debounceTime(500),
      distinctUntilChanged(),
      switchMap(searchTerm => {
        this.filteredUsers = [];
        if (searchTerm.trim().length === 0) return [];
        this.currentPage = 1; // Reiniciar la página al realizar una nueva búsqueda
        return this.userService.searchUsers(searchTerm, this.currentPage);
      })
    ).subscribe(
      (response: any) => {
        this.handleResponse(response);
      },
      (error) => {
        console.error('Error al buscar usuarios:', error);
        this.filteredUsers = [];
      }
    );
    

  }


  // Iniciar búsqueda
  searchUsers(): void {
    this.searchSubject.next(this.searchText);
  }

  loadMore(): void {
    this.maxVisibleUsers += 20; // Incrementa el límite por bloques
    if (this.nextPageUrl) {
      this.isLoading = true;
      this.userService.searchUsersByUrl(this.nextPageUrl, this.searchText).subscribe(
        (response: any) => {
          this.handleResponse(response, true);
          this.isLoading = false;
        },
        (error) => {
          console.error('Error al cargar más usuarios:', error);
          this.isLoading = false;
        }
      );
    }
  }
  // loadMore(): void {
  //   this.isLoading = true; // Muestra el indicador de carga
  //   this.userService.searchUsersByUrl(this.nextPageUrl, this.searchText).subscribe(
  //     (response: any) => {
  //       this.isLoading = false;
  //       this.handleResponse(response, true); // Agrega los nuevos usuarios
  //       this.maxVisibleUsers += 50; // Incrementa el límite visible
  //     },
  //     (error) => {
  //       console.error('Error al cargar más usuarios:', error);
  //       this.isLoading = false;
  //     }
  //   );
  // }



  handleResponse(response: any, append: boolean = false): void {
    const data = response.data;
    if (append) {
      this.filteredUsers = [...this.filteredUsers, ...data.data];
    } else {
      this.filteredUsers = data.data || [];
    }
    this.currentPage = data.current_page;
    this.totalPages = data.last_page;
    this.nextPageUrl = data.next_page_url;

    console.log('MaxVisibleUsers:', this.maxVisibleUsers);
    console.log('FilteredUsersLength:', this.filteredUsers.length);
  }

  // Seleccionar usuario
  selectUser(user: any): void {
    this.userSelectionService.addUser(user);
    this.searchText = ''; // Limpiar campo de búsqueda
    this.filteredUsers = []; // Limpiar resultados
  }



  // Deseleccionar usuario
  deselectUser(user: any): void {
    this.userSelectionService.removeUser(user);
  }

  // Verificar selección
  isSelected(user: any): boolean {
    return this.selectedUsers.some(u => u.id === user.id);
  }
}

import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';  // Usamos BehaviorSubject para emitir cambios

@Injectable({
    providedIn: 'root'  // Hacemos que el servicio sea accesible globalmente
})
export class UserSelectionService {
    // Creamos un Subject para manejar la lista de usuarios seleccionados
    private selectedUsersSource = new BehaviorSubject<any[]>([]);  // Inicializamos con un array vacío
    selectedUsers$ = this.selectedUsersSource.asObservable();  // Hacemos el Subject accesible como Observable

    // Método para actualizar la lista de usuarios seleccionados
    setSelectedUsers(users: any[]): void {
        this.selectedUsersSource.next(users);  // Emitimos el nuevo valor
    }

    // Método para añadir un usuario a la lista de seleccionados
    addUser(user: any): void {
        const currentUsers = this.selectedUsersSource.getValue();
        if (!currentUsers.some(u => u.id === user.id)) {
            currentUsers.push(user);
            this.selectedUsersSource.next(currentUsers);
        }
    }

    // Método para eliminar un usuario de la lista de seleccionados
    removeUser(user: any): void {
        const currentUsers = this.selectedUsersSource.getValue();
        const updatedUsers = currentUsers.filter(u => u.id !== user.id);
        this.selectedUsersSource.next(updatedUsers);
    }
}

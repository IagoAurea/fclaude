import { Component } from '@angular/core';
import { Router } from '@angular/router'; // Importa el servicio de enrutamiento
import { LoginService } from '../../services/login.service';

@Component({
  selector: 'app-admin-dropdown',
  templateUrl: './admin-dropdown.component.html',
  styleUrls: ['./admin-dropdown.component.scss']
})
export class AdminDropdownComponent {
  // Define las opciones del menú desplegable
  opciones = [
    { name: 'Cerrar sesión', value: 'logout' }
  ];

  // Define la opción seleccionada inicialmente
  opcion = this.opciones[0].value;

  constructor(
    private loginService: LoginService, // Inyecta tu servicio de autenticación
    private router: Router // Inyecta el servicio de enrutamiento
  ) {}

  // Esta función se llamará cuando se seleccione una opción
  cambiar(value: any) {
    if (value === 'logout') {
      // Borra la información de la sesión del almacenamiento local
      localStorage.clear();

      // Cierra la sesión
      // Aquí puedes llamar a cualquier método de tu servicio de autenticación que maneje el cierre de sesión
      // Por ejemplo, si tu servicio tiene un método logout, puedes llamarlo así:
      // this.loginService.logout();

      // Redirige al usuario a la página de inicio de sesión
      this.router.navigate(['/admin/login']).then(() => {
        window.location.reload();
      });
    }
  }
}

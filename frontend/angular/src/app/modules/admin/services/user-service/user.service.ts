import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment';
import { User } from '../../../../_models/user';

// Aquí creamos la interfaz de la respuesta, que contiene la propiedad "users" como un arreglo de User
// Ajustamos la interfaz de la respuesta para que coincida con la respuesta real del backend.
export interface SearchUserResponse {
  success: boolean;  // Campo de éxito
  message: string;   // Mensaje de respuesta
  data: {           // Los usuarios están dentro de 'data'
    current_page: number;
    data: User[];  // Los usuarios están en la propiedad 'data'
    total: number;
    per_page: number;
    from: number;
    to: number;
  };
}

// Interfaz para la respuesta de los permisos
export interface Permission {
  id: number;
  name: string;
  entity_code: string;
  selected?: boolean;  // Agregar la propiedad 'selected'
}

export interface PermissionsResponse {
  success: boolean;
  message: string;
  data: {
    index: number;
    type: string;
    permissions: Permission[];
    expanded?: boolean;
  }[];
}


@Injectable({
  providedIn: 'root'
})
export class UserService {
  
  public language: any = localStorage.getItem('languaje') || 'es';
  public baseUrl: string = environment.API_URL ;
  


  constructor(private http: HttpClient) { }

  grantPermissions(userIds: number[], permissions: { type: string; permissions: string[] }[]): Observable<any> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
      Authorization: 'Bearer ' + localStorage.getItem('token'),
    });

    const body = {
      userIds,       // IDs de usuarios seleccionados
      permissions,   // Permisos en el formato esperado
    };

    console.log("Body",body)

    const url = `${this.baseUrl}users/permissions/assign`;

    // Validar que el cuerpo tenga datos antes de enviar la solicitud
    if (!userIds.length || !permissions.length) {
      console.error('Error: El cuerpo de la solicitud está incompleto.');
      throw new Error('El cuerpo de la solicitud no tiene usuarios o permisos válidos.');
    }

    return this.http.post(url + `?_locale=${this.language}`, body, { headers });
  }



  // Buscar usuarios con soporte para paginación
  searchUsers(query: string, page: number = 1): Observable<any> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
      Authorization: 'Bearer ' + localStorage.getItem('token'),
    });

    const url = `${this.baseUrl}users/search`;

    return this.http.get<any>(`${url}?query=${query}&page=${page}&_locale=${this.language}`, { headers });
  }

  searchUsersByUrl(url: string, query: string): Observable<any> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
      Authorization: 'Bearer ' + localStorage.getItem('token'),
    });

    // Añadir el query manualmente si no está en la URL
    const separator = url.includes('?') ? '&' : '?';
    const fullUrl = `${url}${separator}query=${query}&_locale=${this.language}`;

    return this.http.get<any>(fullUrl, { headers });
  }

  getUsers(): Observable<any> {
    const url = `${this.baseUrl}users/list`;
    return this.http.get<any>(url);
  }
  // Método para obtener la lista de permisos
  getPermissions(): Observable<PermissionsResponse> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
      Authorization: 'Bearer ' + localStorage.getItem('token'),
    });

    const url = `${this.baseUrl}users/permissions/list`;

    return this.http.get<PermissionsResponse>(`${url}?_locale=${this.language}`, { headers });
  }

}

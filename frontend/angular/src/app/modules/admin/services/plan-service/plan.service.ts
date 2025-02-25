import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class PlanService {
  private apiUrl = environment.API_URL;
  public urlcreate: string = environment.API_URL + 'poner aqui=';
  public urlupdate: string = environment.API_URL + '';
  public language: any = localStorage.getItem('languaje') || 'es';
  private urlSubpackage = environment.API_URL + 'subpackages';

  constructor(private http: HttpClient) { }




  createPlan(planData: any): Observable<any> {

    console.log('Enviando planData:', JSON.stringify(planData, null, 2));
   const headers = {
     'Content-Type': 'application/json',
     Authorization: 'Bearer ' + localStorage.getItem('token'),
    };
    const url = `http://localhost:8083/api/v1/subpackages/store-subpackage`;
    return this.http.post(url + `?_locale=${this.language}`, planData, { headers });
  }

  updatePlan(planData: any): Observable<any> {
    const headers = {
      'Content-Type': 'application/json',
      Authorization: 'Bearer ' + localStorage.getItem('token'),
    };
    return this.http.put(this.urlupdate + `?_locale=${this.language}`, planData, { headers });
  }

  createuserPlan(planData: any): Observable<any> {
    const headers = {
      'Content-Type': 'application/json',
      Authorization: 'Bearer ' + localStorage.getItem('token'),
    };
    return this.http.post(this.urlcreate + `?_locale=${this.language}`, planData, { headers });
  }

  getSubPackages(): Observable<any> {
    const headers = {
      'Content-Type': 'application/json',
      Authorization: 'Bearer ' + localStorage.getItem('token'),
    };
    const url = 'http://localhost:8083/api/v1/packages/subpackages';
    return this.http.get(url + `?_locale=${this.language}`, { headers });
  }

  deleteSubpackage(id: number): Observable<void> {
    const url = `${this.urlSubpackage}/${id}?_locale=${this.language}`; // O usar el valor dinámico del locale
    console.log('Enviando DELETE a:', url);
    return this.http.delete<void>(url);
  }



  updateSubpackage(
    subpackageId: number,
    subpackageData: any,
  ): Observable<any> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
      Authorization: 'Bearer ' + localStorage.getItem('token'),
    });

    const url = `${this.urlSubpackage}/update-subpackage/${subpackageId}?_locale=${this.language}`;

    return this.http.put(url, subpackageData, { headers });
  }
}
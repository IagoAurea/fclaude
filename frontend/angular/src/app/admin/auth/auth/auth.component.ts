import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { LoginService } from '../../services/login.service';


@Component({
  selector: 'app-auth',
  templateUrl: './auth.component.html',
  styleUrls: ['./auth.component.css']
})
export class AuthComponent {

  formulario: FormGroup;
  formSubmitted = false;

  constructor(private loginService: LoginService , private router: Router) {
    this.formulario = new FormGroup({
      email: new FormControl('', [
        Validators.required,
        Validators.maxLength(30),
      ]),
      password: new FormControl('', [
        Validators.required,
        Validators.pattern(/^[a-zA-Z0-9.]+$/),
        Validators.maxLength(15),
      ]),
    });
  }

  onSubmit() {
    const { email, password } = this.formulario.value; // Cambia 'username' a 'email'
    console.log('email:', email); // Cambia 'username' a 'email'
    console.log('password:', password);
    if (!email || !password) { // Cambia 'username' a 'email'
      console.error('Error: El correo electrónico/nombre de usuario y la contraseña son obligatorios');
      return;
    }
    if (this.formulario.valid) {
      this.loginService.login({ login: email, password }).subscribe( // Cambia 'username' a 'login'
        (response: any) => {
          console.log(response);
          localStorage.setItem('token', response.token);
          this.formSubmitted = true;
          this.router.navigateByUrl('admin/dashboard/bills');
        },
        (error: any) => {
          console.error('Error: ', error);
        }
      );
    } else {
      console.error('Error: El formulario no es válido');
    }

    this.formSubmitted = true;
  }

  showError(controlName: string, errorType: string): boolean {
    const control = this.formulario.get(controlName);
    return !!control?.hasError(errorType) && !!control?.touched;
  }
}

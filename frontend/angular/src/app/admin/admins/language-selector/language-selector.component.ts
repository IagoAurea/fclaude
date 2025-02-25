import { Component, OnInit } from '@angular/core';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-language-selector',
  templateUrl: './language-selector.component.html',
  styleUrls: ['./language-selector.component.scss']
})
export class LanguageSelectorComponent implements OnInit {
  urlBase = environment.images;
  idioma: string = 'es';
  languages = [
    { name: 'English', value: 'en' },
    { name: 'Español', value: 'es' }
  ];
  englishFlag: string = `${this.urlBase}/images/icons/flag_u_kingdom.svg`;
  spanishFlag: string = `${this.urlBase}/images/icons/flag_spain.svg`;

  constructor() { }

  ngOnInit(): void {
    this.idioma = localStorage.getItem('languaje') || 'es';
    localStorage.setItem('languaje', this.idioma);
  }

  cambiar(language: any) {
    localStorage.setItem('languaje', language.value);
    this.idioma = language.value;
    window.location.reload();
  }
}

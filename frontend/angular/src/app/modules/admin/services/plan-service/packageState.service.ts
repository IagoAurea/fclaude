import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';

@Injectable({
    providedIn: 'root'
})
export class PackageStateService {
    private packagesSource = new BehaviorSubject<any[]>([]);
    currentPackages = this.packagesSource.asObservable();

    // Método para actualizar paquetes
    updatePackages(newPackages: any[]) {
        this.packagesSource.next(newPackages);
    }

    // Método para notificar que se debe refrescar
    refreshPackages() {
        this.packagesSource.next(this.packagesSource.value); // Emitir el mismo valor para notificar a los suscriptores
    }
}

import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AdminsBillsComponent } from './admins-bills/admins-bills.component';
import { AdminsPlansComponent } from './admins-plans/admins-plans.component';
import { AdminsUsersComponent } from './admins-users/admins-users.component';
import { SportComponent } from './sport/sport.component';
import { TeacherComponent } from './teacher/teacher.component';


const routes: Routes = [
  {
    path: '',
    children: [
      { path: '', redirectTo: 'bills', pathMatch: 'full' }, // Redirigir a 'bills' por defecto
      { path: 'bills', component: AdminsBillsComponent },
      { path: 'users', component: AdminsUsersComponent },
      {
        path: 'plans',
        component: AdminsPlansComponent,
        children: [
          { path: 'sport', component: SportComponent },
          { path: 'teacher', component: TeacherComponent },
        ]
      },
    ],
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class AdminsRoutingModule {}

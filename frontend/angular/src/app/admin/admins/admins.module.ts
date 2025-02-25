import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { AdminsUsersComponent } from './admins-users/admins-users.component';
import { AdminsPlansComponent } from './admins-plans/admins-plans.component';
import { AdminsBillsComponent } from './admins-bills/admins-bills.component';
import { AdminsRoutingModule } from './admins-routing.module';
import { AddUserComponent } from './add-user/add-user.component';
import { MatDialogModule } from '@angular/material/dialog';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';  // Asegúrate de importar FormsModule
import { MatDialogRef } from '@angular/material/dialog';
import { AddInvoiceComponent } from './add-invoice/add-invoice.component';
import { CheckboxModule } from 'primeng/checkbox'; // Importa CheckboxModule de PrimeNG
import { TooltipModule } from 'primeng/tooltip'; // Importa TooltipModule de PrimeNG
import { TranslateModule } from '@ngx-translate/core'; // Importa TranslateModule de @ngx-translate/core
import { DropdownModule } from 'primeng/dropdown'; // Importa DropdownModule de PrimeNG
import { DialogModule } from 'primeng/dialog'; // Importa DialogModule de PrimeNG
import { ScrollPanelModule } from 'primeng/scrollpanel';
import { SelectPlansComponent } from './select-plans/select-plans.component';
import { SubpackegeDetailComponent } from 'src/app/modules/profile/components/subpackege-detail/subpackege-detail.component';
import { DowngradePlanDialogComponent } from 'src/app/modules/profile/components/downgrade-plan-dialog/downgrade-plan-dialog.component';
import { ConfirmUpdateSubscriptionComponent } from 'src/app/modules/profile/components/confirm-update-subscription/confirm-update-subscription.component';
import { DowngradePlanTeacherDialogComponent } from 'src/app/modules/profile/components/downgrade-plan-teacher-dialog/downgrade-plan-teacher-dialog.component';
import { TabMenuModule } from 'primeng/tabmenu';
import { SportComponent } from './sport/sport.component';
import { TeacherComponent } from './teacher/teacher.component';
import { LanguageSelectorComponent } from './language-selector/language-selector.component';
import { EditPlanModalComponent } from './edit-plan-modal/edit-plan-modal.component';
import { AdminDropdownComponent } from './admin-dropdown/admin-dropdown.component';
import { EditnewPlanModalComponent } from './editnew-plan-modal/editnew-plan-modal.component';
import { SharedComponentsModule } from "../../sharedComponents/shared-components.module";
import { ComponentsModule } from "../../modules/components/components.module";
import {NgxPaginationModule} from 'ngx-pagination';







@NgModule({
    declarations: [
        AdminsUsersComponent,
        AdminsPlansComponent,
        AdminsBillsComponent,
        AddUserComponent,
        AddInvoiceComponent,
        SportComponent,
        TeacherComponent,
        LanguageSelectorComponent,
        EditPlanModalComponent,
        AdminDropdownComponent,
        EditnewPlanModalComponent,
    ],
    imports: [
        CommonModule,
        AdminsRoutingModule,
        MatDialogModule,
        FormsModule,
        CheckboxModule, // Añade CheckboxModule a la lista de imports
        TooltipModule, // Añade TooltipModule a la lista de imports
        TranslateModule, // Añade TranslateModule a la lista de imports
        DropdownModule,
        DialogModule,
        ScrollPanelModule,
        ReactiveFormsModule,
        TabMenuModule,
        SharedComponentsModule,
        ComponentsModule,
        NgxPaginationModule

    ]
})
export class AdminsModule { }

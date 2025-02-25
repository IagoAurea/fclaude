import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { AdminComponent } from './admin.component'
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { TranslateModule } from '@ngx-translate/core';
import {MatInputModule} from '@angular/material/input';
import { MatSidenavModule } from '@angular/material/sidenav';
import { AdminRoutingModule } from './Adminrouting.module';
import { AuthModule } from './auth/auth.module';
import { PagesModule } from './pages/pages.module';
import { ConfirmUpdateSubscriptionComponent } from '../modules/profile/components/confirm-update-subscription/confirm-update-subscription.component';
import { DowngradePlanDialogComponent } from '../modules/profile/components/downgrade-plan-dialog/downgrade-plan-dialog.component';



@NgModule({
  declarations: [
    AdminComponent,

  ],
  imports: [
    CommonModule,
    PagesModule,
    FormsModule,
    ReactiveFormsModule,
    HttpClientModule,
    TranslateModule,



    MatInputModule,
    MatSidenavModule,
    AdminRoutingModule,
    AuthModule,

  ],
  providers: [],
})
export class AdminModule { }

import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AdminsUsersComponent } from './admins-users.component';

describe('AdminsUsersComponent', () => {
  let component: AdminsUsersComponent;
  let fixture: ComponentFixture<AdminsUsersComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [AdminsUsersComponent]
    });
    fixture = TestBed.createComponent(AdminsUsersComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

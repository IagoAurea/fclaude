import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AdminsPlansComponent } from './admins-plans.component';

describe('AdminsPlansComponent', () => {
  let component: AdminsPlansComponent;
  let fixture: ComponentFixture<AdminsPlansComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [AdminsPlansComponent]
    });
    fixture = TestBed.createComponent(AdminsPlansComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

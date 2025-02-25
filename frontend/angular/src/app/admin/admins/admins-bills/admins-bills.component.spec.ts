import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AdminsBillsComponent } from './admins-bills.component';

describe('AdminsBillsComponent', () => {
  let component: AdminsBillsComponent;
  let fixture: ComponentFixture<AdminsBillsComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [AdminsBillsComponent]
    });
    fixture = TestBed.createComponent(AdminsBillsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

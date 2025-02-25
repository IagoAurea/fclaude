import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EditnewPlanModalComponent } from './editnew-plan-modal.component';

describe('EditnewPlanModalComponent', () => {
  let component: EditnewPlanModalComponent;
  let fixture: ComponentFixture<EditnewPlanModalComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [EditnewPlanModalComponent]
    });
    fixture = TestBed.createComponent(EditnewPlanModalComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

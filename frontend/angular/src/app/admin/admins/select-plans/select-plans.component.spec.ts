import { ComponentFixture, TestBed } from '@angular/core/testing';

import { SelectPlansComponent } from './select-plans.component';

describe('SelectPlansComponent', () => {
  let component: SelectPlansComponent;
  let fixture: ComponentFixture<SelectPlansComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [SelectPlansComponent]
    });
    fixture = TestBed.createComponent(SelectPlansComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

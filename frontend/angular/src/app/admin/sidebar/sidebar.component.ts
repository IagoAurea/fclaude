import { BreakpointObserver } from '@angular/cdk/layout';
import { Component, OnInit, ViewChild } from '@angular/core';
import { Observable } from 'rxjs';
import { map, shareReplay } from 'rxjs/operators';
import { MatDrawer } from '@angular/material/sidenav';

@Component({
  selector: 'app-sidebar',
  templateUrl: './sidebar.component.html',
  styleUrls: ['./sidebar.component.css']
})
export class SidebarComponent implements OnInit {
  isHandset$: Observable<boolean> = this.breakpointObserver.observe('(max-width: 913px)')
    .pipe(
      map(result => result.matches),
      shareReplay()
    );

  @ViewChild('drawer') drawer: MatDrawer;

  constructor(private breakpointObserver: BreakpointObserver) { }

  ngOnInit(): void {
  }
}

import { NgModule } from '@angular/core';
import { IonicPageModule } from 'ionic-angular';
import { HomeSubscriberPage } from './home-subscriber';
import { MomentModule } from "angular2-moment";
import 'moment/locale/pt-br';

@NgModule({
  declarations: [
    HomeSubscriberPage,
  ],
  imports: [
    MomentModule,
    IonicPageModule.forChild(HomeSubscriberPage),
  ],
  exports: [
    HomeSubscriberPage
  ],
})
export class HomeSubscriberPageModule {}

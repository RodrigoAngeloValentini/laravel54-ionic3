import { Component } from '@angular/core';
import {IonicPage, LoadingController, NavController, NavParams} from 'ionic-angular';
import { PlanResource } from "../../providers/resources/plan.resource";
import { Observable } from "rxjs/Observable";

@IonicPage()
@Component({
  selector: 'page-plans',
  templateUrl: 'plans.html',
})
export class PlansPage {

  plans:Observable<Array<Object>>;
  constructor(public navCtrl: NavController, public navParams: NavParams, public planResource: PlanResource, public loadingCtrl: LoadingController) {
  }

  ionViewDidLoad() {
    let loading = this.loadingCtrl.create({
      spinner : 'hide',
      content: 'Carregando...'
    });
    loading.present();
    this.plans = this.planResource.all().map(plans => {
      loading.dismiss();
      return plans;
    });
  }

}

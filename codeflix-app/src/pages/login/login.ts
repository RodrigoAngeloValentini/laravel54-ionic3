import { Component } from '@angular/core';
import {IonicPage, MenuController, NavController, NavParams, ToastController} from 'ionic-angular';
import 'rxjs/add/operator/toPromise';
import {Auth} from "../../providers/auth/auth";
import {HomePage} from "../home/home";
import {HomeSubscriberPage} from "../home-subscriber/home-subscriber";
import {AuthOffline} from "../../providers/auth/auth-offline";

@IonicPage()
@Component({
  selector: 'page-login',
  templateUrl: 'login.html',
})
export class LoginPage {

  user = {
      email: "admin@user.com",
      password: "secret"
  };

  constructor(public navCtrl: NavController, public menuCtrl: MenuController, public navParams: NavParams, private auth: Auth, private authOffline: AuthOffline, public toastCtrl: ToastController) {
      this.menuCtrl.enable(false);
  }

  ionViewDidLoad() {
      console.log('ionViewDidLoad LoginPage');
  }

  login(){
      this.auth.login(this.user).then((user) => {
          this.afterLogin(user);
      }).catch(() => {
          let toast = this.toastCtrl.create({
              message: 'Email ou senha inválidos',
              duration: 3000,
              position: 'top',
              cssClass: 'toast-reverse'
          });

          toast.present();
      });
  }

  loginOffline(){
      this.authOffline.login(this.user)
          .then(user => {
              this.afterLogin(user);
          })
          .catch((error)=>{
              let toast = this.toastCtrl.create({
                  message: 'EEmail invalido',
                  duration: 3000,
                  position: 'top',
                  cssClass: 'toast-login-error'
              });

              toast.present();
          });
  }

  loginFacebook(){
      this.auth.loginFacebook()
          .then((user) => {
            this.afterLogin(user);
          })
          .catch((error)=>{
              let toast = this.toastCtrl.create({
                  message: 'Erro ao realizar login no facebook:' + error,
                  duration: 3000,
                  position: 'top',
                  cssClass: 'toast-login-error'
              });

              toast.present();
          });
  }

  afterLogin(user){
      this.menuCtrl.enable(true);
      this.navCtrl.push(user.subscription_valid ? HomeSubscriberPage : HomePage);
  }

}

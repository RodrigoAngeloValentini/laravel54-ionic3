import { Component, ViewChild } from '@angular/core';
import { Nav, Platform } from 'ionic-angular';
import { StatusBar } from '@ionic-native/status-bar';
import { SplashScreen } from '@ionic-native/splash-screen';

import { HomePage } from '../pages/home/home';
import { HomeSubscriberPage } from "../pages/home-subscriber/home-subscriber";
import { LoginPage } from "../pages/login/login";
import { Auth } from "../providers/auth/auth";
import { Redirector } from "../providers/redirector";
import md5 from 'crypto-md5';
import { DB } from "../providers/sqlite/db";
import { UserModel } from "../providers/sqlite/user-model";

@Component({
    templateUrl: 'app.html'
})
export class MyApp {
    @ViewChild(Nav) nav: Nav;

    rootPage: any = LoginPage;

    pagesSubscriber: Array<{title: string, component: any}>;
    pages: Array<{title: string, component: any}>;
    user: any;
    gravatarUrl = '';

    constructor(public platform: Platform, public statusBar: StatusBar, public splashScreen: SplashScreen, public auth:Auth, public redirector: Redirector, public db:DB, public userModel:UserModel) {

        // used for an example of ngFor and navigation
        this.pages = [
            { title: 'Home', component: HomePage },
        ];

        this.pagesSubscriber = [
            { title: 'Assine Agora', component: HomeSubscriberPage}
        ];
        this.initializeApp();

    }

    initializeApp() {
        this.auth.userSubject().subscribe(user => {
            this.user = user;
            this.gravatar();
        });
        this.platform.ready().then(() => {
            this.db.createSchema()
                .then(() => {
                    this.userModel.insert({
                        id: 1,
                        name: 'luiz carlos',
                        email: 'luiz@code.education'
                    })
                });
            // Okay, so the platform is ready and our plugins are available.
            // Here you can do any higher level native things you might need.
            this.statusBar.styleDefault();
            this.splashScreen.hide();
        });
    }

    gravatar(){
        if(this.user){
            this.gravatarUrl = `https://secure.gravatar.com/avatar/${md5(this.user.email,'hex')}.jpg`;
        }
    }

    ngAfterViewInit(){
        this.redirector.config(this.nav);
    }

    openPage(page) {
        // Reset the content nav to have just this page
        // we wouldn't want the back button to show in this scenario
        this.nav.setRoot(page.component);
    }

    logout(){
        this.auth.logout().then(() => {
            this.nav.setRoot('LoginPage');
        }).catch(() => {
            this.nav.setRoot('LoginPage');
        });
    }

    goToMySettings(){
        this.nav.setRoot('MySettingsPage')
    }


}

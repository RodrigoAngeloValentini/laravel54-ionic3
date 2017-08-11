import { BrowserModule } from '@angular/platform-browser';
import { ErrorHandler, NgModule } from '@angular/core';
import { IonicApp, IonicErrorHandler, IonicModule } from 'ionic-angular';

import { MyApp } from './app.component';
import { HomePage } from '../pages/home/home';
import { ListPage } from '../pages/list/list';
import { LoginPage } from '../pages/login/login'
import { MySettingsPage } from '../pages/my-settings/my-settings'

import { StatusBar } from '@ionic-native/status-bar';
import { SplashScreen } from '@ionic-native/splash-screen';
import { LoginPageModule } from "../pages/login/login.module";
import { MySettingsPageModule } from "../pages/my-settings/my-settings.module"
import { Http, HttpModule, XHRBackend } from "@angular/http";
import { JwtClient } from '../providers/jwt-client';
import { Storage, IonicStorageModule } from "@ionic/storage";
import { AuthConfig, AuthHttp, JwtHelper } from "angular2-jwt";
import { Auth } from '../providers/auth';
import { Env } from '../models/env';
import { DefaultXHRBackend } from '../providers/default-xhr-backend';
import { Redirector } from '../providers/redirector';
import { Facebook } from "@ionic-native/facebook";
import { UserResource } from "../providers/resources/user.resource";
import { PaymentPage } from "../pages/payment/payment";
import { PlansPage } from "../pages/plans/plans";
import { AddCpfPage } from "../pages/add-cpf/add-cpf";
import { HomeSubscriberPage } from "../pages/home-subscriber/home-subscriber";
import { PaymentPageModule } from "../pages/payment/payment.module";
import { PlansPageModule } from "../pages/plans/plans.module";
import { AddCpfPageModule } from "../pages/add-cpf/add-cpf.module";
import { HomeSubscriberPageModule } from "../pages/home-subscriber/home-subscriber.module";
import { TextMaskModule } from "angular2-text-mask";
import { PlanResource } from '../providers/resources/plan.resource';
import { PaymentResource } from '../providers/resources/payment.resource';

declare var ENV: Env;

@NgModule({
    declarations: [
        MyApp,
        HomePage,
        ListPage
    ],
    imports: [
        HttpModule,
        BrowserModule,
        TextMaskModule,
        IonicModule.forRoot(MyApp,{},{
            links: [
                {component: LoginPage, name: 'LoginPage', segment: 'login'},
                {component: HomePage, name: 'HomePage', segment: 'home'},
                {component: MySettingsPage, name: 'MySettingsPage', segment: 'my-settings'},
                {component: PaymentPage, name: 'PaymentPage', segment: 'plan/:plan/payment'},
                {component: PlansPage, name: 'PlansPage', segment: 'plans'},
                {component: AddCpfPage, name: 'AddCpfPage', segment: 'add-cpf'},
                {component: HomeSubscriberPage, name: 'HomeSubscriberPage', segment: 'subscriber/home'}
            ]
        }),
        LoginPageModule,
        MySettingsPageModule,
        PaymentPageModule,
        PlansPageModule,
        AddCpfPageModule,
        HomeSubscriberPageModule,
        IonicStorageModule.forRoot({
            driverOrder: ['localstorage']
        })
    ],
    bootstrap: [IonicApp],
    entryComponents: [
        MyApp,
        HomePage,
        ListPage
    ],
    providers: [
        StatusBar,
        SplashScreen,
        JwtClient,
        JwtHelper,
        Auth,
        Redirector,
        Facebook,
        UserResource,
        PlanResource,
        PaymentResource,
        {provide: ErrorHandler, useClass: IonicErrorHandler},
        {
            provide: AuthHttp,
            deps: [Http, Storage],
            useFactory(http, storage){
                let authConfig = new AuthConfig({
                    headerPrefix: 'Bearer',
                    noJwtError: true,
                    noClientCheck: true,
                    tokenGetter: (() => storage.get(ENV.TOKEN_NAME))
                });
                return new AuthHttp(authConfig, http)
            }
        },
        {provide: XHRBackend, useClass: DefaultXHRBackend},
    ]
})
export class AppModule {}

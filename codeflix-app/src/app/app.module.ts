import { BrowserModule } from '@angular/platform-browser';
import {APP_INITIALIZER, ErrorHandler, NgModule} from '@angular/core';
import { IonicApp, IonicErrorHandler, IonicModule } from 'ionic-angular';

import { MyApp } from './app.component';

import { Env } from '../models/env';

import { HomePage } from '../pages/home/home';
import { LoginPage } from '../pages/login/login'
import { MySettingsPage } from '../pages/my-settings/my-settings'
import { PaymentPage } from "../pages/payment/payment";
import { PlansPage } from "../pages/plans/plans";
import { AddCpfPage } from "../pages/add-cpf/add-cpf";
import { VideoPlayPage } from "../pages/video-play/video-play";
import { HomeSubscriberPage } from "../pages/home-subscriber/home-subscriber";

import { LoginPageModule } from "../pages/login/login.module";
import { MySettingsPageModule } from "../pages/my-settings/my-settings.module"
import { PaymentPageModule } from "../pages/payment/payment.module";
import { PlansPageModule } from "../pages/plans/plans.module";
import { AddCpfPageModule } from "../pages/add-cpf/add-cpf.module";
import { VideoPlayPageModule } from "../pages/video-play/video-play.module";
import { HomeSubscriberPageModule } from "../pages/home-subscriber/home-subscriber.module";

import { JwtClient } from '../providers/jwt-client';
import { PlanResource } from '../providers/resources/plan.resource';
import { PaymentResource } from '../providers/resources/payment.resource';
import { VideoResource } from "../providers/resources/video.resource";
import { UserResource } from "../providers/resources/user.resource";
import { Auth } from '../providers/auth/auth';
import { DefaultXHRBackend } from '../providers/default-xhr-backend';
import { Redirector } from '../providers/redirector';
import { DB } from "../providers/sqlite/db";
import { UserModel } from "../providers/sqlite/user-model";
import {AppConfig} from "../providers/app-config";
import {AuthFactory} from "../providers/auth/auth-factory";
import {AuthOffline} from "../providers/auth/auth-offline";

import { TextMaskModule } from "angular2-text-mask";
import { MomentModule } from "angular2-moment";
import 'moment/locale/pt-br';
import { Http, HttpModule, XHRBackend } from "@angular/http";
import { AuthConfig, AuthHttp, JwtHelper } from "angular2-jwt";

import { StatusBar } from '@ionic-native/status-bar';
import { SplashScreen } from '@ionic-native/splash-screen';
import { Storage, IonicStorageModule } from "@ionic/storage";
import { StreamingMedia } from "@ionic-native/streaming-media";
import { SQLite } from "@ionic-native/sqlite";
import { SQLitePorter } from "@ionic-native/sqlite-porter";
import { Facebook } from "@ionic-native/facebook";

declare var ENV: Env;

@NgModule({
    declarations: [
        MyApp,
        HomePage,
    ],
    imports: [
        HttpModule,
        BrowserModule,
        TextMaskModule,
        MomentModule,
        IonicModule.forRoot(MyApp,{},{
            links: [
                {component: LoginPage, name: 'LoginPage', segment: 'login'},
                {component: HomePage, name: 'HomePage', segment: 'home'},
                {component: MySettingsPage, name: 'MySettingsPage', segment: 'my-settings'},
                {component: PaymentPage, name: 'PaymentPage', segment: 'plan/:plan/payment'},
                {component: PlansPage, name: 'PlansPage', segment: 'plans'},
                {component: AddCpfPage, name: 'AddCpfPage', segment: 'add-cpf'},
                {component: HomeSubscriberPage, name: 'HomeSubscriberPage', segment: 'subscriber/home'},
                {component: VideoPlayPage, name: 'VideoPlayPage', segment: 'video/:video/play'}
            ]
        }),
        LoginPageModule,
        MySettingsPageModule,
        PaymentPageModule,
        PlansPageModule,
        AddCpfPageModule,
        HomeSubscriberPageModule,
        VideoPlayPageModule,
        IonicStorageModule.forRoot({
            driverOrder: ['localstorage']
        })
    ],
    bootstrap: [IonicApp],
    entryComponents: [
        MyApp,
        HomePage,
    ],
    providers: [
        AppConfig,
        {
            provide: APP_INITIALIZER,
            deps: [AppConfig],
            useFactory(appConfig){
                return () => appConfig.load()
            },
            multi: true
        },
        StatusBar,
        SplashScreen,
        JwtClient,
        JwtHelper,
        Auth,
        AuthOffline,
        AuthFactory,
        Redirector,
        Facebook,
        UserResource,
        PlanResource,
        PaymentResource,
        VideoResource,
        StreamingMedia,
        SQLite,
        SQLitePorter,
        DB,
        UserModel,
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

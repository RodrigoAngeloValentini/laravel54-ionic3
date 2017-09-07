import {appContainer} from "../app/app.container";
import {AuthFactory} from "../providers/auth/auth-factory"
import {Nav} from "ionic-angular";
import {LoginPage} from "../pages/login/login";
import {AuthGuard} from "../providers/auth/auth-guard";
export function Auth (){
    return (target: any) => {
        target.prototype.ionViewCanEnter = function() {

            let property = Object.keys(this).find(value => this[value] instanceof Nav);

            if(typeof property === "undefined"){
                setTimeout(()=>{
                    throw new TypeError("Auth decorator needs NavController instance.");
                });
                return false;
            }

            let authService:AuthGuard = appContainer().get(AuthFactory).get();
            authService.check().then(isLogged => {
                if(!isLogged){
                    setTimeout(()=>{
                        let navCtrl = this[property];
                        navCtrl.setRoot(LoginPage);
                    });
                    return false;
                }
                return true;
            })
        }
    }
};
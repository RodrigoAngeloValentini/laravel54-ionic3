import {Injectable} from "@angular/core";
import {Storage} from "@ionic/storage";

@Injectable()
export class AppConfig{
    private off: boolean;
    private appOfKey = 'app_off';

    constructor(public storage:Storage){

    }

    load(){
        return this.storage.get(this.appOfKey).then(off => this.off = off);
    }

    getOff(): boolean {
        return this.off;
    }

    setOff(off: boolean):Promise<any>{
        this.off = off;
        return this.storage.set(this.appOfKey, off);
    }
}
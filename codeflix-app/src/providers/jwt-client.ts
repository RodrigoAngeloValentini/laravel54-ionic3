import { Injectable } from '@angular/core';
import {Headers, RequestOptions, Response} from '@angular/http';
import 'rxjs/add/operator/map';
import {JwtCredentials} from "../models/jwt-credentials";
import {Storage} from "@ionic/storage";
import {AuthHttp, JwtHelper} from "angular2-jwt";
import { Env } from '../models/env';

declare var ENV: Env;

@Injectable()
export class JwtClient {

    private _token = null;
    private _payload = null;

    constructor(public authHttp: AuthHttp, public storage:Storage, public jwtHelper: JwtHelper) {
        this.getToken().then((token) => {

        });
    }

    getPayload(): Promise<Object>{
        return new Promise((resolve) => {
            if(this._payload){
                resolve(this._payload);
            }
            this.getToken().then((token) => {
                if(token){
                    this._payload = this.jwtHelper.decodeToken(token);
                }
                resolve(this._payload);
            });
        })
    }

    getToken(): Promise<string>{
        return new Promise((resolve) => {
            if(this._token){
                resolve(this._token);
            }
            this.storage.get(ENV.TOKEN_NAME).then((token) => {
                this._token = token;
                resolve(this._token);
            })
        })
    }

    setToken(token:string):string{
        this._token = token;
        this.storage.set(ENV.TOKEN_NAME, this._token);
        return this._token;
    }

    accessToken(jwtCredentials: JwtCredentials): Promise<string>{
        return this.authHttp.post(`${ENV.API_URL}/api/access_token`, jwtCredentials)
            .toPromise()
            .then((response: Response) => {
                let token = response.json().token;
                this._token = token;
                this.storage.set(ENV.TOKEN_NAME, this._token);
                return token;
            });
    }

    revokeToken(): Promise<string>{
        let headers = new Headers;
        headers.set('Authorization', `Bearer ${this._token}`);
        let requestOptions = new RequestOptions({headers});
        return this.authHttp.post(`${ENV.API_URL}/api/logout`, {}, requestOptions)
            .toPromise()
            .then((response: Response) => {
                this._token = null;
                this._payload = null;
                this.storage.clear();
                return null;
            });
    }


}

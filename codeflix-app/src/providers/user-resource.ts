import { Injectable } from '@angular/core';
import {Headers, Http, RequestOptions} from '@angular/http';
import 'rxjs/add/operator/toPromise';
import {Env} from "../models/env";

declare var ENV:Env;
/*
  Generated class for the UserResource provider.

  See https://angular.io/docs/ts/latest/guide/dependency-injection.html
  for more info on providers and Angular DI.
*/
@Injectable()
export class UserResource {

  constructor(public http: Http) {
    console.log('Hello UserResource Provider');
  }

  register(accessToken:string):Promise<string>{
      let headers = new Headers();

      headers.set('Authorization', `Bearer ${accessToken}`);
      return this.http.post(`${ENV.API_URL}/api/register`, {}, new RequestOptions({headers}))
          .toPromise()
          .then(response => response.json().token);
  }


}

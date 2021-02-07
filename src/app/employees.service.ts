import { Injectable } from '@angular/core';
import {Employee} from './employee';
import {Observable} from 'rxjs/Observable';
import { HttpClient,HttpParams } from '@angular/common/http';


@Injectable({
  providedIn: 'root'
})
export class EmployeesService {

  url:any;
  employee:Employee;
  params:any;

  constructor(private http: HttpClient) { }

  getallemployees():Observable<Employee>{

    this.url = "http://colombolive.com/bank-assignment/phpfiles/allemployees.php";

     return this.http.get<Employee>(this.url);

  }


  login(params):Observable<Employee>{
   
    this.params = params;

    this.url = "http://colombolive.com/bank-assignment/phpfiles/login.php";

    return this.http.post<Employee>(this.url,params);

  }

}

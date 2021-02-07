import { Component, OnInit } from '@angular/core';
import { HttpClient,HttpParams } from '@angular/common/http';
import { Router } from '@angular/router';
import {EmployeesService} from '../employees.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

  empid:any;
  password:any;
  params:HttpParams;
  url:any;
  data:any;

  constructor(private http: HttpClient,private router:Router,private EmployeesService:EmployeesService) { }

  ngOnInit(): void {
  }


  login(){

    if(this.empid==null||this.password==null){

      alert("employee id or password empty");
      localStorage.removeItem('userdata');

    }else{

      this.params = new HttpParams()
      .set('submit','submit')
      .set('empid',this.empid)
      .set('password',this.password);
  
      

      this.EmployeesService.login(this.params).toPromise().then(data=>{

        this.data = data;
        
        if(this.data.status==1){
          localStorage.setItem('userdata',JSON.stringify(this.data));

          this.router.navigate(['/dashboard']);
        }
        else{
          alert(this.data.message);
          localStorage.removeItem('userdata'); 
        }

      });
      
    }

   
  }

}

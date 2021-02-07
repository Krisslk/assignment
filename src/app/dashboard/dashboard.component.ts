import { Component, OnInit } from '@angular/core';
import{EmployeesService} from '../employees.service';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.css']
})
export class DashboardComponent implements OnInit {

  userdata:any;
  emp_name:any;
  emp_id:any;
  emp_email:any;
  emp_address:any;
  bank_name:any;
  branch_name:any;
  emp_photo:any;
  emplist:any;

  constructor(private employeeservice:EmployeesService) { }

  ngOnInit(): void {

    this.userdata = JSON.parse(localStorage.getItem('userdata'));
    //console.log(this.userdata);
    this.emp_name = this.userdata.emp_name;
    this.emp_id = this.userdata.empid;
    this.emp_email = this.userdata.emp_email;
    this.emp_address = this.userdata.emp_address;
    this.bank_name = this.userdata.bank_name;
    this.branch_name = this.userdata.branch_name;
    this.emp_photo = this.userdata.emp_photo;
  
    this.allemployees();

  }



  allemployees(){

    this.employeeservice.getallemployees().subscribe(data=>{
      this.emplist = data;
    });

  }



}

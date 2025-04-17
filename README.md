# Smart Wage Management System

Welcome to the **Smart Wage Management System** repository! This project is a web-based platform designed to handle payroll and workforce activities for companies of any size. The system provides an intuitive and unified interface for managing employees, attendance, leave applications, payroll, and more. Whether you're an administrator, manager, supervisor, or staff member, the platform offers features tailored to your specific needs.

---

## Table of Contents

- [About](#about)
- [Key Features](#key-features)
- [Usage](#usage)
- [Access Roles](#access-roles)
- [Contributing](#contributing)
- [License](#license)
- [Contact](#contact)

---

## About

The **Smart Wage Management System** is designed to streamline payroll and workforce activities, providing a robust, scalable solution for companies of all sizes. Key functionalities include:

- Managing employee profiles, attendance, and leave applications.
- Generating precise and automated payrolls factoring in benefits and deductions.
- Centralized dashboards for tracking key metrics and administering configurations.

The system uses RFID for accurate timekeeping and offers role-based access for enhanced security and flexibility.

---

## Key Features

### Dashboard
- View an overview of key metrics and summaries.

### Department Management
- Create, view, update, and delete departments.

### Job Title Management
- Create, view, update, and delete departments.

### Employee Management
- Add new employees, view profiles, update information, and monitor leave credits.

### Leave Management
- Create, modify, and remove custom leave types.
- Employees can submit leave applications, review leave history, and access leave records.
- Designated approvers (Admin, Manager, Supervisor) can manage leave applications with statuses such as:
  - Pending
  - Approved
  - Rejected
  - Canceled
  - Expired
  - On Leave
  - Completed
- Leave benefits are managed based on the employee's employment type.

### Timekeeping Management
- Monitor and maintain attendance records using RFID for accurate tracking of working hours and absences.
- Automatic tracking of abscences and resetting of leave credits via cron-jobs.
- Work Schedules can be dynamically managed in the system.
- Breaks can be dynamically managed in the system.

### Payroll Management
- Generate payrolls based on timekeeping data.
- Employees can view their payslips once generated.

### Benefits and Deductions
- Automatically factor in benefits and deductions for precise payroll calculations.

## Access Roles

The system provides detailed role-based access and controls, including:
1. **Admin**
- Full access and control over the entire system.
- Exclusive actions such as: Department Management, Job Title Management, Leave Types Management.
- Ability to edit company profile for header of PDF generation.
- Ability to edit contents of the landing page.

2. **Manager**
- Access to employees over the entire system as well as power to its own department.
- Access to records of employees in its own department.
- Ability to change the pay rate of the employee.
- Ability to add Holidays.
- Ability to manage Leave Requests of its own department.
- Ability to assign and remove allowances and deductions.
- Ability to attendance tracking using RFID.

3. **Supervisor**
- Access to employees over its own supervisees.
- Access to records of its own supervisees.
- Ability to manage Leave Requests of its own supervisees.
- Ability to attendance tracking using RFID.

4. **Staff**
- Designated end users and lowest authorization for the system.
- Ability to monitor its own records (payslip/attendance).
- Ability to attendance tracking using RFID.


Each role has specific access and permissions tailored to their responsibilities.

---

## Usage

To use the system:
1. Clone the repository:
   ```bash
   git clone https://github.com/rlyrvra/case-study.git
   ```
2. Import the database located in database/smart_wage.sql.
3. Log in with [username: admin, password: admin] credentials.

---

## License

This repository is licensed under the [MIT License](LICENSE). You are free to use, modify, and distribute the code under the terms of this license.

---

## Contact

If you have any questions or feedback, feel free to reach out:

## Team Members

- **[rlyrvra](https://github.com/rlyrvra)**  
  Full Stack Developer | QA Tester

- **[hannixminji](https://github.com/hannixminji)**  
  Back End Engineer | Requirements Planner

- **[Shiro-hr](https://github.com/Shiro-Hr)**  
  UI/UX Designer | QA Tester

- **[vane404](https://github.com/vane0404)**  
  UI/UX Designer | Documentation Researcher

- **[carlbryandy](https://github.com/carlbryandy)**  
  UI/UX Designer

- **Issues**: Open an issue in the [Issues section](https://github.com/rlyrvra/smart-wage-management-system/issues).

Thank you for exploring the Smart Wage Management System. We hope it serves as a valuable tool for your organization!

## Documentation
[smartWage_Documentation](https://docs.google.com/document/d/1u0t_vbD5gFRzyKVPBoQUkYPwyvr3N0AZPwosvC8bzPc)
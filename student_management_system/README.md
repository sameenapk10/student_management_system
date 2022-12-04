<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Student Management System

This student management web application includes four Menus, such as:

- Dashboard.
- Staff.
- Students (All Students, Active Students, Inactive Students).
- Student Marks.

## Dashboard

Dashboard gives the discription about the system.

## Staff

Through staff page we can add/edit/delete staff to the system.Validation for staff details given.Staffs with designation 'teacher' will listout in the reporting_teacher drop down in students page.

![image](https://user-images.githubusercontent.com/88235731/205490449-f78aeaa2-9f33-451d-90e3-7cae9e6bead1.png)
we can add staff by clicking the plus button on top of the table.

## Students

Students menu have 3 sub menu( All students, Active Students, Inactive Students) based on the current status of the student ( inactive - means the student was resigned).
In student page we can add/edit/delete students.

![image](https://user-images.githubusercontent.com/88235731/205493088-94fff5a0-e2ad-47d4-abc8-6827e77d83ac.png)

Three dot icon will redirect to 'Student Mark' tab, in which we can add mark details of students.

![image](https://user-images.githubusercontent.com/88235731/205490760-241e0a5f-2e08-40c9-9a30-1646fb4a6f93.png)

## Students Mark
In this system we have two pages to enter mark details

-we can enter from students page ( student mark tab).

-Enter from Students Mark page

![image](https://user-images.githubusercontent.com/88235731/205493149-78ec2240-afe8-4448-aa6c-7fa17d3d0a89.png)


1. Clone this repo
2. `composer install`
3. `cp .env.example .env`
4. Create database and modify .env
5. `php artisan migrate`
6. `php artisan serve`
7. Create staff with designation 'teacher' 
8. Create student 
9. Add mark corresponding to each student ( by clicking three dot icon in students page)
10. Students Mark page also available for CRUD operations in students_marks

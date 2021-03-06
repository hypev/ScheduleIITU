@extends('layouts.admin')
@section('title', 'Timetables | Admin Panel')
@section('timetables', 'active')

@section('content')

<main class="page">
   <h1 class="admin-page-title">
      Timetables
   </h1>
   <div class="container">

      <div class="admin-page-slider">
         <div class="admin-page-slider-content">
            <a href="#" class="admin-page-slider-elem active">
               Groups
            </a>
            <a href="#" class="admin-page-slider-elem">
               Teachers
            </a>
            <a href="#" class="admin-page-slider-elem">
               Rooms
            </a>
         </div>
      </div>
      
   </div>
</main>

@endsection
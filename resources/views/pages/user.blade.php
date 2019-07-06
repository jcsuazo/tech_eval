@extends('layouts.master')
@section('content')
<user-component :userid={{$user->id}}></user-component>
@endsection